<?php

namespace App\Form;

use App\Entity\OpeningHours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpeningHoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Générer les choix horaires de 08h à 20h
        $hours = [];
        for ($i = 8; $i <= 20; $i++) {
            $time = sprintf('%02d:00', $i);
            $hours[$time] = $time;
        }

        $builder
            ->add('day', ChoiceType::class, [
                'choices' => [
                    'Lundi' => 'Lundi',
                    'Mardi' => 'Mardi',
                    'Mercredi' => 'Mercredi',
                    'Jeudi' => 'Jeudi',
                    'Vendredi' => 'Vendredi',
                    'Samedi' => 'Samedi',
                    'Dimanche' => 'Dimanche',
                ],
                'label' => 'Jour de la semaine',
            ])
            ->add('openingTime', ChoiceType::class, [
                'choices' => $hours,
                'label'  => 'Heure d\'ouverture',
                'required' => true,
            ])
            ->add('closingTime', ChoiceType::class, [
                'choices' => $hours,
                'label'  => 'Heure de fermeture',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OpeningHours::class,
        ]);
    }
}
