<?php

namespace App\Form;

use App\Entity\Courses;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
//            ->add('roles', ChoiceType::class, [
//                'choices' => [
//                    'admin' =>'ROLE_ADMIN',
//                    'user' => 'ROLE_USER'
//                ]
//            ])
            ->add('password', PasswordType::class)
            ->add('firstName')
            ->add('lastName')
            ->add('courses', EntityType::class, [
                'class' => Courses::class,
                'choice_label' => 'name',
                'multiple' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
