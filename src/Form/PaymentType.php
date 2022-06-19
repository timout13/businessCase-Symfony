<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('payment_type', ChoiceType::class,
                [
                    'choices' => [
                        'Paypal' => 'paypal',
                        'Carte bancaire' => 'visa',
                    ],
                    'expanded' => true
                ])
            ->add('submit', SubmitType::class,
                [
                    'label' => 'Mettre à jour',
                    'attr' => ['class' => 'btn btn-outline-dark px-5']
                ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
