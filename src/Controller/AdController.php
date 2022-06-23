<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    #[Route('/ad', name: 'app_ad')]
    public function index(): Response
    {
        return $this->render('ad/index.html.twig', [
            'controller_name' => 'AdController',
        ]);
    }
}
