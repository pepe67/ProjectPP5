<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ProjectBundle\Entity\Category;

class AdminController extends Controller
{
    public function indexAction()
    {
		
        return $this->render('ProjectBundle:Admin:index.html.twig', array());
    }

}
