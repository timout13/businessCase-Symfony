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
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('category', EntityType::class, ['required' => false,
                'query_builder' => function (EntityRepository $entityRepository) use ($catId) {
                    return $entityRepository->createQueryBuilder('c')
                        ->where('c.cat_parent = :idCatParent')
                        ->setParameter('idCatParent', $catId);
                },
                'class' => Category::class,
                'placeholder' => 'false',
                'attr' => ['class' => 'form-select']
            ])
            ->add('brand', EntityType::class, ['required' => false,
                'class' => Brand::class,
                'placeholder' => 'Choisissez une marque',
                'attr' => ['class' => 'form-select',]
            ])
            ->add('nbStars', ChoiceType::class,
                [
                    'required' => false,
                    'choices' =>
                        [
                            'stars 1' => 1,
                            'stars 2' => 2,
                            'stars 3' => 3,
                            'stars 4' => 4,
                            'stars 5' => 5],
                    'expanded' => true,
                    'multiple' => true,
                    'attr' => ['class' => 'form-control'],
                ])
            ->add('minPrice', NumberType::class,
                [
                    'required' => false,
                    'attr' => ['class' => 'form-control'],
                ])
            ->add('maxPrice', NumberType::class,
                [
                    'required' => false,
                    'attr' => ['class' => 'form-control'],
                ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-dark'],

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setRequired([
            'catId',
        ]);
    }
}
