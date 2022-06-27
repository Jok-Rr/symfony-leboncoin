<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

  #[Route('/deposer-mon-anonce', name: 'add_ad')]
  public function addAd(ManagerRegistry $doctrine, Request $request): Response
  {
    $entityManager = $doctrine->getManager();
    $ad = new Ad();

    $form  = $this->createForm(AdFormType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $data = $form->getData();

      $ad->setUser($this->getUser());
      $ad->setTitle($data->getTitle());
      $ad->setCategory($data->getCategory());
      $ad->setPrice($data->getPrice());
      $ad->setDescription($data->getDescription());
      $ad->setCreatedAt(new \DateTimeImmutable('now'));
      $ad->setUpdatedAt(new \DateTimeImmutable('now'));

      $entityManager->persist($ad);

      $entityManager->flush();

      return $this->redirectToRoute('app_home');
    }


    return $this->renderForm('ad/addad.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/ad/{id}', name: 'app_view_ad')]
  public function viewAd($id, ManagerRegistry $doctrine): Response
  {
    $entityManager = $doctrine->getManager();

    $data = $entityManager->getRepository(Ad::class)->find($id);

    return $this->render('ad/view.html.twig', [
      'data' => $data
    ]);
  }

  #[Route('/ad/delete/{id}', name: 'app_delete_ad')]
  public function deleteAd($id, ManagerRegistry $doctrine): Response
  {
    $entityManager = $doctrine->getManager();

    $adTarget = $entityManager->getRepository(Ad::class)->find($id);

    $entityManager->getRepository(Ad::class)->remove($adTarget);

    $entityManager->flush();

    return $this->redirectToRoute('app_home');
  }

  #[Route('/ad/edit/{id}', name: 'app_edit_ad')]
  public function editAd(ManagerRegistry $doctrine, Request $request, $id): Response
  {
    $entityManager = $doctrine->getManager();
    $data = $entityManager->getRepository(Ad::class)->find($id);

    $ad = new Ad();

    $ad->setTitle($data->getTitle());
    $ad->setCategory($data->getCategory());
    $ad->setPrice($data->getPrice());
    $ad->setDescription($data->getDescription());

    $form = $this->createForm(AdFormType::class, $ad);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $dataForm = $form->getData();

      $data->setTitle($dataForm->getTitle());
      $data->setCategory($dataForm->getCategory());
      $data->setPrice($dataForm->getPrice());
      $data->setDescription($dataForm->getDescription());
      $data->setUpdatedAt(new \DateTimeImmutable('now'));

      $entityManager->flush();

      return $this->redirectToRoute('app_view_ad', array('id' => $data->getId()));
    }

    return $this->renderForm('ad/edit.html.twig', ['form' => $form]);
  }
}
