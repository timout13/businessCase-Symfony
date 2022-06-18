<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Products;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
                [
                    'required'=>true,
                    'attr'=>['class'=>'form-control']
                ]
            )
            ->add('description', TextareaType::class,
                [
                    'required'=>true,
                    'attr'=>['class'=>'form-control']
                ])
            ->add('image')
            ->add('price', NumberType::class,
                [
                    'required'=>true,
                    'attr'=>['class'=>'form-control']
                ]
            )
            ->add('nbStar', NumberType::class,
                [
                    'attr'=>['class'=>'form-control']
                ])
            ->add('available', CheckboxType::class,
                [
                    'attr'=>['class'=>'form-control']
                ]
            )
            ->add('flagship', CheckboxType::class,
                ['required'=>true,
                    'attr'=>['class'=>'form-control']
                ]
            )
            ->add('category', EntityType::class,
                [
                    'class' => Category::class,
                    'attr'=>['class'=>'form-control']
                ] )
            ->add('brand', EntityType::class,
                [
                    'class' => Brand::class,
                    'attr'=>['class'=>'form-control']
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
