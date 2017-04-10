<?php

namespace FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

Class ThematicController extends Controller
{
	public function listAction()
	{
		$em=$this->getDoctrine()->getManager();
		$listThematics=$em->getRepository('FrontOfficeBundle:Thematic')->getThematicActivated();

		return $this->render('FrontOfficeBundle:Thematic:list.html.twig', array('listThematics'=> $listThematics));
	}

	public function oneThematicAction($id)
	{
		$em=$this->getDoctrine()->getManager();
		$oneThematic=$em->getRepository('FrontOfficeBundle:Thematic')->find($id);
		$dateOfTheDay=new \DateTime();
		$dateDay=$dateOfTheDay->getTimeStamp();

		if($oneThematic != null)
		{
			$listTrips=$oneThematic->getTrip();
			$listTripsForThisThematic=array();

			foreach($listTrips as $trip)
			{
				$dateBegin=$trip->getDateBegining();
				$dateOfTheTrip=$dateBegin->getTimeStamp();
				if($dateOfTheTrip > $dateDay)
				{
					$listTripsForThisThematic[]=$trip;
				}
			}

			return $this->render('FrontOfficeBundle:Thematic:oneThematic.html.twig', 
				array('oneThematic'=> $oneThematic,'listTripsForThisThematic'=>$listTripsForThisThematic));
		}
		else
		{
			throw new NotFoundHttpException("Cette thématique n\'existe pas !");
		}
		
	}
}