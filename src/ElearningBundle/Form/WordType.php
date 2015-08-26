<?php

namespace ElearningBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('category', 'entity', ['class' => 'ElearningBundle:Category',
                'property' => 'name'])
            ->add('answers', 'collection', ['type' => new AnswerType()])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ElearningBundle\Entity\Word'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elearning_admin_word';
    }
}
