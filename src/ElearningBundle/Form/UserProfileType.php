<?php

    namespace ElearningBundle\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;

    class UserProfileType extends AbstractType
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
                ->add('oldPassword', 'password')
                ->add('newPassword', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'The password fields must match.',
                    'required' => true,
                    'first_options'  => ['label' => 'New Password'],
                    'second_options' => ['label' => 'Repeat Password'],
                ));
            ;
        }

        /**
         * @param OptionsResolverInterface $resolver
         */
        public function setDefaultOptions(OptionsResolverInterface $resolver)
        {
            $resolver->setDefaults([
                'data_class' => 'ElearningBundle\Entity\User',
                'csrf_protection' => true,
                'validation_groups' => array('change_password'),
            ]);
        }

        /**
         * @return string
         */
        public function getName()
        {
            return 'edit_user';
        }
  }
