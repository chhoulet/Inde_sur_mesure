<?php

namespace FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FrontOfficeBundle\Entity\Message;
use FrontOfficeBundle\Form\MessageType;


Class SlotsController extends Controller
{
	public function mentionsAction()
	{
		$em=$this->getDoctrine()->getManager();
		$listArticles=$em->getRepository('FrontOfficeBundle:Article')->getArticleMent();
		return $this->render('FrontOfficeBundle:Slots:mentions.html.twig', array('listArticles'=>$listArticles));
	}

	public function conditionsgeneralesAction()
	{
		$em=$this->getDoctrine()->getManager();
		$listArticles=$em->getRepository('FrontOfficeBundle:Article')->getArticleCondi();
		return $this->render('FrontOfficeBundle:Slots:conditionsgenerales.html.twig', array('listArticles'=>$listArticles));
	}

	public function contactAction(Request $request)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$message=new Message();
		$form=$this->createForm(MessageType::class, $message);

		$form->handleRequest($request);

		if($form->isValid() && $form->isSubmitted())
		{
			$message->setDateSended(new \DateTime('now'));
			$message->setOrigin(1);
			$em->persist($message);
			$em->flush();

			$session->getFlashBag()->add('messageSucced', 'Votre message a bien été envoyé !');
			return $this->redirectToRoute('front_office_contact');
		}

		return $this->render('FrontOfficeBundle:Slots:contact.html.twig', array('form'=>$form->createView()));
	}
}