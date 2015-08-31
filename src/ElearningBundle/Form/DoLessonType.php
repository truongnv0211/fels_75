<?php

    namespace ElearningBundle\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;

    class DoLessonType extends AbstractType
    {
        /**
         * @param FormBuilderInterface $builder
         * @param array $options
         */
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
        }

        /**
         * @param OptionsResolverInterface $resolver
         */
        public function setDefaultOptions(OptionsResolverInterface $resolver)
        {
            $resolver->setDefaults([
                'data_class' => 'ElearningBundle\Entity\Lesson'
            ]);
        }

        /**
         * @return string
         */
        public function getName()
        {
            return 'elearningbundle_lesson_do';
        }
    }
