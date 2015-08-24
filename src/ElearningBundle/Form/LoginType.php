<?php

namespace ElearningBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'text')
            ->add('password', 'text')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elearning_login';
    }
}
