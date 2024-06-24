<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\OwnerHistory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ownerName')
            ->add('registrationDate', null, [
                'widget' => 'single_text',
            ])
            ->add('car', EntityType::class, [
                'class' => Car::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OwnerHistory::class,
        ]);
    }
}
