<?php

namespace FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrontOfficeBundle\Entity\Estimate;
use FrontOfficeBundle\Entity\Message;
use FrontOfficeBundle\Form\EstimateType;
use FrontOfficeBundle\Services\MailService;
use Symfony\Component\HttpFoundation\Request;

class EstimateController extends Controller
{
	public function createAction(Request $request)
	{
		$em=$this->getDoctrine()->getManager();
		$dateOfTheDay = new \DateTime();		
		$dateOfTheDayTimestamp = $dateOfTheDay->getTimestamp();		
		$estimate=new Estimate();
		$user=$this->getUser();

		if($user != null)
		{
			$user=$this->getUser();
			$email=$user->getEmail();
		}
		
		
		$session=$request->getSession();
		$form=$this->createForm(EstimateType::class, $estimate);

		// Soumission et traitement du formulaire
		$form->handleRequest($request);

		if($form->isValid() && $form->isSubmitted())
		{
			$estimate->setUser($user);
			$estimate->setDateSended(new \DateTime());			
			
			$em->persist($estimate);			
			$em->flush();

			// Envoi de mail de confirmation au client
			$subject='Votre demande de devis Inde sur mesure';
			$mailTo=$email;
			$mailFrom='orientour@wanadoo.fr';
			$body='Votre demande est prise en compte, merci de votre confiance. Nous allons reprendre contact avec vous dans les plus brefs délais. A bientôt !';

			$this->get('front_office_mail_service')->send($subject, $mailTo, $mailFrom, $body);
				
			$session->getFlashBag()->add('estimate', 'Votre demande a bien été envoyée. Nous reprendrons contact avec vous dans les plus brefs délais.');
			return $this->redirectToRoute('fos_user_profile_show');
		}

		// Récupération aléatoire de voyages
		$trips=$em->getRepository('FrontOfficeBundle:Trip')->getTripCreated();
		$nbrTrips=count($trips);

		$listTrips=array();
		foreach($trips as $trip)
		{
			$dateBeginning=$trip->getDateBegining();
			if($dateBeginning != null)
			{
				$dateBeginStamp=$dateBeginning->getTimestamp();
				
				if($dateBeginStamp > $dateOfTheDayTimestamp)
				{
					$listTrips[] = $trip;
				}
			}
		}

		while (count($listTrips) >= 7) {
			array_pop($listTrips);
		}

		return $this->render('FrontOfficeBundle:Estimate:create.html.twig', array('form'=>$form->createView(),
																				  'trips'=>$listTrips));
	}
}