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
	        ->add('ownerName', null, [
		        'label' => 'Имя владельца',
		        'attr' => ['class' => 'form-control'],
		        'label_attr' => ['class' => 'form-label'],
	        ])
	        ->add('number', null, [
		        'label' => 'номер авто',
		        'attr' => ['class' => 'form-control'],
		        'label_attr' => ['class' => 'form-label'],
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
