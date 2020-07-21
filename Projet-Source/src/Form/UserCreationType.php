<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{CheckboxType,
    ChoiceType,
    DateType,
    EmailType,
    PasswordType,
    SubmitType,
    TextType};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserCreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',         EmailType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('password',      PasswordType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('role',          ChoiceType::class, array(
                'choices' => array(
                    'Admin' => 'Administrateur',
                    'Editeur' => 'Editeur',
                ),
                'attr'=>array(
                    'class' => 'form-control'
                )
            ))
            ->add('nom',            TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('prenom',         TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('telephone',      TextType::class, array(
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
                    'class' => 'form-control',
                    'required'=>true
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
            'data_class' => User::class,
        ]);
    }
}
