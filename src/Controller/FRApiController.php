<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
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
    public function apiLauncher(Request $request): Response
    {

    }

    /**
     * @Rest\Post("/face-rec/response")
     */
    public function apiResponse()
    {

    }
}
