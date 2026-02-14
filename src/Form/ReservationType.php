<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputClasses = 'bg-transparent border-b border-light-rose/30 text-light-rose w-full py-2 focus:outline-none focus:border-light-rose transition-colors placeholder:text-light-rose/20';

        $builder
            ->add('clientName', TextType::class, [
                'label' => 'Vaše jméno', //Your Name
                'attr' => [
                    'class' => $inputClasses,
                    'placeholder' => 'Ange Traore'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'class' => $inputClasses,
                    'placeholder' => 'angetraore.dev@gmail.com'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'Telefonní číslo',
                'attr' => [
                    'class' => $inputClasses,
                    'placeholder' => '+420 ...'
                ]
            ])
            ->add('guestCount', IntegerType::class, [
                'label' => 'Počet osob',
                'attr' => [
                    'class' => $inputClasses,
                    'min' => 1,
                    'max' => 20
                ]
            ])
            ->add('reservationAt', DateTimeType::class, [
                'label' => 'Datum a čas',
                'widget' => 'single_text',
                'attr' => [
                    'class' => $inputClasses
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
