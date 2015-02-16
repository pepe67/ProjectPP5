<?php
namespace ProjectBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MovieOrderType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('orderedAt')
            ->add('user', null, array( 'attr'=>array('style'=>'display:none;'), 'label_attr' => array('style'=>'display:none;'))) 
            ->add('movies',  null, array( 'attr'=>array('style'=>'display:none;'), 'label_attr' => array('style'=>'display:none;')))
			->add('status',  'hidden' , array('data' => '0'))			
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProjectBundle\Entity\MovieOrder'
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'project_bundle_order';
    }
}