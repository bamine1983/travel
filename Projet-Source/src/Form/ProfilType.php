<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('nom',TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('prenom',TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('telephone',TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('dateNaissance',  DateType::class ,[
                'widget' => 'single_text',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'years' => range(date('Y'), date('Y')-100),
            ])

            ->add('poste',TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))

            ->add('inscription',  DateType::class ,[
                'widget' => 'single_text',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'years' => range(date('Y'), date('Y')-100),
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}