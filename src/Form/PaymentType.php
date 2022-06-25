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
                    'label'=>'Types de paiements :',
                    'choices' => [
                        'Paypal' => 'paypal',
                        'Carte bancaire' => 'visa',
                    ],
                    'choice_attr' => [
                        'Paypal' => ['class' => 'payment-radio-btn ms-5 me-3'],
                        'Carte bancaire' => ['class' => 'payment-radio-btn ms-5 me-3'],
                    ],
                    'attr'=>['class'=>'payment-radio position-relative gap-5 my-3 d-flex flex-wrap justify-content-start justify-content-md-center align-items-center'],
                    'expanded' => true
                ])
            ->add('submit', SubmitType::class,
                [
                    'label' => 'Valider la commande',
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
