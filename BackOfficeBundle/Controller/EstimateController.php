<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FrontOfficeBundle\Entity\Trip;
use FrontOfficeBundle\Entity\Image;
use FrontOfficeBundle\Form\ImageType;
use FrontOfficeBundle\Form\TripPrivateType;
use FrontOfficeBundle\Form\TripChoiceType;


Class EstimateController extends Controller
{
	public function listAction()
	{
		$em=$this->getDoctrine()->getManager();
		$origin=2;
		$listEstimates=$em->getRepository('FrontOfficeBundle:Estimate')->getEstimatesNonProcessedNonLimited();

		return $this->render("BackOfficeBundle:Estimate:list.html.twig", array('listEstimates'=>$listEstimates, 'origin'=>$origin));
	}

	public function listAllAction()
	{
		$em=$this->getDoctrine()->getManager();
		$origin=2;
		$listAllEstimates=$em->getRepository('FrontOfficeBundle:Estimate')->findAll();

		return $this->render("BackOfficeBundle:Estimate:list.html.twig", array('listEstimates'=>$listAllEstimates, 'origin'=>$origin));
	}

	public function treatmentAction(Request $request, $id, $origin)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();		
		$estimate=$em->getRepository('FrontOfficeBundle:Estimate')->find($id);
		$user=$estimate->getUser();
		$trip=new Trip();
		$image=new Image();		
		$image->setTrip($trip);       
        $trip->getImage()->add($image);
		$form=$this->createForm(TripPrivateType::class, $trip);
		$formTrip=$this->createForm(TripChoiceType::class);

		$formTrip->handleRequest($request);
		if($formTrip->isSubmitted() && $formTrip->isValid())
		{
			$datas=$formTrip->getData();
			$tripDoble=$datas['trip'];						
			$globalPrice=$datas['globalPrice'];
			$dateBegining=$datas['dateBegining'];
			$dateEnding=$datas['dateEnding'];
			$idTrip=$tripDoble->getId();
			
			$listTripsByUser=$user->getTrip();
			$listIdTrips=array();
			foreach($listTripsByUser as $tripByUser)
			{
				$idT=$tripByUser->getId();
				$listIdTrips[]=$idT;
			}

			if(!in_array($idTrip, $listIdTrips))
			{
				// Création d'un nouveau trip qui sera attribué à l'user et hydratation du nouvel objet avec les données du Trip originel
				$tripForUser=new Trip();
				$numberPerson = null;
				$nbrDays= null;
				$nbrAdults=$estimate->getNbrAdults();
				$nbrChildren=$estimate->getNbrChildren();
				if($nbrAdults != null || $nbrChildren != null)
				{
					$numberPerson=$nbrAdults + $nbrChildren;
					$tripForUser->setNumberPerson($numberPerson);				
				}

				if($estimate->getNbrDays() != null)
				{
					$nbrDays=$estimate->getNbrDays();
					$tripForUser->setNumberDays($nbrDays);					
				}
				
				$title=$tripDoble->getTitle();
				if($title != null)
				{
					$tripForUser->setTitle($title);					
					
				}

				$comment1=$tripDoble->getComment1();
				if($comment1 != null)
				{
					$tripForUser->setComment1($comment1);
				}

				$comment2=$tripDoble->getComment2();
				if($comment2 != null)
				{
					$tripForUser->setComment2($comment2);
				}

				$period=$tripDoble->getPeriod();
				if($period != null)
				{
					$tripForUser->setPeriod($period);
				}

				$place=$tripDoble->getPlace();
				if($place != null)
				{
					$tripForUser->setPlace($place);
				}

				$description=$tripDoble->getDescription();	
				if($description != null)
				{
					$tripForUser->setDescription($description);
				}

				$thematic=$tripDoble->getThematic();
				if($thematic != null)
				{
					$tripForUser->setThematic($thematic);
				}

				$underlineTrips=$tripDoble->getUnderlineTrip();
				if($underlineTrips != null)
				{
					foreach($underlineTrips as $underli)
					{
						$tripForUser->addUnderlineTrip($underli);						
					}
				}

				$images=$tripDoble->getImage();
				if($images != null)
				{
					foreach($images as $image)
					{
						$tripForUser->addImage($image);
						$image->setTrip($tripForUser);	                                               
					}
				}

				$brochure=$tripDoble->getBrochure();
				if($brochure != null)
				{
					$tripForUser->setBrochure($brochure);
				}
								
				$tripForUser->setOrigin(5);
				$tripForUser->setBobleTrip(2);
				$tripForUser->setGlobalPrice($globalPrice);
				$tripForUser->setDateBegining($dateBegining);
				$tripForUser->setDateEnding($dateEnding);
				$tripForUser->setDateCreated(new \DateTime());
				$tripForUser->setPublic(false);
				$tripForUser->addEstimate($estimate);
				$tripForUser->addUser($user);
				$user->addTrip($tripForUser);
				$estimate->addTrip($tripForUser);
				$estimate->setState(1);
				$estimate->setDateAnswerSended(new \DateTime());			
				$dateSend=$estimate->getDateSended()->format('d-m-Y');
				$em->persist($tripForUser);
				$em->flush();

				$subject='Réponse à votre demande de devis envoyée le '. $dateSend .'.';
				$mailTo=$estimate->getUser()->getEmail();
				$mailFrom='orientour@wanadoo.fr';
				$body='Un descriptif de voyage complet vient d\'être placé dans votre espace personnel, sur notre site Inde sur mesure. Nous vous en souhaitons bonne réception, Cordialement, l\'équipe Inde sur Mesure';

				$this->get('front_office_mail_service')->send($subject, $mailTo, $mailFrom, $body);
			
				$session->getFlashBag()->add('tripChoice', $tripForUser->getTitle() . ' a été attribué à '. $user->getFirstname().' '.$user->getName().'!');
				return $this->redirectToRoute('back_office_estimate_listResponses',array('id'=>$id));
			}
			else
			{
				$session->getFlashBag()->add('tripChoice1', $tripDoble->getTitle() . ' a déjà été attribué à '. $user->getFirstname().' '.$user->getName().'!');
				return $this->redirectToRoute('back_office_estimate_treatment', array('id'=>$estimate->getId(), 'origin'=>1));
			}
		}

		$form->handleRequest($request);

		if($form->isValid() && $form->isSubmitted())
		{
			$file=$image->getFilename();
			$file1=$image->getFilename1();
			$file2=$image->getFilename2();

			if($file != null)
			{
				$filename=md5(uniqid()) .'.'. $file->guessExtension();
				$file->move($this->getParameter('images_directory'), $filename);
				$image->setFilename($filename);
			}

			if($file1 != null)
			{
				$filename1=md5(uniqid()) .'.'. $file1->guessExtension();
				$file1->move($this->getParameter('images_directory'), $filename1);
				$image->setFilename1($filename1);
			}

			if($file2 != null)
			{
				$filename2=md5(uniqid()). '.' . $file2->guessExtension();
				$file2->move($this->getParameter('images_directory'), $filename2);
				$image->setFilename2($filename2);
			}

			$nbrAdults=$estimate->getNbrAdults();
			$nbrChildren=$estimate->getNbrChildren();

			$numberPersons=$nbrAdults + $nbrChildren;
			$trip->setNumberPerson($numberPersons);			
			$image->setTrip($trip);
			$trip->addImage($image);
			$trip->setThematic(null);
			$trip->addUser($user);
			$trip->addEstimate($estimate);
			$trip->setOrigin(5);
			$trip->setDateCreated(new \DateTime());
			$trip->setPublic(false);
			$user->addTrip($trip);
			$estimate->addTrip($trip);
			$estimate->setDateAnswerSended(new \DateTime());
			$estimate->setState(1);
			$dateSend=$estimate->getDateSended()->format('d-m-Y');

			$em->persist($image);
			$em->persist($trip);
			$em->flush();

			if($form->get('Save_and_add')->isClicked())
			{
				$session->getFlashBag()->add('treatment', 'Votre voyage est créé ! Ajoutez une description journalière');
				return $this->redirectToRoute('back_office_underline_trip_create', array('id'=>$trip->getId()));
			}
			else
			{
				$subject='Réponse à votre demande de devis envoyée le '. $dateSend .'.';
				$mailTo=$estimate->getUser()->getEmail();
				$mailFrom='orientour@wanadoo.fr';
				$body='Un descriptif de voyage complet vient d\'être placé dans votre espace personnel, sur notre site Inde sur mesure. Nous vous en souhaitons bonne réception, Cordialement, l\'équipe Inde sur Mesure';

				$this->get('front_office_mail_service')->send($subject, $mailTo, $mailFrom, $body);

				$session->getFlashBag()->add('treatment', 'Cette demande de devis est traitée, le descriptif est envoyé au destinataire ainsi qu\'un mail  !');
				return $this->redirectToRoute('back_office_estimate_listResponses',array('id'=>$id));
			}
		}

		return $this->render('BackOfficeBundle:Estimate:treatment.html.twig', 
			array('form'=>$form->createView(),
			      'formTrip'=>$formTrip->createView(),
				  'estimate' =>$estimate,
				  'user'  =>$user,
				  'origin'=>$origin));
	}

	public function treatedAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$treatedEstimate=$em->getRepository('FrontOfficeBundle:Estimate')->find($id);

		if($treatedEstimate != null)
		{
			$trips=$treatedEstimate->getTrip();

			foreach($trips as $trip)
			{
				if($trip->getSold() == true)
				{
					$treatedEstimate->setState(2);
					$em->flush();
				}
			}			
		}
		else
		{
		    throw new NotFoundHttpException("Devis inexistant !");
		}

		$session->getFlashBag()->add('treated', 'Ce devis est accepté !');
		return $this->redirectToRoute('back_office_estimates_list');
	}

	public function archivedAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$treatedEstimate=$em->getRepository('FrontOfficeBundle:Estimate')->find($id);

		if($treatedEstimate != null)
		{
			$treatedEstimate->setArchived(true);
			$em->flush();
		}
		else
		{
			throw new NotFoundHttpException("Devis inexistant !");
		}
		
		$session->getFlashBag()->add('archived', 'Ce devis est archivé !');
		return $this->redirectToRoute('back_office_estimates_list');
	}

	public function removeAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$treatedEstimate=$em->getRepository('FrontOfficeBundle:Estimate')->find($id);

		if($treatedEstimate != null)
		{
			$em->remove($treatedEstimate);
			$em->flush();
		}
		else
		{
			throw new NotFoundHttpException("Demande de devis inexistante !");
		}
		
		$session->getFlashBag()->add('remove', 'Cette demande de devis est supprimée !');
		return $this->redirectToRoute('back_office_estimates_list');
	}

	public function cancelAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$treatedEstimate=$em->getRepository('FrontOfficeBundle:Estimate')->find($id);

		if($treatedEstimate != null)
		{
			$treatedEstimate->setState(3);
			$em->flush();
		}
		else
		{
			throw new NotFoundHttpException("Demande de devis inexistant !");
		}
		
		$session->getFlashBag()->add('cancel', 'Cette demande de devis est annulée !');
		return $this->redirectToRoute('back_office_estimates_list');
	}

	public function listResponsesAction($id)
	{
		$em=$this->getDoctrine()->getManager();

		if($id != null)
		{
			$estimate=$em->getRepository('FrontOfficeBundle:Estimate')->find($id);
			$listResponsesAll=$em->getRepository('FrontOfficeBundle:Trip')->getTripsByEstimate($id);

			$listResponses=array();
			foreach($listResponsesAll as $trip)
			{	
				$state=$trip->getPublic();
				if($state == false)
				{
					$listResponses[]=$trip;
				}
			}

			return $this->render('BackOfficeBundle:Estimate:listResponses.html.twig', 
				array('listResponses'=>$listResponses, 
					  'estimate'=>$estimate));
		}
		else
		{
			throw new NotFoundHttpException("Demande de devis inexistante !");
		}

	}

	
}