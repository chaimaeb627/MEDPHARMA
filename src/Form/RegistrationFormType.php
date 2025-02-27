<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'L\'adresse email est obligatoire.',
                    ]),
                    new Assert\Email([
                        'message' => 'Veuillez entrer une adresse email valide.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
                        'message' => 'L\'adresse email doit être au format username@gmail.com.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'constraints' => [
                        new Assert\NotBlank([
                            'message' => 'Le mot de passe est obligatoire.',
                        ]),
                        new Assert\Length([
                            'min' => 6,
                            'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
                        ]),
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmez le mot de passe',
                ],
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
