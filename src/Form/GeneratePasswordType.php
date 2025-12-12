<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GeneratePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('passwordLength', IntegerType::class, [
                'label' => 'Password length',
                'data' => 8,
                'attr' => [
                    'min' => 1,
                ],
                'required' => false,
            ])
            ->add('numbers', CheckboxType::class, [
                'label' => 'Numbers (0-9)',
                'required' => false,
            ])
            ->add('lowercase', CheckboxType::class, [
                'label' => 'Small letters (a-z)',
                'required' => false,
            ])
            ->add('uppercase', CheckboxType::class, [
                'label' => 'Big letters (A-Z)',
                'required' => false,
            ])
            ->add('generate', SubmitType::class, [
                'label' => 'GENERATE',
            ])
            ->setMethod('POST')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
