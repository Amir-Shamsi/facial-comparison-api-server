<?php


namespace App\Services\FaceRecognition;


use phpDocumentor\Reflection\Types\This;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FaceRecognition
{
    public static function comparison(string $sourceFilename, string $targetFilename, $prj_directory, Request $request): Response
    {

        $py_file_path = $prj_directory.'/src/Services/FaceRecognition/'.'face_recognition_.py';
        $command = escapeshellcmd('python '.
            $py_file_path.' '.
            $sourceFilename.' '.
            $targetFilename
        );

        $output = shell_exec($command);
        $json_response = json_decode($output);

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'result' => [
                'comparison_result' => $json_response->status,
                'percentage' => $json_response->percentage
            ],
        ],
        Response::HTTP_OK,
        [
            'Content-Type' => 'application/json',
            'Creator' => [
                'Author' => 'Amir Shamsi',
                'Github' => 'https://github.com/amir-shamsi'
            ]
        ]);
    }
}