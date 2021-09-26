<?php

namespace App\Controller;

use App\Api\FaceUploadApiModel;
use App\Services\FileService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File as FileObject;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
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

            $sourceContent = file_get_contents($originalSourceFilename);
            $targetContent = file_get_contents($originalTargetFilename);

            if($sourceContent && $targetContent) {
                $destination = $this->getParameter(
                        'kernel.project_dir') . '\public\assets\img\temp\downloads\\';
                $originalSourceFilename = pathinfo($originalSourceFilename, PATHINFO_FILENAME);
                $originalTargetFilename = pathinfo($originalTargetFilename, PATHINFO_FILENAME);


                $sNewFilename = FileService::getUniqueFilename($originalSourceFilename);
                $tNewFilename = FileService::getUniqueFilename($originalTargetFilename);

                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $image = 'assets\img\uploads\\' . $jdate->date('Y') . '\\' . $jdate->date('m') . '\\' . $newFilename;
                $user->setUserAvatar($image);
            } else {
                    $logger->info("image download failure");
                    return $this->json($violations, Response::HTTP_NO_CONTENT);
            }
        } else {

        }


        $violations = $validator->validate(
            $uploadedFile,
            [
                new NotBlank([
                    'message' => 'Please select file to upload!'
                ]),
                new File([
                    'maxSize' => '5M',
                    'mimeTypes' => [
                        'image/*'
                    ],
                    'maxSizeMessage' => 'Oops! Image is bigger than what I expected!',
                    'mimeTypesMessage' => 'This file is not an image!'
                ]),

            ]
        );
        if ($violations->count() > 0) {
            $logger->info("validation failure");
            return $this->json($violations, Response::HTTP_BAD_REQUEST);
        }

        return $this->json('ok!', Response::HTTP_ACCEPTED);


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
