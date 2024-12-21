<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;  // Ajoutez cette ligne pour EmailType
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('datecommande', DateType::class, [
                'label' => 'datecommande',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('nomclient', TextType::class, [
                'label' => 'nomclient',
                'attr' => ['class' => 'form-control']
            ])
            ->add('telephoneclient', IntegerType::class, [
                'label' => 'telephone du client',
                'attr' => ['class' => 'form-control']
            ])
            ->add('emailclient', EmailType::class, [  // Ici on utilise EmailType
                'label' => 'email du client',
                'attr' => ['class' => 'form-control']
            ])
            ->add('medicammentcommande', TextType::class, [
                'label' => 'medicammentCommande',
                'attr' => ['class' => 'form-control']
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
