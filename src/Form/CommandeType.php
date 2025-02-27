<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;  // Import EmailType
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datecommande', DateType::class, [
                'label' => 'Date de commande',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('nomclient', TextType::class, [
                'label' => 'Nom du client',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('telephoneclient', TextType::class, [
                'label' => 'Téléphone du client',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Exemple : 0123456789',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le numéro de téléphone est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^\d{10}$/',
                        'message' => 'Le numéro de téléphone doit comporter exactement 10 chiffres.',
                    ]),
                ],
            ])
            ->add('emailclient', EmailType::class, [
                'label' => 'Email du client',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Exemple : username@gmail.com',
                ],
                'constraints' => [
        new NotBlank([
            'message' => 'L\'email est obligatoire.',
        ]),
        new Regex([
            'pattern' => '/^[a-zA-Z0-9._%+-]+@gmail\.com$/',  // Expression régulière pour @gmail.com
            'message' => 'L\'email doit être sous la forme "username@gmail.com".',
        ]),
    ],
            ])
            ->add('medicammentcommande', TextType::class, [
                'label' => 'Médicaments commandés',
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
