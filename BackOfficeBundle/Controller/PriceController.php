<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrontOfficeBundle\Entity\Price;
use FrontOfficeBundle\Entity\Article;
use FrontOfficeBundle\Form\PriceAdminType;
use FrontOfficeBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PriceController extends Controller
{
	public function createAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$trip=$em->getRepository('FrontOfficeBundle:Trip')->find($id);
		$public = $trip->getPublic();
		$price=new Price();
		$article=new Article();
		$article->setOrigin(4);
		$formArticle=$this->createForm(ArticleType::class, $article);
		$form=$this->createForm(PriceAdminType::class, $price);

		$form->handleRequest($request);

		if($form->isValid()&& $form->isSubmitted())
		{
			$price->addTrip($trip);
			$em->persist($price);
			$em->flush();

			$session->getFlashBag()->add('price', 'Ces informations tarifaires sont ajoutées au voyage : '. $trip->getTitle());

			if($form->get('Save_and_add')->isClicked())
			{
				return $this->redirectToRoute('back_office_price_create', array('id'=>$trip->getId()));
			}
			
			return $this->redirectToRoute('back_office_trip');	
		}

		$formArticle->handleRequest($request);

		if($formArticle->isValid() && $formArticle->isSubmitted())
		{
			$article->setTrip($trip);
			$em->persist($article);
			$em->flush();

			$session->getFlashBag()->add('arti', 'Ces informations sont ajoutées au voyage : '. $trip->getTitle());

			if($public == true)
			{
				return $this->redirectToRoute('back_office_trip');				
			}
			else
			{
				return $this->redirectToRoute('front_office_trip_oneTrip', array('id'=>$id));
			}
		}

		return $this->render('BackOfficeBundle:Price:create.html.twig', 
			array('form'=>$form->createView(),
				  'formArticle'=>$formArticle->createView(),
				  'trip'=>$trip));
	}

	public function deleteAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$deletePrice=$em->getRepository('FrontOfficeBundle:Price')->find($id);
		

		if($deletePrice != null)
		{
			$trip=$deletePrice->getTrip();
			$em->remove($deletePrice);
			$em->flush();

			$session->getFlashBag()->add('deletePrice', 'Le prix de ce voyage est supprimé !');
			return $this->redirectToRoute('back_office_price_create', array('id'=>$trip->getId()));
		}
		else
		{
			throw new NotFoundHttpException("Ce prix n'existe pas !");
		}
	}
}