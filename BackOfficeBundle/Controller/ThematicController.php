<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrontOfficeBundle\Entity\Thematic;
use FrontOfficeBundle\Entity\Image;
use FrontOfficeBundle\Form\ThematicType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

Class ThematicController extends Controller
{
	public function listAndcreateAction(Request $request)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$affich=1;
		$listThematics=$em->getRepository('FrontOfficeBundle:Thematic')->findAll();
		$thematic=new Thematic();
		$image=new Image();

		$image->setFilename('filename');
		$image->setFilename1('filename1');
		$image->setFilename2('filename2');
		$image->setThematic($thematic);		
		$thematic->getImage()->add($image);
		
		$form=$this->createForm(ThematicType::class, $thematic);

		$form->handlerequest($request);

		if($form->isValid() && $form->isSubmitted())
		{	
			$image=$thematic->getImage();

			foreach($image as $img)
			{
				
				$file=$img->getFilename();
				if($file != null)
				{
					$filename=md5(uniqid()). '.' . $file->guessExtension();
					$file->move($this->getParameter('images_directory'), $filename);
					$img->setFilename($filename);
				}

				$file1=$img->getFilename1();
				if($file1 != null)
				{
					$filename1=md5(uniqid()).'.'. $file1->guessExtension();
					$file1->move($this->getParameter('images_directory'), $filename1);
					$img->setFilename1($filename1);
				}

				$file2=$img->getFilename2();
				if($file2 != null)
				{
					$filename2=md5(uniqid()).'.'. $file2->guessExtension();
					$file2->move($this->getParameter('images_directory'), $filename2);
					$img->setFilename2($filename2);
				}				
			}

			$em->persist($thematic);
			$em->flush();

			$session->getFlashBag()->add('succes','Une nouvelle thématique est ajoutée au site !');
			return $this->redirectToRoute('back_office_thematic_listAndcreate');
		}
		
		return $this->render('BackOfficeBundle:Thematic:listAndcreate.html.twig', 
			array('listThematics'=> $listThematics,
				  'affich'       =>$affich,
			      'form'         => $form->createView()));
	}

	public function updateAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$affich=2;
		$listThematics=$em->getRepository('FrontOfficeBundle:Thematic')->findAll();
		$updatedThematic=$em->getRepository('FrontOfficeBundle:Thematic')->find($id);

		if($updatedThematic != null)
		{			
			$form=$this->createForm(ThematicType::class, $updatedThematic);

			$form->handleRequest($request);

			if($form->isValid() && $form->isSubmitted())
			{
				$images=$updatedThematic->getImage();

				if($images != null)
				{
					foreach($images as $image)
					{
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
							$filename2=md5(uniqid()).'.'.$file2->guessExtension();
							$file2->move($this->getParameter('images_directory'), $filename2);
							$image->setFilename2($filename2);
						}
					}

					$em->flush();

					$session->getFlashBag()->add('succesUpdate','Cette thématique est mise à jour !');
					return $this->redirectToRoute('back_office_thematic_listAndcreate');
				}
			}
		}
		else
		{
			throw new NotFoundHttpException("Cette thématique n\'existe pas !");
		}

		return $this->render('BackOfficeBundle:Thematic:listAndcreate.html.twig', 
			array('listThematics'=> $listThematics,
				  'affich'       =>$affich,
			      'form'         => $form->createView()));
	}

	public function deleteAction(Request $request,$id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$deletedThematic=$em->getRepository('FrontOfficeBundle:Thematic')->find($id);

		if($deletedThematic != null)
		{
			$em->remove($deletedThematic);
			$em->flush();

			$session->getFlashBag()->add('succesdelete','Cette thématique est supprimée !');
			return $this->redirectToRoute('back_office_thematic_listAndcreate');
		}
		else
		{
			throw new NotFoundHttpException("Cette thématique n'existe pas !");
		}
	}

	public function activateAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$activatedThematic=$em->getRepository('FrontOfficeBundle:Thematic')->find($id);

		if($activatedThematic != null)
		{
			$activatedThematic->setActive(1);
			$em->flush();

			$session->getFlashBag()->add('succesactivate','Cette thématique est activée !');
			return $this->redirectToRoute('back_office_thematic_listAndcreate');
		}
		else
		{
			throw new NotFoundHttpException("Cette thématique n'existe pas !");
		}
	}

	public function desactivateAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$desactivatedThematic=$em->getRepository('FrontOfficeBundle:Thematic')->find($id);

		if($desactivatedThematic != null)
		{
			$desactivatedThematic->setActive(2);
			$em->flush();

			$session->getFlashBag()->add('succesDesactivate','Cette thématique est désactivée !');
			return $this->redirectToRoute('back_office_thematic_listAndcreate');
		}
		else
		{
			throw new NotFoundHttpException("Cette thématique n'existe pas !");
		}
	}
}