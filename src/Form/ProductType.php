<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('user', null, [
                // Le choice_label permet de définir la propriété à afficher de l'objet User
                'choice_label' => 'username',
            ])
            ->add('category', null, [
                'choice_label' => 'name',
            ])
            ->add('tags', null, [
                'choice_label' => 'name',
                'expanded' => 'true', // On veut des checkboxes au lieu d'un select multiple
            ])
            ->add('description')
            ->add('price')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
