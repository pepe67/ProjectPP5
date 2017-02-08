<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ProjectBundle\Entity\Category;

class DefaultController extends Controller
{
    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ProjectBundle:Category')->findAll();
		
        return $this->render('ProjectBundle:Default:index.html.twig', array(
			'categories' => $categories,
		));
    }
	
	public function categoryAction($name)
    {
		$em = $this->getDoctrine()->getManager();
		
		$categories = $em->getRepository('ProjectBundle:Category')->findAll();

        $category = $em->getRepository('ProjectBundle:Category')->findOneByName($name);
		
		
        return $this->render('ProjectBundle:Default:category.html.twig', array(
			'categories' => $categories,
			'category' => $category,
		));
    }
}
