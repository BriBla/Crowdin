<?php

namespace App\Form;

use App\Entity\UserLangue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('langue_name', ChoiceType::class, [
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserLangue::class,
        ]);
    }
}
