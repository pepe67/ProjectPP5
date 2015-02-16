<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ProjectBundle\Entity\Comment;
use ProjectBundle\Form\CommentType;

use ProjectBundle\Entity\Category;

class DefaultController extends Controller
{
	// Strona główna - Piotr Kozak
    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ProjectBundle:Category')->findAll();
		
		
        return $this->render('ProjectBundle:Default:index.html.twig', array(
			'categories' => $categories,
			
		));
    }
	
	// Filmy z kategorii - Piotr Kozak
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
	
	// Jeden Film "by Slug" Piotr Kozak, Komentarze do filmu: Dawid Holko, Robert Korus
	public function movieBySlugAction($slug)
    {
		$em = $this->getDoctrine()->getManager();
		
		$categories = $em->getRepository('ProjectBundle:Category')->findAll();
		
        $movie = $em->getRepository('ProjectBundle:Movie')->findOneBySlug($slug);
			
		$comments = $em->getRepository('ProjectBundle:Comment')->findBy(array('movie' => $movie->getId()));	
		
		$movieId = $movie->getId();
		
		$form = $this->createForm(new CommentType, new Comment(), array(
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
	
	
	// Koszyk!
	// Dodanie filmu do koszyka
	// routing /setCart/{id}
	// Piotr Kozak
	public function setCartAction($id)
	{
		$cartIDs = $this->get('session')->get('cartIDs');
		$cartIDs[] = $id;
		$this->get('session')->set('cartIDs', $cartIDs);
		
		//Przekieruj na ostatnio oglądaną stronę
		return $this->redirect($this->getRequest()->headers->get('referer'));
	}
	
	// Funkcja pobiera elementy z koszyka, zlicza ich ilość i łączą cenę za wypożyczenie.
	// Funkcja użyta jedynie do wyświetlenia informacji o koszyk
	// Piotr Kozak
	public function getCartAction()
	{
	
		$cartIDs = $this->get('session')->get('cartIDs');
	
		$em = $this->getDoctrine()->getManager();
				
		$movies = $em->getRepository('ProjectBundle:Movie')->findById($cartIDs);
	
		$summaryPrice = 0.0;
	
		foreach ($movies as $movie)
			$summaryPrice += $movie->getPrice();
			
		return $this->render('ProjectBundle:Default:getCart.html.twig', array(
			'itemsCount' => count($movies),
			'summaryPrice' => $summaryPrice,
		));
	}
	// Usunięcie filmu wg. ID z koszyka i powrót do strony koszyka.
	// Piotr Kozak
	public function deleteFromCartAction($id){

        $cartIDs = $this->get('session')->get('cartIDs');
        //Usuwanie z tablicy $id
        if(($key = array_search($id, $cartIDs)) !== false) {
            unset($cartIDs[$key]);
        }
        $this->get('session')->set('cartIDs', $cartIDs);

        return $this->forward('ProjectBundle:Default:showCart');
    }  
	
	// Wyświetlenie koszyka
	// Piotr Kozak
	public function showCartAction()
    {
		$cartIDs = $this->get('session')->get('cartIDs');
	
		$em = $this->getDoctrine()->getManager();
				
		$movies = $em->getRepository('ProjectBundle:Movie')->findById($cartIDs);
		
				
        return $this->render('ProjectBundle:Default:cart.html.twig', array(
			'licznik' => count($movies),
			'movies' => $movies,
		));
    }
	// Czyszczenie całkowite koszyka
	// Piotr Kozak
	 public function clearCartAction(){

       
        $cartIDs = array();
        $this->get('session')->set('cartIDs', $cartIDs);

        return $this->forward('ProjectBundle:Default:showCart');
    }  
}
