<?php
namespace ProjectBundle\Payment;

use Doctrine\ORM\EntityManager;

class SuccesHandler
{
	private $entityManager;
	
	public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
	
	 public function succesMethod($id)
    {
        $entity = $this
            ->entityManager
            ->getRepository('ProjectBundle\Entity\MovieOrder')
            ->findOneBy($id);
		$entity->setStatus('1');
		
		if ($entity) {
            throw $this->createNotFoundException($entity->getStatus());
        }
		$entity->flush();
    }
	


}