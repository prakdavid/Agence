<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\PropertyOption;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat')
            ->add('city')
            ->add('adress')
            ->add('postal_code')
            ->add('sold')
            ->add('rooms')
            ->add('propertyOptions', EntityType::class, [
                'class' => PropertyOption::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }
}
