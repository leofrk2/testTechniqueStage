<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PseudoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo1', null, [
                'label' => 'Pseudo du joueur 1 : ',
                'attr' => [
                    'placeholder' => 'Entrer votre pseudo...',
                    'class' => 'form-control',
                ],
            ])->add('pseudo2', null, [
                'label' => 'Pseudo du joueur 2 : ',
                'attr' => [
                    'placeholder' => 'Entrer votre pseudo...',
                    'class' => 'form-control',
                ],
            ])
            ->add('Continuer', SubmitType::class, ['attr' => ['class' => 'btn btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
