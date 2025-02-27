<?php

namespace App\Form;

use App\Entity\Medicament;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du médicament',
                'attr' => ['class' => 'form-control']
            ])
            ->add('dosage', TextType::class, [
                'label' => 'Dosage',
                'attr' => ['class' => 'form-control']
            ])
            ->add('forme', TextType::class, [
                'label' => 'Forme',
                'attr' => ['class' => 'form-control']
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix',
                'scale' => 2,
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1, // Empêche d'entrer une valeur négative ou zéro
                    'step' => '0.01' // Permet d'avoir des valeurs décimales
                ]
            ])
            ->add('quantiteenstock', NumberType::class, [
                'label' => 'Quantité en stock',
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0, // ✅ Empêche les valeurs négatives
                    'step' => '1' // ✅ Assure que c'est un nombre entier
                ]
            ])
            
            ->add('datelimite', DateType::class, [
                'label' => 'Date limite de validité',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medicament::class,
        ]);
    }
}
