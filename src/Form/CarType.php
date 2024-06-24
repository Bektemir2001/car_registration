<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
	    $builder
		    ->add('ownerName', null, [
			    'label' => 'Имя владельца',
			    'attr' => ['class' => 'form-control'],
			    'label_attr' => ['class' => 'form-label'],
		    ])
		    ->add('brand', null, [
			    'label' => 'Марка',
			    'attr' => ['class' => 'form-control'],
			    'label_attr' => ['class' => 'form-label'],
		    ])
		    ->add('model', null, [
			    'label' => 'Модель',
			    'attr' => ['class' => 'form-control'],
			    'label_attr' => ['class' => 'form-label'],
		    ])
	    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
