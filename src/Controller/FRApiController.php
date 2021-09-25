<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class FRApiController
 * @package App\Controller
 * @Route ("/api", name="api_face_rec")
 */
class FRApiController extends AbstractController
{
    /**
     * @Rest\Post("/face-rec")
     */
    public function apiLauncher(Request $request, LoggerInterface $logger): Response
    {
        $token = $request->get("token");

        if (!$this->isCsrfTokenValid('upload', $token))
        {
            $logger->info("CSRF failure");

            return new Response("Operation not allowed",  Response::HTTP_BAD_REQUEST,
                ['content-type' => 'application/json']);
        }

        
    }

    /**
     * @Rest\Post("/face-rec/response")
     */
    public function apiResponse()
    {

    }
}
