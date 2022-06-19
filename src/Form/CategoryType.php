<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class,
                [
                    'label'=>'Nom de la catégorie',
                    'required'=>true,
                    'attr'=>['class'=>'form-control']
                ]
            )
            ->add('cat_parent', EntityType::class,
                [
                    'label'=>'Catégorie parente',
                    'class' => Category::class,
                    'attr'=>['class'=>'form-control']
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
