<?php

namespace ElearningBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('email', 'text')
            ->add('password', 'repeated', ['type' => 'password',
                'invalid_message' => 'Password confirm does not match !!',
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password'],])
            ->add('active', 'hidden')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ElearningBundle\Entity\User',
            'csrf_protection' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elearningbundle_user';
    }
}
