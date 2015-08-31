<?php

namespace ElearningBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'entity', [
                  'class' => 'ElearningBundle:Category',
                  'property' => 'name',
                  'empty_value' => "All Category",
                  'required' => false
                  ])
            ->add('type_word', 'choice', [
                  'choices' => [
                      'learned' => 'Learned',
                      'not_learned' => 'Not Learned',
                      'all' => 'All'],
                  'multiple' => false,
                  'required' => true,
                  'expanded' => true
                  ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['csrf_protection' => false]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elearning_word_filter';
    }
}
