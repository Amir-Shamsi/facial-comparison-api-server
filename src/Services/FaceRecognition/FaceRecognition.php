<?php


namespace App\Services\FaceRecognition;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FaceRecognition
{
    public static function comparison(string $sourceFilename, string $targetFilename): Response
    {
        $command = escapeshellcmd('python face_recognition_.py '.$sourceFilename.' '.$targetFilename);
        $output = shell_exec($command);
        $response = explode('&', $output);
        $result = $response[0] === true || $response[0] === 'True' || $response[0] === 'true';
        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'result' => [
                'comparison_result' => $result,
                'percentage' => (int)$response[1]
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