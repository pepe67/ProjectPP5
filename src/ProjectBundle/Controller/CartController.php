<?php

namespace ProjectBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ProjectBundle\Entity\Movie;
use ProjectBundle\Form\MovieType;


class CartController extends Controller
{

	public function getCartAction()
		{

			//$this->get('session')->set('cartIDs', array(1,2,3,4,5,6,7,8,9,10));
        
			$cartIDs = $this->get('session')->get('cartIDs');
			$em = $this->getDoctrine()->getManager();

			$entities = $em->getRepository('ProjectBundle:Movie')->findById($cartIDs);

			$summaryPrice = 0.0;
			foreach ($entities as $entity)
				$summaryPrice += $entity->getPrice();

			return array(
				'itemsCount' => count($entities),
				'summaryPrice' => $summaryPrice,
			);
    }

}