<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Email"
            ])
            ->add('firstName', TextType::class, [
                'error_bubbling' => true,
                'label' => 'Имя',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Пожалуйста введите имя'
                    ])
                ]
            ])
            ->add('lastName', TextType::class, [
                'error_bubbling' => true,
                'label' => 'Фамилия',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Пожалуйста введите фамилию'
                    ])
                ]
            ])
            ->add('patronymic', TextType::class, [
                'error_bubbling' => true,
                'label' => 'Отчество',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Пожалуйста введите отчество'
                    ])
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'error_bubbling' => true,
                'label' => 'Пароль',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Пожалуйста введите пароль',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Пароль должен быть не меньше {{ limit }} символов',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
