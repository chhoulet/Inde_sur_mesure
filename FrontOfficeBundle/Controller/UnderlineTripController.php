<?php

namespace FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrontOfficeBundle\Entity\UnderlineTrip;

class UnderlineTripController extends Controller
{
	public function oneUnderlineTripAction($id)
	{
		$em=$this->getDoctrine()->getManager();
		$trip=$em->getRepository('FrontOfficeBundle:Trip')->find($id);

		if($trip->getUnderlineTrip() != null)
		{
			$listUnderlineTrips=$trip->getUnderlineTrip();			
		}

		return $this->render('FrontOfficeBundle:UnderlineTrip:oneUnderlineTrip.html.twig', 
			array('listUnderlineTrips'=>$listUnderlineTrips, 
				  'trip'=>$trip));
	}
}

