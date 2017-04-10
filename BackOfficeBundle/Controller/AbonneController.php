<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrontOfficeBundle\Entity\Article;
use FrontOfficeBundle\Entity\Image;
use FrontOfficeBundle\Form\ArticleType;
use UserBundle\Entity\User;
use FrontOfficeBundle\Form\UserType;
use FrontOfficeBundle\Entity\Newsletter;
use FrontOfficeBundle\Form\NewsletterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


Class AbonneController extends Controller
{
	public function gestionAboAction(Request $request)
	{
    	$em=$this->getDoctrine()->getManager();
    	$session=$request->getSession();
        $affich=0;

        //Gestion des messages / Les codes de création des messages d'origine 2 et 3, créés à l'origine automatiquement lors de la passation de reservations et de demandes de devis, ont été supprimés car redondants avec ces mêmes resa et devis.               
        $messages=$em->getRepository('FrontOfficeBundle:Message')->getMessagesUnAnswered();
        $infoMessages=array();
        $devisMessages=array();
        $achatMessages=array();
        foreach($messages as $message)
        {
            $origin=$message->getOrigin();
            if($origin == 1)
            {
                array_push($infoMessages, $message);
            }
            elseif($origin == 2)
            {
                array_push($devisMessages, $message);
            }
            elseif($origin == 3)
            {
                array_push($achatMessages, $message);
            }
        }

        $numberinfoMessages=count($infoMessages);        
        //Fin gestion messages     

        // Sélection des Articles par type:
        $articlesPresentation=$em->getRepository('FrontOfficeBundle:Article')->getArticlePres();
        $articlesMentions=$em->getRepository('FrontOfficeBundle:Article')->getArticleMent();
        $articlesConditions=$em->getRepository('FrontOfficeBundle:Article')->getArticleCondi();

        // Comptage des comptes créés sur le site        
        $listUsersAll=$em->getRepository('UserBundle:User')->findAll();

        $listUsers=array();
        foreach($listUsersAll as $user)
        {
            $roles=$user->getRoles();
            if(!in_array('ROLE_SUPER_ADMIN', $roles) && (!in_array('ROLE_ADMIN', $roles)))
            {
                $listUsers[]=$user;       
            }
        }

        $nbrUsers=count($listUsers);
        //

        // Comptage des abonnés à la newsletter
        $abonnes=$em->getRepository('FrontOfficeBundle:Mail')->findAll();        
        $listMail=array();
        foreach($abonnes as $abonne)
        {
            $mail=$abonne->getEmail();
            $listMail[]=$mail;
        }
        $listMails=array_unique($listMail);
        $numberAbonnes=count($listMails);
        //	 

	    //Gestion des droits d'administrateur
        $form=$this->createForm(UserType::class);

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted())
        {
        	$data=$form->getData();
        	$listNames=array();
        	$listNamesNonRoleExisting=array();
        	$listNamesRemovedRole=array();
        	$listNamesAlreadyHasRole=array();
        	foreach($data as $element)
        	{
        		foreach ($element as $user)
        		{
        			if($form->get('adminRights')->isClicked())
        			{
        				if($user->hasRole('ROLE_ADMIN') == true)
        				{
        					$user->removeRole('ROLE_ADMIN');
        					$listNamesRemovedRole[]=$user->getFullName();    					
        				}
        				else
        				{
        					$listNamesNonRoleExisting[]=$user->getFullName();
        				}
        			}
        			else
        			{
        				if($user->hasRole('ROLE_ADMIN') == true)
        				{
        					$listNamesAlreadyHasRole[]=$user->getFullName();
        				}
        				else
        				{
		        			$user->addRole('ROLE_ADMIN');
		        			$listNames[]=$user->getFullName();
        				}
        			}
        		}
        	}

        	if($listNamesAlreadyHasRole != null)
        	{
        		$listNamesAlreadyHasRoleString=array_slice($listNamesAlreadyHasRole, 0);
        		$stringNamesAlreadyHasRole=implode("' ", $listNamesAlreadyHasRoleString);
        		$session->getFlashBag()->add('admin', 'Les droits d\'administrateur sont déjà attribués à ' . $stringNamesAlreadyHasRole);
        	}
        	
        	if($listNamesRemovedRole != null) 
        	{
	        	$listNamesRemovedRoleString=array_slice($listNamesRemovedRole,0);
	        	$stringNamesRemoved=implode(", ", $listNamesRemovedRoleString);
        		$session->getFlashBag()->add('admin','Les droits d\'administrateur ont bien été retirés à '. $stringNamesRemoved);
        	}

        	if($listNamesNonRoleExisting != null) 
        	{
	        	$listNamesNonRoleString=array_slice($listNamesNonRoleExisting,0);
	        	$stringNamesNonRole=implode(", ", $listNamesNonRoleString);
	        	$session->getFlashBag()->add('admin','Les droits d\'administrateur n\'ont jamais été attribués à '. $stringNamesNonRole);
	        }

        	if($listNames != null)
        	{
	        	$listNamesString=array_slice($listNames,0);
	        	$stringNames=implode(", ", $listNamesString);        		
        		$session->getFlashBag()->add('admin','Les droits d\'administrateur ont bien été rajoutés à '. $stringNames);
        	}

            $em->flush();
        }
        //                                  	        

        return $this->render('BackOfficeBundle:Abonnes:gestionAbo.html.twig', 
                array('form'               =>$form->createView(),                     
                      'numberAbonnes'      =>$numberAbonnes,
                      'nbrUsers'           =>$nbrUsers,
                      'articlesPresentation'=>$articlesPresentation,
                      'articlesMentions'    =>$articlesMentions,
                      'articlesConditions'  =>$articlesConditions,
                      'numberinfoMessages' =>$numberinfoMessages));
	}

    public function listAction()
    {
        $em=$this->getDoctrine()->getManager();        

        $listUsersAll=$em->getRepository('UserBundle:User')->findAll();

        $listRegistered=array();
        foreach($listUsersAll as $user)
        {
            $roles=$user->getRoles();
            if(!in_array('ROLE_SUPER_ADMIN', $roles) && (!in_array('ROLE_ADMIN', $roles)))
            {
                $listRegistered[]=$user;       
            }
        }

        return $this->render('BackOfficeBundle:Abonnes:listRegistered.html.twig', array('listRegistered'=>$listRegistered));
    }

    public function deleteAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$request->getSession();
        $deletedUser=$em->getRepository('UserBundle:User')->find($id);

        if($deletedUser != null)
        {
            $em->remove($deletedUser);
            $em->flush();            
            $session->getFlashBag()->add('deletedUser',' Ce compte client est bien supprimé !');
            return $this->redirectToRoute('back_office_abonnes_list');
        }
        else
        {
            throw new NotFoundHttpException("Ce client n\'existe pas !");
        }

    }

    public function createAction(Request $request, $origin)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$request->getSession();
        $affich=0;

        //Formulaire de création des textes fixes
        $article=new Article();
        $formArticle=$this->createForm(ArticleType::class, $article);

        $formArticle->handleRequest($request);

        if($formArticle->isValid() && $formArticle->isSubmitted())
        {
           $article->setOrigin($origin);
           $em->persist($article);
           $em->flush();

           $session->getFlashBag()->add('texts','Cet article est bien créé !');
           return $this->redirectToRoute('back_office_articles_gestionAbo');
        }

        return $this->render('BackOfficeBundle:Abonnes:createArticle.html.twig', 
            array('form'  => $formArticle->createView(),
                  'origin'=> $origin,
                  'affich'=>$affich));
    }

    public function deleteArticleAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$request->getSession();
        $deletedArticle=$em->getRepository('FrontOfficeBundle:Article')->find($id);

        if($deletedArticle != null)
        {
            $em->remove($deletedArticle);
            $em->flush();

            $session->getFlashBag()->add('supp','Cet article est supprimé !');
            return $this->redirectToRoute('back_office_articles_gestionAbo');            
        }
        else
        {
            throw new NotFoundHttpException("Cet article n\existe pas !");
        }
    }

    public function updateArticleAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$request->getSession();
        $affich=1;
        $updateArticle=$em->getRepository('FrontOfficeBundle:Article')->find($id);

        if($updateArticle != null)
        {
            $origin=$updateArticle->getOrigin();
            $form=$this->createForm(ArticleType::class, $updateArticle);
           
            $form->handleRequest($request);

            if($form ->isValid()  && $form->isSubmitted())
            { 
                $em->flush();

                $session->getFlashBag()->add('update','Cet article est mis à jour !');
                return $this->redirectToRoute('back_office_articles_gestionAbo');
            }

            return $this->render('BackOfficeBundle:Abonnes:createArticle.html.twig', 
                array('form'  => $form->createView(),
                      'origin'=> $origin,
                      'affich'=> $affich));
        }
        else
        {
            throw new NotFoundHttpException("Cet article n\existe pas !");
        }

    }

    public function createNewsletterAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$request->getSession();
        $newsletter=new Newsletter();
        $image=new Image();
        $image->setNewsletter($newsletter);
        $newsletter->getImage()->add($image);
        $form=$this->createForm(NewsletterType::Class, $newsletter);

        // Instanciation de la newsletter
        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted())
        {
            $newsletter->setDateCreated(new \DateTime());

            $file=$image->getFilename();
            $filename=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'), $filename);
            $image->setFilename($filename);

            $file1=$image->getFilename1();
            if($file1 != null)
            {
                $filename1=md5(uniqid()).'.'.$file1->guessExtension();
                $file1->move($this->getParameter('images_directory'), $filename1);
                $image->setFilename1($filename1);
            }

            $file2=$image->getFilename2();
            if($file2 != null)
            {
                $filename2=md5(uniqid());'.'.$file2->guessExtension();
                $file2->move($this->getParameter('images_directory'), $filename2);
                $image->setFilename2($filename2);
            }

            $em->persist($image);
            $em->persist($newsletter);
            $em->flush();

            $id=$newsletter->getId();

            $session->getFlashBag()->add('newsletter','Cette newsletter est bien créée !');           
            return $this->redirectToRoute('back_office_newsletter_oneNewsletter', array('id'=>$id));
        }

        //Récupération de toutes les newsletters
        $listNewsletters=$em->getRepository('FrontOfficeBundle:Newsletter')->findAll();


        return $this->render('BackOfficeBundle:Abonnes:createNewsletter.html.twig', 
            array('form'=>$form->createView(),'listNewsletters'=>$listNewsletters));
    }

    public function oneNewsletterAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $oneNewsletter=$em->getRepository('FrontOfficeBundle:Newsletter')->find($id);

        if($oneNewsletter != null)
        {
            return $this->render('BackOfficeBundle:Abonnes:oneNewsletter.html.twig', array('oneNewsletter'=>$oneNewsletter));
        }
        else
        {
            throw new NotFoundHttpException("Cette newsletter n\'existe pas !");
        }
    }

    public function deleteNewsletterAction(Request $request, $id) 
    {
        $em=$this->getDoctrine()->getManager();
        $session=$request->getSession();
        $deletedNewsletter=$em->getRepository('FrontOfficeBundle:Newsletter')->find($id);

        if($deletedNewsletter != null)
        {
            $em->remove($deletedNewsletter);
            $em->flush();
            $session->getFlashBag()->add('newsletter','Cette newsletter est bien supprimée !');
            return $this->redirectToRoute('back_office_newsletter_createNewsletter');
        }
        else
        {
            throw new NotFoundHttpException("Cette newsletter n\'existe pas !");
        }
    }

    public function sendNewsletterAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$request->getSession();
        $oneNewsletter=$em->getRepository('FrontOfficeBundle:Newsletter')->find($id);                    

        if($oneNewsletter != null)
        {
            // Récupération des mails des inscrits :
            $listMailsObjects=$em->getRepository('FrontOfficeBundle:Mail')->findAll();

            $listMailsSubscribers=array();
            foreach($listMailsObjects as $mail)
            {
                $mailString=$mail->getEmail();
                $listMailsSubscribers[]=$mailString;
            }            
            //

            // Récupère les mails des users !
            $listUsers=$em->getRepository('UserBundle:User')->findAll();

            $listMailsUsers=array();
            foreach($listUsers as $user)
            {
                $mail=$user->getEmail();
                $listMailsUsers[]=$mail;
            }
            //
            
            $listFinals=array_merge($listMailsSubscribers, $listMailsUsers);
            $listFinalsMailsToSend=array_unique($listFinals);

            // Instanciation du mail contenant la newsletter :
            $subject=$oneNewsletter->getTitle();
            $mailTo=null;
            $mailFrom='orientour@wanadoo.fr';
            $body=$this->renderView('BackOfficeBundle:Abonnes:oneNewsletter.html.twig', array('oneNewsletter'=>$oneNewsletter));
            
            foreach($listFinalsMailsToSend as $sendMail)
            {                
                $mailTo=$sendMail;
                $this->get('front_office_mail_service')->send($subject, $mailTo, $mailFrom, $body);
            }

            $session->getFlashBag()->add('newsletterSend','Cette newsletter est bien envoyée ! Cette opération peut prendre un petit peu de temps !');
            return $this->redirectToRoute('back_office_newsletter_createNewsletter');
            
        }
        else
        {
            throw new NotFoundHttpException("Cette newsletter n\'existe pas !");
        }
    }

    public function updateAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$request->getSession();
        $newsletterUpdated=$em->getRepository('FrontOfficeBundle:Newsletter')->find($id);
        $form=$this->createForm(NewsletterType::class, $newsletterUpdated);

        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted())
        {
            $images=$newsletterUpdated->getImage();

            foreach($images as $image)
            {
                $file=$image->getFilename();
                $filename=md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('images_directory'), $filename);
                $image->setFilename($filename);

                $file1=$image->getFilename1();
                if($file1 != null)
                {
                    $filename1=md5(uniqid());'.'.$file1->guessExtension();
                    $file1->move($this->getParameter('images_directory'), $filename1);
                    $image->setFilename1($filename1);                    
                }

                $file2=$image->getFilename2();
                if($file2 != null)
                {
                    $filename2=md5(uniqid()).'.'.$file2->guessExtension();
                    $file2->move($this->getParameter('images_directory'),$filename2);
                    $image->setFilename2($filename2);
                }                            
            }

            $em->flush();
            $session->getFlashBag()->add('newsletterUpdated','Cette newsletter est mise à jour !');
            return $this->redirectToRoute('back_office_newsletter_oneNewsletter', array('id'=>$id));
        }

        return $this->render('BackOfficeBundle:Abonnes:newsletterUpdated.html.twig', 
            array('newsletterUpdated'=>$newsletterUpdated, 'form'=>$form->createView()));        
    }

}