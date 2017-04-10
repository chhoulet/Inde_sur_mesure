<?php

namespace FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FrontOfficeBundle\Entity\Mail;
use FrontOfficeBundle\Form\MailType;

class HomepageController extends Controller
{
    public function homepageAction(Request $request)
    {
    	$em=$this->getDoctrine()->getManager();
        $session=$request->getSession();

        // Récupération du texte fixe:
        $listArticles=$em->getRepository('FrontOfficeBundle:Article')->getArticlePres();

        // Gestion de la présentation des voyages       
    	$dateTodayBeforeFormat= new \DateTime('now');    	
	 	$dateTodayBeforeTime=$dateTodayBeforeFormat->format('Y-m-d');    	
    	$dateToday=strtotime($dateTodayBeforeTime);    	

    	$listTripsAll=$em->getRepository('FrontOfficeBundle:Trip')->getTripCreated();       
        $trips=array();

        if($listTripsAll != null)
        {
        	foreach($listTripsAll as $trip)
        	{
        		$dateBegining=$trip->getDateBegining();
        		if($dateBegining != null)
        		{
        			$dateBegin=$dateBegining->format('Y-m-d');
        			$datecomplete=strtotime($dateBegin);
        			if($datecomplete>$dateToday)
        			{
        				array_push($trips, $trip);
        			}
        		}
        	}
            
            //Mise en commentaire de ce bout de code pour laisser en homepage les voyages non-rattachés à une thématique
           /* while (count($trips) > 6) {
                array_pop($trips);
            }*/        	
        }

        // Gestion du formulaire d'adhésion à la newsletter
        $mail=new Mail();
        $form=$this->createForm(MailType::class, $mail);

        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted())
        {  
            if($form->get('goback')->isClicked())
            {
                $listAbo=$em->getRepository('FrontOfficeBundle:Mail')->findAll();
                $mailString=$mail->getEmail();

                $listMails=array();
                foreach($listAbo as $abo)
                {
                    $email=$abo->getEmail();
                    array_push($listMails , $email);

                    if(!in_array($mailString, $listMails))
                    {
                        $session->getFlashBag()->add('emailAbs', 'Cet email ne fait pas partie de la liste d\'abonnés !');
                    }
                    else
                    {
                        $em->remove($abo);
                        $em->flush();
                        $session->getFlashBag()->add('mail','Vous êtes désinscrit de notre newsletter !');
                    }
                }

            }
            else
            {
                $em->persist($mail);
                $em->flush();
                $session->getFlashBag()->add('mail','Votre mail est enregistré !');                
            }
            return $this->redirectToRoute('front_office_homepage');
        }

        return $this->render('FrontOfficeBundle:Homepage:homepage.html.twig', 
            array('trips'       =>$trips,
                  'listArticles'=>$listArticles,
                  'form'        =>$form->createView()));
    }
}
