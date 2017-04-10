<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrontOfficeBundle\Entity\Image;
use FrontOfficeBundle\Form\ImageType;
use Symfony\Component\HttpFoundation\Request;

Class ImageController extends Controller
{
	public function uploadAction(Request $request)
	{
		$em=$this->getDoctrine()->getManager();
		$image=new Image();
		$form=$this->createForm(ImageType::class, $image);
		$session=$request->getSession();
		$fash=null;
		$imageName=null;
		$listImages=$em->getRepository('FrontOfficeBundle:Image')->findAll();
		

		$form->handleRequest($request);

		if($form->isValid() && $form->isSubmitted())
		{
			$imageForThematicChosen=$image->getThematic()->getImage();
			
			if($imageForThematicChosen != null)
			{
				$imageName=$imageForThematicChosen->getFilename();				
			}
			
			if($imageName == null)
			{
				$file=$image->getFilename();
				$fileName=md5(uniqid()).'.'. $file->guessExtension();
				$file->move($this->getParameter('images_directory'), $fileName);
				$image->setFilename($fileName);
				
				$file1=$image->getFilename1();
				if($file1 != null)
				{
					$fileName1=md5(uniqid()).'.'.$file1->guessExtension();
					$file1->move($this->getParameter('images_directory'),$fileName1);
					$image->setFilename1($fileName1);
					$fash='tutu';
				}

				$file2=$image->getFilename2();
				if($file2 != null)
				{
					$filename2=md5(uniqid()).'.'. $file2->guessExtension();
					$file2->move($this->getParameter('images_directory'), $filename2);
					$image->setFilename2($filename2);
				}

				$em->persist($image);
				$em->flush();

				if($fash == null)
				{
					$session->getFlashbag()->add('photo', 'Votre photo est bien enregistrée !');
					
				}
				else
				{
					$session->getFlashbag()->add('photos', 'Vos photos sont bien enregistrées !');			
				}

				return $this->redirectToRoute('back_office_homepage');				
			}
			else
			{
				$session->getFlashbag()->add('errphotos', 'Des images sont déjà associées à cette thématique ! Editez-là pour les modifier !');
				return $this->redirectToRoute('back_office_homepage');
			}			
		}

		return $this->render('BackOfficeBundle:Image:upload.html.twig', array('form'=>$form->createView(),
																			  'listImages'=>$listImages));
	}
}
