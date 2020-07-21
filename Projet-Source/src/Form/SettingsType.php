<?php

namespace App\Form;

use App\Entity\Settings;
use App\Entity\Timezones;
use App\Entity\User;
use DateTime;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{DateType, FileType, IntegerType, SubmitType, TextType};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NomSite',TextType::class,array(
                'attr' => array(
                    'class' => 'form-control',

                )))
            ->add('Logo',FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                    ])
                ],
            ])
            ->add('Favicon',FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                    ])
                ],
            ])
            ->add('DureeSessions',IntegerType::class, array(
                'attr' => array(
                    'class' => 'form-control',

                )))
            ->add('DureeInactivite',IntegerType::class, array(
                'attr' => array(
                    'class' => 'form-control',

                )))
            ->add('Sauvegarder',SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-primary',

                )))
            ->add('fuseauHoraire',EntityType::class,[
                'class'=>Timezones::class,
                'choice_label'=>'timezoneDetail',
                'attr' => array(
                    'class' => 'form-control',

                )
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Settings::class,
        ]);
    }
}
