<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrontOfficeBundle\Entity\UnderlineTrip;
use FrontOfficeBundle\Form\UnderlineTripType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\File\File;

class UnderlineTripController extends Controller
{
	public function createAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$origin=1;
		$trip=$em->getRepository('FrontOfficeBundle:Trip')->find($id);
		$public=$trip->getPublic();
		$underlineTrip=new UnderlineTrip();
		$form=$this->createForm(UnderlineTripType::class, $underlineTrip);

		$form->handleRequest($request);

		if($form->isValid() && $form->isSubmitted())
		{
			$underlineTrip->setTrip($trip);
			$trip->addUnderlineTrip($underlineTrip);

			$file=$underlineTrip->getPhoto();
			if($file != null)
			{
				$filename=md5(uniqid()).'.'.$file->guessExtension();
				$file->move($this->getParameter('images_directory'), $filename);
				$underlineTrip->setPhoto($filename);
			}
			$em->persist($underlineTrip);
			$em->flush();						
			
			if($form->get('saveAndAdd')->isClicked())
			{
				$session->getFlashbag()->add('under','Cette description additionnelle est ajoutée à : ' . $trip->getTitle());
				return $this->redirectToRoute('back_office_underline_trip_create', array('id'=>$trip->getId()));
			}
			elseif($form->get('saveAndPrice')->isClicked())
			{
				if($public == false)
				{
					$session->getFlashbag()->add('error','Ce voyage est privé, vous devez saisir un prix global !');
					return $this->redirectToRoute('back_office_underline_trip_create', array('id'=>$trip->getId()));
				}
				else
				{
					return $this->redirectToRoute('back_office_price_create', array('id'=>$trip->getId()));					
				}
			}
			else
			{
				if($public == true)
				{
					return $this->redirectToRoute('back_office_trip');
				}
				else
				{
					return $this->redirectToRoute('back_office_trip_one', array('id'=>$trip->getId(),'origin'=>$origin));
				}
			}							
		}

		return $this->render('BackOfficeBundle:UnderlineTrip:create.html.twig', 
			array('form'=>$form->createView(),
				  'trip'=>$trip,
				  'origin'=>$origin));
	}

	public function updateAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$origin=2;
		$session=$request->getSession();

		$updateUnderline=$em->getRepository('FrontOfficeBundle:UnderlineTrip')->find($id);
		if($updateUnderline->getPhoto() != null)
		{
			$updateUnderline->setPhoto(new File($this->getParameter('images_directory').'/'.$updateUnderline->getPhoto()));			
		}

		$trip=$updateUnderline->getTrip();
		$idTrip=$trip->getId();

		$form=$this->createForm(UnderlineTripType::class, $updateUnderline);

		if($updateUnderline != null)
		{
			$form->handleRequest($request);

			if($form->isValid() && $form->isSubmitted())
			{
				$file=$updateUnderline->getPhoto();				

				if($file != null)
				{
					$filename=md5(uniqid()).'.'.$file->guessExtension();
					$file->move($this->getParameter('images_directory'), $filename);
					$updateUnderline->setPhoto($filename);
				}

				$em->flush();

				$session->getFlashbag()->add('under','Cette description additionnelle est modifiée !');
				return $this->redirectToRoute('back_office_underline_trip_create', array('id'=>$idTrip));
			}
		}
		else
		{
			throw new NotFoundHttpException("Cet élément n\'existe pas !");
		}

		return $this->render('BackOfficeBundle:UnderlineTrip:create.html.twig', 
			array('form'=>$form->createView(),
				  'trip'=>$trip,
				  'origin'=>$origin));
	}

	public function deleteAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$origin=2;
		$session=$request->getSession();
		$deleteUnderline=$em->getRepository('FrontOfficeBundle:UnderlineTrip')->find($id);
		$trip=$deleteUnderline->getTrip();
		$idTrip=$trip->getId();

		$em->remove($deleteUnderline);
		$em->flush();

		$session->getFlashbag()->add('underDelete','Cette description additionnelle est supprimée !');
		return $this->redirectToRoute('back_office_underline_trip_create', array('id'=>$idTrip));
	}
}


