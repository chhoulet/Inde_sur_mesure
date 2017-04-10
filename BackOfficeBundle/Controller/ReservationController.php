<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FrontOfficeBundle\Entity\Trip;
use FrontOfficeBundle\Form\TripType;
use FrontOfficeBundle\Form\ReservationAdminType;

class ReservationController extends Controller
{
	public function listAction()
	{
		$em=$this->getDoctrine()->getManager();
		$origin=1;
		$affich=2;
		$listReservations=$em->getRepository('FrontOfficeBundle:Reservation')->getReservationsUnProcessedUnLimited();

		return $this->render('BackOfficeBundle:Reservation:list.html.twig', 
			array('listReservations'=>$listReservations, 'origin'=>$origin, 'affich'=>$affich));
	}

	public function listAllAction()
	{
		$em=$this->getDoctrine()->getManager();
		$origin=1;
		$affich=3;
		$listReservations=$em->getRepository('FrontOfficeBundle:Reservation')->findAll();		

		return $this->render('BackOfficeBundle:Reservation:list.html.twig', 
			array('listReservations'=>$listReservations, 'origin'=>$origin, 'affich'=>$affich));
	}

	public function oneAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$reservation=$em->getRepository('FrontOfficeBundle:Reservation')->find($id);		
		$session=$request->getSession();
		$form=$this->createForm(ReservationAdminType::class, $reservation);

		$form->handleRequest($request);

		if($form->isValid() && $form->isSubmitted())
		{
			$em->flush();

			$session->getFlashBag()->add('updated', 'Cette réservation est mise à jour !');
			return $this->redirectToRoute('back_office_reservations_one', array('id'=>$id));
		}

		return $this->render('BackOfficeBundle:Reservation:one.html.twig', array('reservation'=>$reservation, 'form'=>$form->createView()));
	}

	public function answeredAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$reservation=$em->getRepository('FrontOfficeBundle:Reservation')->find($id);

		if($reservation != null)
		{
			$reservation->setState(1);			
			$em->flush();
			$session->getFlashBag()->add('answered', 'Vous avez bien répondu à cette réservation !');
			return $this->redirectToRoute('back_office_reservations_list');
		}
		else
		{
			throw new NotFoundHttpException("Cette reservation n\'existe pas !");
		}

	}

	public function cancelledAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$reservation=$em->getRepository('FrontOfficeBundle:Reservation')->find($id);
		 if($reservation != null)
		 {
		 	$reservation->setState(3);
			$em->flush();

			$session->getFlashBag()->add('cancelled', 'Cette réservation est annulée !');
		return $this->redirectToRoute('back_office_reservations_list');
		 }
		 else
		 {
		 	throw new NotFoundHttpException("Cette reservation n\'existe pas !");
		 }		
	}

	public function removeAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$reservation=$em->getRepository('FrontOfficeBundle:Reservation')->find($id);
		 if($reservation != null)
		 {
			$em->remove($reservation);
			$em->flush();

		 }
		 else
		 {
		 	throw new NotFoundHttpException("Cette reservation n\'existe pas !");
		 }

		$session->getFlashBag()->add('remove', 'Cette réservation est supprimée !');
		return $this->redirectToRoute('back_office_reservations_list');
	}

	public function acceptedAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$reservation=$em->getRepository('FrontOfficeBundle:Reservation')->find($id);

        if($reservation != null)
		 {
			$reservation->setState(2);
			$em->flush();
		 }
		 else
		 {
		 	throw new NotFoundHttpException("Cette reservation n\'existe pas !");
		 }

		$session->getFlashBag()->add('accepted', 'Cette réservation est vendue et enregistrée !');
		return $this->redirectToRoute('back_office_reservations_list');
	}

	public function archivedAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$reservation=$em->getRepository('FrontOfficeBundle:Reservation')->find($id);
		 if($reservation != null)
		 {
			$reservation->setArchived(true);			
			$em->flush();
		 }
		 else
		 {
		 	throw new NotFoundHttpException("Cette reservation n\'existe pas !");
		 }

		$session->getFlashBag()->add('archived', 'Cette réservation est archivée !');
		return $this->redirectToRoute('back_office_reservations_list');
	}

}