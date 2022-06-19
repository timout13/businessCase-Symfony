<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbStreet', NumberType::class,
                [
                    'label' => 'Numéro de rue',
                    'attr' => ['class' => 'form-control mb-3']
                ])
            ->add('addressLine', TextType::class,
                [
                    'label' => 'Adresse',
                    'attr' => ['class' => 'form-control mb-3']
                ]
            )
            ->add('postCode', NumberType::class,
                [
                    'label' => 'Code postal',
                    'attr' => ['class' => 'form-control mb-3']
                ])
            ->add('city', TextType::class,
                [
                    'label' => 'Ville',
                    'attr' => ['class' => 'form-control mb-3']
                ])
            ->add('submit', SubmitType::class,
                [
                    'label' => 'Mettre à jour',
                    'attr' => ['class' => 'btn btn-outline-dark px-5 float-end']
                ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
