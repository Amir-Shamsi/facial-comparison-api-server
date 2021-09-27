<?php

namespace App\Controller;

use App\Api\FaceUploadApiModel;
use App\Services\ApiImageValidation;
use App\Services\FaceRecognition\FaceRecognition;
use App\Services\FileService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * Class FRApiController
 * @package App\Controller
 * @Route ("/api", name="api_facial_rec")
 */
class FRApiController extends AbstractController
{
    /**
     * @Rest\Post("/facial-rec")
     * @param Request $request
     * @param LoggerInterface $logger
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function apiLauncher(Request $request, LoggerInterface $logger, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {
        $destination = $this->getParameter('kernel.project_dir') . '\public\assets\img\temp\downloads\\';

        if ($request->headers->get('Content-Type') === 'application/json') {
            /** @var FaceUploadApiModel $uploadApiModel */
            try {
                $uploadApiModel = $serializer->deserialize(
                    $request->getContent(),
                    FaceUploadApiModel::class,
                    'json'
                );
                $violations = $validator->validate($uploadApiModel);
                if ($violations->count() > 0) {
                    $logger->info("validation failure");
                    return $this->json($violations, Response::HTTP_BAD_REQUEST);
                }
            } catch (\Exception $error){
                return $this->json(['exception' => $error->getMessage(), ], Response::HTTP_BAD_REQUEST);
            }
            $originalSourceFilename = $uploadApiModel->sourceFace;
            $originalTargetFilename = $uploadApiModel->targetFace;

            $originalSourceFilename = FileService::url_parse_filename($originalSourceFilename);
            $originalTargetFilename = FileService::url_parse_filename($originalTargetFilename);

            if(!$originalSourceFilename || !$originalTargetFilename){
                $logger->info("url not exist!");
                return $this->json([
                    'urls' => [!$originalSourceFilename? 'sourceFace_url':'',!$originalTargetFilename?'targetFace_url':''] ,
                    'error' => 'url is in a wrong format!'
                    ], Response::HTTP_BAD_REQUEST);
            }
            if ($violations->count() > 0) {
                $logger->info("validation failure");
                return $this->json($violations, Response::HTTP_BAD_REQUEST);
            }
            $sourceFilename = FileService::getUniqueFilename($originalSourceFilename);
            $targetFilename = FileService::getUniqueFilename($originalTargetFilename);

            $sourceContent =FileService::create_file(
                $destination,
                $sourceFilename,
                file_get_contents($uploadApiModel->sourceFace)
            );

            $targetContent =FileService::create_file(
                $destination,
                $targetFilename,
                file_get_contents($uploadApiModel->targetFace)
            );

            if(!$sourceContent && !$targetContent) {
                $logger->info("image download failure");
                return $this->json([$sourceContent, $targetContent], Response::HTTP_NO_CONTENT);
            }
        } else {
            /** @var UploadedFile $sourceFile */
            $sourceFile = $request->files->get('sourceFile');
            $targetFile = $request->files->get('targetFace');

            $sourceFilename = FileService::getUniqueFilename(
                $sourceFile->getClientOriginalName().
                $sourceFile->guessExtension()
            );
            $targetFilename = FileService::getUniqueFilename(
                $targetFile->getClientOriginalName().
                $targetFile->guessExtension()
            );

            $sourceFile->move(
                $destination,
                $sourceFilename
            );
            $targetFile->move(
                $destination,
                $targetFilename
            );
        }
        $validate = new ApiImageValidation($validator);
        $sourceViolations = $validate->image_validate(
            $destination.
            $sourceFilename
        );

        $targetViolations = $validate->image_validate(
            $destination.
            $targetFilename
        );

        if ($sourceViolations->count() > 0 || $targetViolations->count() > 0) {
            $logger->info("validation failure");
            return $this->json([$sourceViolations, $targetViolations], Response::HTTP_BAD_REQUEST);
        }

        return FaceRecognition::comparison($sourceFilename, $targetFilename);

    }

    /**
     * @Rest\Post("/face-rec/response")
     */
    public function apiResponse()
    {

    }


    /**
     * @return Response
     */
    public function apiViewIndex(): Response
    {
        return $this->render('fr_api/index.html.twig');
    }
}
