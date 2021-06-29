<?php

namespace App\Form;

use App\Entity\Traduction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TraductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sourcekey', TextType::class, [
                'label' => 'Source',
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

            ->add('translation', TextType::class, [
                'label' => 'Texte',
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Traduction::class,
        ]);
    }
}
