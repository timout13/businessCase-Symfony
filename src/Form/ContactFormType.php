<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('firstname', TextType::class,
                [
                    'label' => 'Prénom',
                    'required' => false,
                    'attr' => ['class' => 'form-control']
                ]
            )
            ->add('lastname', TextType::class,
                [
                    'label' => 'Nom',
                    'required' => false,
                    'attr' => ['class' => 'form-control']
                ]
            )
            ->add('email', EmailType::class,
                [
                    'label' => 'Email',
                    'required' => false,
                    'attr' => ['class' => 'form-control']
                ])
            ->add('message', TextareaType::class,
                [
                    'label' => 'Votre message',
                    'required' => false,
                    'attr' => ['class' => 'form-control']
                ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'form-save btn btn-light']
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
