<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price', MoneyType::class, [
                'currency' => 'USD',
                'label' => 'Prix',
                'attr' => ['placeholder' => 'Prix en USD'],
            ])
            ->add('year', TextType::class, [
                'label' => 'Année de mise en circulation',
                'attr' => ['placeholder' => 'Année de mise en circulation'],
            ])
            ->add('mileage', IntegerType::class, [
                'label' => 'Kilométrage',
                'attr' => ['placeholder' => 'Kilométrage en km'],
            ])
            ->add('mainImage', FileType::class, [
                'label' => 'Image principale',
                'mapped' => false,
                'required' => true,
                'attr' => ['accept' => 'image/*'],
            ])
            ->add('gallery', FileType::class, [
                'label' => 'Galerie d\'images',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'attr' => ['accept' => 'image/*'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['placeholder' => 'Description détaillée du véhicule'],
            ])
            ->add('features', ChoiceType::class, [
                'label' => 'Équipements et options',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'Climatisation' => 'climatisation',
                    'GPS' => 'gps',
                    'Cruise Control' => 'cruise_control',
                ],
            ])
            ->add('options', ChoiceType::class, [
                'label' => 'Options supplémentaires',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'ABS' => 'abs',
                    'Airbags' => 'airbags',
                    'Sièges chauffants' => 'sièges_chauffants',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
