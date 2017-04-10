<?php

namespace FrontOfficeBundle\Repository;

/**
 * MessageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MessageRepository extends \Doctrine\ORM\EntityRepository
{
	public function getMessagesUnAnswered()
	{
		$query=$this->getEntityManager()->createQuery('
			SELECT m
			FROM FrontOfficeBundle:Message m 
			WHERE m.answered = 0');

		return $query->getResult();		
	}
	
	public function countMessagesByOrigin($origin)
	{
		$query=$this->getEntityManager()->createQuery('
			SELECT COUNT(m.id) 
			FROM FrontOfficeBundle:Message m 
			WHERE m.origin = :origin
			AND m.answered = 0')
		->setParameter('origin', $origin);

		return $query->getResult();
	}

	public function getMessagesByOrigin($origin)
	{
		$query=$this->getEntityManager()->createQuery('
			SELECT m 
			FROM FrontOfficeBundle:Message m 
			WHERE m.origin = :origin
			AND m.answered = 0')
		->setParameter('origin', $origin);

		return $query->getResult();
	}
}
