<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AchatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom et Prénom',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez votre nom']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez votre email']
            ])
            ->add('telephoneclient', TextType::class, [
                'label' => 'Téléphone du client',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Exemple : 0123456789']
                ])
                
            ->add('submit', SubmitType::class, [
                'label' => 'Acheter',
                'attr' => ['class' => 'btn btn-success w-100 mt-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
