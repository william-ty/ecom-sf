<?php

namespace App\Form;

use App\Entity\Picture;
use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ref')
            ->add('title', TextType::class, [])
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
            // Picture Upload
            ->add('pictures', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' =>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
