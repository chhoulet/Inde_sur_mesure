<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends Controller
{
	public function listAction($origin, $affich)
	{
		$em=$this->getDoctrine()->getManager();
		if($affich == 1)
		{
			$messages=$em->getRepository('FrontOfficeBundle:Message')->getMessagesByOrigin($origin);       			
		}
		else
		{
			$messages=$em->getRepository('FrontOfficeBundle:Message')->findAll();       			
		}       	

        return $this->render('BackOfficeBundle:Message:list.html.twig', 
            array('messages' =>$messages, 'origin' => $origin, 'affich'=>$affich));
	}

	public function deleteAction(Request $request,$id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$deleteMessage=$em->getRepository('FrontOfficeBundle:Message')->find($id);
		$origin=4;

		if($deleteMessage != null)
		{
			$origin=$deleteMessage->getOrigin();
			$em->remove($deleteMessage);
			$em->flush();
			$session->getFlashBag()->add('delete', 'Ce message est supprimé !');
		}
		else
		{
			$session->getFlashBag()->add('delete', 'Ce message est inexistant !');
		}

		if($origin == 4)
		{
			return $this->redirectToRoute('back_office_message_list',array('origin'=>$origin, 'affich'=>2));			
		}
		else
		{
			return $this->redirectToRoute('back_office_message_list',array('origin'=>$origin, 'affich'=>1));
		}
	}

	public function answeredAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$answeredMessage=$em->getRepository('FrontOfficeBundle:Message')->find($id);
		$origin=$answeredMessage->getOrigin();

		$answeredMessage->setAnswered(1);
		$em->flush();

		if($origin == 4)
		{
			$session->getFlashBag()->add('answerMes', 'Vous avez répondu à ce message !');

			return $this->redirectToRoute('back_office_message_list',array('orig'=>$origin, 'affich'=>2));			
		}
		else
		{
			$session->getFlashBag()->add('answerMes', 'Vous avez répondu à ce message !');
			return $this->redirectToRoute('back_office_message_list',array('origin'=>$origin, 'affich'=>1));
		}
	}
}