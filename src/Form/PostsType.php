<?php

namespace App\Form;

use App\Entity\Courses;
use App\Entity\Posts;
use App\Entity\PostTypes;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('data')
            ->add('type', EntityType::class, [
                'class' => PostTypes::class,
                'choice_label' => 'name'
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'firstName'
            ])
            ->add('course', EntityType::class, [
                'class' => Courses::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
