<?php

namespace App\Controller;

use App\Entity\Ad;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
  #[Route('/', name: 'app_home')]
  public function index(ManagerRegistry $doctrine): Response
  {

    $entityManager = $doctrine->getManager();

    $ads = $entityManager->getRepository(Ad::class)->findAll();

    return $this->render('home/home.html.twig', ['ads' => $ads]);
  }
}
