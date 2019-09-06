<?php

namespace App\Form;

use App\Entity\Courses;
use App\Entity\Posts;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserNewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = null;
        $builder
            ->add('data')
            ->add('course', EntityType::class, [
                'class' => Courses::class,
                'choice_label' => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}