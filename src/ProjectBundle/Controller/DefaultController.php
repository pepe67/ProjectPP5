<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use ProjectBundle\Entity\Comment;
use ProjectBundle\Form\CommentType;

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
		
		$movies = $em->getRepository('ProjectBundle:Movie')->findBy(array( 'category' => $category->getId()));
				
        return $this->render('ProjectBundle:Default:category.html.twig', array(
			'categories' => $categories,
			'category' => $category,
			'movies' => $movies,
		));
    }
	public function movieBySlugAction($slug)
    {
		$em = $this->getDoctrine()->getManager();
		
		$categories = $em->getRepository('ProjectBundle:Category')->findAll();
		
        $movie = $em->getRepository('ProjectBundle:Movie')->findOneBySlug($slug);
			
		$comments = $em->getRepository('ProjectBundle:Comment')->findBy(array('movie' => $movie->getId()));	
		$form = $this->createForm(new CommentType(), new Comment(), array(
            'action' => $this->generateUrl('comment_create'),
            'method' => 'POST',
        ));
		
		$form->add('submit', 'submit', array('label' => 'Create'));
		
        return $this->render('ProjectBundle:Default:movie.html.twig', array(
			'comments' => $comments,
			'categories' => $categories,
			'movie' => $movie,
			'formcomment' => $form->createView(),

		));
    }
}
