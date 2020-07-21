<?php

namespace App\Form;

use App\Entity\Agences;
use App\Entity\Pays;
use App\Entity\User;
use App\Entity\Villes;
use Cassandra\Type\UserType;
use Symfony\Component\Form\Extension\Core\Type\{CheckboxType,
    ChoiceType,
    DateType,
    EmailType,
    FileType,
    PasswordType,
    SubmitType,
    TextType};
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AgenceCreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NomAgence',TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))

            ->add('Adresse',TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))

            ->add('CodePostal',TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('Telephone',TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('Email',        EmailType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('Fax',TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))

            ->add('logo',FileType::class, [
                'label' => 'Logo (image)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                    ])
                ],
            ])

            ->add('DateCreation',DateType::class ,[
                'widget' => 'single_text',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'years' => range(date('Y'), date('Y')-100),
            ])

            ->add('NombreEmployes',TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))

            ->add('NomDirecteur',TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))

            ->add('TelephoneDirecteur',TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('EmailDirecteur',        EmailType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))

            ->add('Sauvegarder', SubmitType::class,array(
                'attr'=>array(
                    'class'=>'btn btn-primary btn-md',
                )
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Agences::class,
        ]);
    }
}
