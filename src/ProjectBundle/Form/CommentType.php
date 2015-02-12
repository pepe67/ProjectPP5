<?php

namespace ProjectBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment')
            ->add('isAccepted')
            ->add('movie', 'entity', array(
					'label' => 'Kategoria:',
					'class' => 'ProjectBundle:Movie',
					'multiple' => false,
					'property' => 'id',
					//'query_builder' => function(EntityRepository $er) {
					//	return $er->createQueryBuilder('u')
					//		->orderBy('u.id', 'ASC');
					//},
					
				))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProjectBundle\Entity\Comment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'projectbundle_comment';
    }
}
