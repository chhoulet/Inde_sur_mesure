<?php


namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrontOfficeBundle\Entity\Trip;
use FrontOfficeBundle\Entity\Image;
use FrontOfficeBundle\Entity\UnderlineTrip;
use FrontOfficeBundle\Form\UnderlineTripType;
use FrontOfficeBundle\Form\TripPrivateType;
use FrontOfficeBundle\Form\TripType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class TripController extends Controller
{
	public function listAndcreateAction(Request $request)
	{
		$em=$this->getDoctrine()->getManager();
        $affich=1;
        $session=$request->getSession();
        $trip=new Trip();        
        $image=new Image();        
        $image->setTrip($trip);       
        $trip->getImage()->add($image);
        $form=$this->createForm(TripType::class, $trip);

        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted())
        {
            $trip->setOrigin(1);
            $trip->setDateCreated(new \DateTime());
            if($trip->getThematic() != null)
            {
                $thematicName=$trip->getThematic()->getName();                
            }

            $file=$image->getFilename();
            if($file != null)
            {
                $filename=md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('images_directory'), $filename);
                $image->setFilename($filename);
            }

            $file1=$image->getFilename1();
            if($file1 != null)
            {
                $filename1=md5(uniqid()) . '.' . $file1->guessExtension();
                $file1->move($this->getParameter('images_directory'), $filename1);
                $image->setFilename1($filename1);
            }

            $file2=$image->getFilename2();
            if($file2 != null)
            {
                $filename2=md5(uniqid()). '.' . $file2->guessExtension();
                $file2->move($this->getParameter('images_directory'), $filename2);
                $image->setFilename2($filename2);
            }

            $docPDF=$trip->getBrochure();
            if($docPDF != null)
            {
                $brochure=md5(uniqid()). '.' . $docPDF->guessExtension();
                $docPDF->move($this->getParameter('brochures_directory'),$brochure);
                $trip->setBrochure($brochure);
            }

            $em->persist($trip);
            $em->flush();

            if($form->get('Save_and_add')->isClicked())
            {
                return $this->redirectToRoute('back_office_underline_trip_create', array('id'=>$trip->getId()));
            }
            else
            {
                if($trip->getThematic() != null)
                {
                    $session->getFlashbag()->add('Trip','Ce voyage est ajouté dans la base et rattaché à la thématique ' . $thematicName);                   
                }
                else
                {
                    $session->getFlashbag()->add('TripName', $trip->getTitle().' est ajouté dans la base.');
                }
                return $this->redirectToRoute('back_office_trip');                
            }        
        }

        $listTrips=$em->getRepository('FrontOfficeBundle:Trip')->getTripCreated();

		return $this->render('BackOfficeBundle:Trip:listAndcreate.html.twig', 
            array('form'=>$form->createView(), 
                  'listTrips'=>$listTrips,
                  'affich'   => $affich,
                  'one'      =>$trip));
	}

    public function unactiveAction(Request $request, $id, $origin)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$request->getSession();
        $trip=$em->getRepository('FrontOfficeBundle:Trip')->find($id);        
        $active=$trip->getActive();

        if(!$trip)
        {
            throw new NotFoundHttpException('Ce voyage n\'existe pas !');
        }
        elseif($active == 0)
        {
            $session->getFlashBag()->add('active', $trip->getTitle() . ' est déjà désactivé et retiré de la liste !');
            if($origin == 1)
            {
                return $this->redirectToRoute('back_office_trip');            
            }
            else
            {
                return $this->redirectToRoute('back_office_trip_listAll'); 
            }            
        }
        
        $trip->setActive(0);
        $em->flush();
        $session->getFlashBag()->add('unactive', $trip->getTitle() . ' a bien été retiré de la liste des voyages disponibles !');

        if($origin == 1)
        {
            return $this->redirectToRoute('back_office_trip');            
        }
        else
        {
            return $this->redirectToRoute('back_office_trip_listAll'); 
        }
    }

    public function activedAction(Request $request, $id, $origin)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$request->getSession();
        $trip=$em->getRepository('FrontOfficeBundle:Trip')->find($id);
        $active=$trip->getActive();      

        if(!$trip)
        {
            throw new NotFoundHttpException('Ce voyage n\'existe pas !');
        }
        elseif($active == 1)
        {
            $session->getFlashBag()->add('actived', $trip->getTitle() . ' est déjà activé et disponible à la vente !');
            return $this->redirectToRoute('back_office_trip');
        }
        
        $trip->setActive(1);
        $em->flush();
        $session->getFlashBag()->add('againactive', $trip->getTitle() . ' a bien été ajouté à la liste des voyages disponibles !');

        if($origin == 1)
        {
            return $this->redirectToRoute('back_office_trip');            
        }
        else
        {            
            return $this->redirectToRoute('back_office_trip_listAll'); 
        }
    }

    public function listAllAction()
    {
        $em=$this->getDoctrine()->getManager();
        $listAll=$em->getRepository('FrontOfficeBundle:Trip')->getTripsPublicCreated();

        return $this->render('BackOfficeBundle:Trip:listAll.html.twig', array('listAll'=>$listAll));
    }

    public function oneAction($id, $origin)
    {
        $em=$this->getDoctrine()->getManager();
        $one=$em->getRepository('FrontOfficeBundle:Trip')->find($id);
        $estimate=$one->getEstimate();
        if($estimate != null)
        {
            $origin=2;
        }
        else
        {
            $origin=1;
        }
/*var_dump($estimate);die;*/
        if(!$one)
        {
            throw new NotFoundHttpException('Ce voyage n\'existe pas !');
        }

        return $this->render('BackOfficeBundle:Trip:one.html.twig', array('one'=>$one, 'origin'=>$origin));
    }

    public function treatedAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$request->getSession();
        $one=$em->getRepository('FrontOfficeBundle:Trip')->find($id);
        $origin=$one->getOrigin();

        if($one->getPublic() == true)
        {
            throw new NotFoundHttpException("Ce voyage n'est pas privé ! Il ne peut être attribué à une demande de devis !");
        }
        else
        {            
            if($one->getEstimate() != null)
            {
                $one->setSold(true);
                $estimates = $one->getEstimate();
                foreach($estimates as $estimate)
                {
                    $estimate->setState(2);
                }
                
                $listTrips=$estimate->getTrip();
                foreach($listTrips as $trip)
                {
                    $sold=$trip->getSold();
                    if($sold == false)
                    {
                        $trip->setState(1);
                    }
                }
                $em->flush();

                $session->getFlashbag()->add('treated', 'Ce voyage est considéré vendu ! La demande de devis correspondante est mise en statut vendue !');
                return $this->redirectToRoute('back_office_estimate_treatment', array('id'=>$estimate->getId(), 'origin'=>$origin));
            }
            else
            {   
                $session->getFlashbag()->add('treat', 'Ce voyage n\'est pas rattaché à une demande de devis !');
                return $this->redirectToRoute('back_office_estimates_list');
            }            
        }
    }

    public function updatedAction(Request $request, $id, $idEstimate=null)  
    {
        $em=$this->getDoctrine()->getManager();
        $session=$request->getSession();
        $affich=2;

        if($id != null) 
        {        
            $one=$em->getRepository('FrontOfficeBundle:Trip')->find($id);
           
            if($one != null)
            {
                $public=$one->getPublic();
                $estimates=$one->getEstimate();
                $images=$one->getImage();

                if($images['image'] != null)
                {
                    foreach($images['image'] as $image1)
                    {                    
                        $one->removeImage($image1);
                    }                    
                }
                                       
                $em->flush();
 
              

                if($public == true)
                {
                    $form=$this->createForm(TripType::class, $one);
                }
                else
                {
                    $form=$this->createForm(TripPrivateType::class, $one);
                }

                $form->handleRequest($request);

                if($form->isValid() && $form->isSubmitted())
                {       
                    $trip=$form->getData();
                    $images=$trip->getImage();
                  
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

                        $brochure=$trip->getBrochure();
                        if($brochure != null)
                        {
                            $filename=md5(uniqid()).'.'.$brochure->guessExtension();
                            $brochure->move($this->getParameter('brochures_directory'), $filename);
                            $one->setBrochure($filename);
                        }
                    }
                    
                    $em->flush();
                    
                    if($form->get('Save_and_add')->isClicked())
                    {
                        $session->getFlashbag()->add('updateTrip','Ce voyage est mis à jour !');
                        return $this->redirectToRoute('back_office_underline_trip_create', array('id'=>$one->getId()));
                    }
                    else
                    {   
                        if($idEstimate != 0)               
                        {
                            $session->getFlashbag()->add('updateTrip2','Ce voyage est mis à jour !');
                            return $this->redirectToRoute('back_office_estimate_listResponses', array('id'=>$idEstimate));
                        }
                        else
                        {
                            $session->getFlashbag()->add('updateTrip1','Ce voyage est mis à jour !');
                            return $this->redirectToRoute('back_office_trip');
                        }                                                     
                    }                   
                }
                
            }
            else
            {
                throw new NotFoundHttpException('Ce voyage n\'existe pas !');
            }
        }
        else
        {
            throw new NotFoundHttpException('Cet identifiant n\'est pas valide !');
        }

        $listTrips=$em->getRepository('FrontOfficeBundle:Trip')->getTripCreated();

        return $this->render('BackOfficeBundle:Trip:listAndcreate.html.twig', 
            array('form'=>$form->createView(), 
                  'listTrips'=>$listTrips,
                  'affich'   => $affich,
                  'one'      =>$one));
    }

    public function deleteAction(Request $request, $id, $originClick)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$request->getSession();
        $affich=1;
        $one=$em->getRepository('FrontOfficeBundle:Trip')->find($id);
        $estimates=$one->getEstimate();
        if($estimates != null)
        {
            foreach($estimates as $estimate)
            {
                $estimate->removeTrip($one);
                $idEstimate=$estimate->getId();
            }            
        }

        if($one != null)
        {
            $em->remove($one);
            $em->flush();

            $session->getFlashbag()->add('deleteTrip','Ce voyage est supprimé !');
            $listTrips=$em->getRepository('FrontOfficeBundle:Trip')->getTripCreated();

            if($originClick == 1)
            {
                return $this->redirectToRoute('back_office_trip');
            }
            elseif($originClick == 2)
            {
                return $this->redirectToRoute('back_office_trip_listAll');
            }
            else
            {                
                return $this->redirectToRoute('back_office_estimate_listResponses', array('id'=>$idEstimate));
            }
        }
        else
        {
            throw new NotFoundHttpException('Ce voyage n\'existe pas !');            
        }
    }

    public function deniedAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        if($id != null)
        {
            $trip=$em->getRepository('FrontOfficeBundle:Trip')->find($id);
            $estimates=$trip->getEstimate();
            foreach($estimates as $estimate)   
            {
                $idEstimate=$estimate->getId();
            }
           
            $public=$trip->getPublic();
            $soldTrip=$trip->getSold();
            if($public == true)
            {
                throw new NotFoundHttpException("Ce voyage est public ! Il ne peut être utilisé comme une réponse à une demande sur-mesure.");
            }
            else
            {
                if($soldTrip == true)
                {
                    $trip->setSold(false);
                }
              
                $trip->setState(1);
                $em->flush();

                return $this->redirectToRoute('back_office_estimate_listResponses', array('id'=>$idEstimate));
            }
        }       
        else
        {
            throw new NotFoundHttpException("Demande de devis inexistant !");
        }
    }
}