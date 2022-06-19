<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Products;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
                [
                    'label'=>'Nom du produit',
                    'required'=>true,
                    'attr'=>['class'=>'form-control mb-3']
                ]
            )
            ->add('description', TextareaType::class,
                [
                    'label'=>'Description',
                    'required'=>true,
                    'attr'=>['class'=>'form-control mb-3']
                ])
            ->add('image',FileType::class,
                [
                'label'=>'Upload d\'une image',
                'required'=>false,
                'mapped'=>false,
                'constraints'=> [
                    new File([
                        'maxSize'=>'1024K',
                        'mimeTypes'=>[
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage'=>'Veuillez ajouter une image png ou jpg',
                    ])
                ],
                'attr'=>['class'=>'form-control mb-3']
                ]
            )
            ->add('price', NumberType::class,
                [
                    'label'=>'Prix',
                    'required'=>true,
                    'attr'=>['class'=>'form-control mb-3']
                ]
            )
            ->add('nbStar', NumberType::class,
                [
                    'label'=>'Nombre d\'étoiles',
                    'attr'=>['class'=>'form-control mb-3']
                ])
            ->add('available', CheckboxType::class,
                [
                    'label'=>'Disponible',
                    'required'=>false,
                    'attr'=>['class'=>'form-check mb-3']
                ]
            )
            ->add('flagship', CheckboxType::class,
                [
                    'label'=>'Afficher sur la page d\'accueil',
                    'required'=>false,
                    'attr'=>['class'=>'form-check mb-3']
                ]
            )
            ->add('category', EntityType::class,
                [
                    'label'=>'Catégorie du produit',
                    'class' => Category::class,
                    'attr'=>['class'=>'form-select mb-3']
                ] )
            ->add('brand', EntityType::class,
                [
                    'label'=>'Marque du produit',
                    'class' => Brand::class,
                    'attr'=>['class'=>'form-select mb-3']
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
