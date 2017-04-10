<?php

namespace FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TripController extends Controller
{
	public function oneTripAction($id)
	{		
		$em=$this->getDoctrine()->getManager();
		$oneTrip=$em->getRepository('FrontOfficeBundle:Trip')->find($id);
		$state=$oneTrip->getPublic();
		$user=$this->getUser();
		if($state == false)
		{
			if($user != null)
			{
				$user=$this->getUser();
				$tripsByUser=$user->getTrip();
				$list=array();
				foreach($tripsByUser as $trip)
				{
					$idTrip=$trip->getId();
					$list[]=$idTrip;
				}
				

				if($oneTrip != null)
				{
					if(in_array($id, $list))
					{
						return $this->render('FrontOfficeBundle:Trip:oneTrip.html.twig', array('oneTrip'=>$oneTrip));				
					}
					else
					{
						throw new NotFoundHttpException("Vous n'êtes pas autorisé à accéder à ces informations' !");
					}
				}
				else
				{
					throw new NotFoundHttpException("Ce voyage n'existe pas !");
				}							
			}
			else
			{
				return $this->redirectToRoute('fos_user_security_login');
			}
		}
		else
		{
			if($oneTrip != null)
			{
				return $this->render('FrontOfficeBundle:Trip:oneTrip.html.twig', array('oneTrip'=>$oneTrip));				
			}
			else
			{
				throw new NotFoundHttpException("Ce voyage n'existe pas !");
			}
		}
	}

}
