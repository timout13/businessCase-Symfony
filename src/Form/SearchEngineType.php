<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchEngineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('searchBar', TextType::class, ['required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('category', EntityType::class, ['required' => false,
                'class' => Category::class,
                'attr' => ['class' => 'form-control', 'multiple'=>'']
            ])
            ->add('nbStars', ChoiceType::class, ['required' => false,
                'choices' =>
                    [
                        '1 stars' => 1,
                        'stars 2' => 2,
                        'stars 3' => 3,
                        'stars 4' => 4,
                        'stars 5' => 5],
                'expanded' => true,
                'multiple' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('minPrice', NumberType::class,
                [
                    'required' => false,
                    'attr'=>['class'=>'form-control']
                ])
            ->add('maxPrice', NumberType::class,
                [
                    'required' => false,
                    'attr'=>['class'=>'form-control']
                ])
            ->add('save', SubmitType::class, [
                'attr'=>['class'=>'btn btn-dark']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
