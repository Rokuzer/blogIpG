<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AaaController extends AbstractController
{
    #[Route('/aaa', name: 'app_aaa')]
    public function index(): Response
    {
        return $this->render('aaa/index.html.twig', [
            'controller_name' => 'AaaController',
        ]);
    }
}
