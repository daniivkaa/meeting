<?php

namespace App\Form;

use App\Entity\Subject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Название предмета"
            ])
            ->add('teacherFirstName', TextType::class, [
                'label' => "Имя преподавателя"
            ])
            ->add('teacherLastName', TextType::class, [
                'label' => "Фамилия преподавателя"
            ])
            ->add('teacherPatronymic', TextType::class, [
                'label' => "Отчество преподавателя"
            ])
            ->add('sessionId', HiddenType::class, [
                'data' => "1",
                "mapped" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subject::class,
        ]);
    }
}
