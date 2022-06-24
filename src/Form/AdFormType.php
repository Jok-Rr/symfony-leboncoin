<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('user', HiddenType::class, [])
      ->add('title')
      ->add('description')
      ->add('price')
      ->add('category', EntityType::class, [
        'class' => Category::class,
        'choice_label' => 'title'
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
