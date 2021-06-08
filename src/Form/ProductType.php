<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Picture;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ref')
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('inStock')
            ->add('stockQuantiy')
            ->add('category', EntityType::class, [
                "class" => Category::class,
                'placeholder' => '--Choisir une catégorie--',
                'label' => 'Category',
                'multiple' => false,
                'choice_label' => 'label'

            ])
            //TODO : Input Upload Picture

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
