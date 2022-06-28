<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
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
        $catId = $options['catId'];
        $builder
            ->add('searchBar', TextType::class, [
                'label'=>'Mot-clé :',
                'required' => false,
                'attr' => ['class' => 'form-control mb-3 mt-2'],
            ])
            ->add('category', EntityType::class, [
                'required' => false,
                'query_builder' => function (EntityRepository $entityRepository) use ($catId) {
                    return $entityRepository->createQueryBuilder('c')
                        ->where('c.cat_parent = :idCatParent')
                        ->setParameter('idCatParent', $catId);
                },
                'label'=>'Sous-catégorie :',
                'class' => Category::class,
                'placeholder' => 'Choisissez une sous-catégorie',
                'attr' => ['class' => 'form-select mb-3 mt-2']
            ])
            ->add('brand', EntityType::class, [
                'label'=>'Marque :',
                'required' => false,
                'class' => Brand::class,
                'placeholder' => 'Choisissez une marque',
                'attr' => ['class' => 'form-select mb-3 mt-2']
            ])
            ->add('nbStars', ChoiceType::class,
                [
                    'label'=>'Nombres d\'étoiles :',
                    'required' => false,
                    'choices' =>
                        [
                            '1' => 1,
                            '2' => 2,
                            '3' => 3,
                            '4' => 4,
                            '5' => 5
                        ],
                    'choice_attr' => [
                        '1' => ['class' => 'ms-3 me-2'],
                        '2' => ['class' => 'ms-3 me-2'],
                        '3' => ['class' => 'ms-3 me-2'],
                        '4' => ['class' => 'ms-3 me-2'],
                        '5' => ['class' => 'ms-3 me-2'],
                    ],
                    'expanded' => true,
                    'multiple' => true,
                    'attr' => ['class' => 'form-control mb-3 mt-2'],
                ])
            ->add('minPrice', NumberType::class,
                [
                    'label'=>'Prix minimum :',
                    'required' => false,
                    'attr' => ['class' => 'form-control mb-3 mt-2'],
                ])
            ->add('maxPrice', NumberType::class,
                [
                    'label'=>'Prix maximum :',
                    'required' => false,
                    'attr' => ['class' => 'form-control mb-3 mt-2'],
                ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-dark'],
                'label'=>'Rechercher',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setRequired([
            'catId',
        ]);
    }
}
