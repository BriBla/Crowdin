<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\SourceType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true
            ])

            ->add('langage', ChoiceType::class, [
                'choices' => [
                    'Arabic' => 'AR',
                    'Bengali' => 'BN',
                    'Chinese (Mandarin)' => 'ZH',
                    'English' => 'EN',
                    'French' => 'FR',
                    'German' => 'DE',
                    'Hindi' => 'HI',
                    'Italian' => 'IT',
                    'Japanese' => 'JA',
                    'Portuguese' => 'PT',
                    'Russian' => 'RU',
                    'Spanish' => 'ES',
                ], 'placeholder' => "Choix d'une langue",
                'required' => true
            ])

            ->add('source', FileType::class, [
                'label' => 'Source',
                'mapped' => false,
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
