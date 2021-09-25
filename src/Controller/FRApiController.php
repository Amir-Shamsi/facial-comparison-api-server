<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FRApiController extends AbstractController
{

    public function apiLauncher(): Response
    {
        return $this->render('fr_api/index.html.twig', [
            'controller_name' => 'FRApiController',
        ]);
    }
}
