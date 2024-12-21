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
            // Nom du médicament
            ->add('nom', TextType::class, [
                'label' => 'Nom du médicament',
                'attr' => ['class' => 'form-control']
            ])

            // Dosage du médicament
            ->add('dosage', TextType::class, [
                'label' => 'Dosage',
                'attr' => ['class' => 'form-control']
            ])

            // Forme du médicament (comprimé, liquide, etc.)
            ->add('forme', TextType::class, [
                'label' => 'Forme',
                'attr' => ['class' => 'form-control']
            ])

            // Prix du médicament
            ->add('prix', NumberType::class, [
                'label' => 'Prix',
                'scale' => 2, // deux décimales
                'attr' => ['class' => 'form-control']
            ])

            // Quantité en stock
            ->add('quantiteenstock', TextType::class, [
                'label' => 'Quantité en stock',
                'attr' => ['class' => 'form-control']
            ])

            // Date limite de validité
            ->add('datelimite', DateType::class, [
                'label' => 'Date limite de validité',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])

            // Description du médicament
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
