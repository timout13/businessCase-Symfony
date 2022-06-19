<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('email', EmailType::class,
                [
                    'label' => 'Email',
                    'attr' => ['class' => 'form-control mb-3']
                ])
            ->add('password', PasswordType::class,
                [
                    'label' => 'Mot de passe',
                    'attr' => ['class' => 'form-control mb-3']
                ])
            ->add('firstname', TextType::class,
                [
                    'label' => 'Prénom',
                    'attr' => ['class' => 'form-control mb-3']
                ])
            ->add('lastname', TextType::class,
                [
                    'label' => 'Nom',
                    'attr' => ['class' => 'form-control mb-3']
                ])
            ->add('birthday', TextType::class,
                [
                    'label' => 'Date de naissance',
                    'attr' => ['class' => 'form-control mb-3']
                ])
            ->add('genre', ChoiceType::class,
                [
                    'label' => 'Genre',
                    'choices' => [
                        'Homme' => 'Homme',
                        'Femme' => 'Femme',
                        'Autre' => 'Autre',
                    ],
                    'attr' => ['class' => 'form-control mb-3']
                ])
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
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
