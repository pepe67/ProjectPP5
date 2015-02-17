<?php


namespace ProjectBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use ProjectBundle\Entity\CategoryRepository;
use Doctrine\ORM\EntityRepository;

class MovieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	
		
		 
        $builder
			->add('title', 'text', array(
                    'label' => 'Tytuł Filmu:'))

			->add('category', 'entity', array(
					'label' => 'Kategoria:',
					'class' => 'ProjectBundle:Category',
					'multiple' => false,
					'property' => 'name',
					'query_builder' => function(EntityRepository $er) {
						return $er->createQueryBuilder('u')
							->orderBy('u.id', 'ASC');
					},
					
				))
			->add('aboutmovie', 'textarea', array(
                    'label' => 'Opis Filmu:'))
            ->add('review', 'textarea', array(
                    'label' => 'Nasza opinia:'))
			->add('stars', 'choice', array(
                     'label' => 'Podaj ilość gwiazdek',
                     'choices' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'),
                    'preferred_choices' => array('3')))
            ->add('posterURL', 'text', array(
                    'label' => 'Adres URL Plakatu:'))
			->add('youtubeURL', 'text', array(
                    'label' => 'Adres URL zwiastunu na youtube ( np. 80PjspvRoe4 ):',
					'required' => false))
			->add('price', 'text', array(
                    'label' => 'Cena za wypożyczenie:'))
            ->add('released', 'date', array(
                    'label' => 'Premiera:'))
            ->add('createdAt', 'date', array(
                    'label' => 'Dodano dnia:'))
			->add('slug', 'hidden', array(
                    'data' => 'a'))
			;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProjectBundle\Entity\Movie'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'projectbundle_movie';
    }
}