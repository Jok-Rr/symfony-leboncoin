<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('user', HiddenType::class, [])
      ->add('title', null, [
        'label' => "Titre de l'annonce"
      ])
      ->add('description', TextareaType::class, [
        'label' => "Description de l'annonce"
      ])
      ->add('price', null, [
        'label' => "Prix de l'objet"
      ])
      ->add('category', EntityType::class, [
        'class' => Category::class,
        'choice_label' => 'title',
        'label' => 'Categorie'
      ])
      ->add('Save', SubmitType::class, ['label' => "Valider l'annonce"]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Ad::class,
    ]);
  }
}
