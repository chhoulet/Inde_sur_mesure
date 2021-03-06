<?php

namespace FrontOfficeBundle\Repository;

/**
 * PriceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PriceRepository extends \Doctrine\ORM\EntityRepository
{
	public function getPricesByTrip($id)
	{		

		$qb=$this->createQueryBuilder('q');
		$qb->select('p')
   		   ->from('FrontOfficeBundle:Price', 'p')
   		   ->where('p.trip = :tripId')
   		   ->setParameter('tripId', $id);
			
		return $qb;
	}
}
