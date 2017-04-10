<?php


namespace UserBundle\Controller;

use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use UserBundle\Form\UserType;


class ProfileController extends Controller
{    
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('Vous n\'avez pas acces à cet espace !');
        }

        // Liste des demandes de devis envoyées par l'user
        $em=$this->getDoctrine()->getManager();
        $dateOfTheDay=new \DateTime();
        $timeStampDateDay=$dateOfTheDay->getTimestamp();
        $estimates=$user->getEstimate();
        $listEstimatesByUser=array();

        if($estimates != null)
        {
            $listEstimatesForThisUser=array();
            foreach($estimates as $estimate)
            {
                $id=$estimate->getId();
                $estimate=$em->getRepository('FrontOfficeBundle:Estimate')->find($id);               
                $dateDepart=$estimate->getDateDeparture();
                $timeStampDateDepart=$dateDepart->getTimestamp();
                $tripsForThisEstimate=$estimate->getTrip();

                if($tripsForThisEstimate != null)
                {
                    foreach($tripsForThisEstimate as $trip)
                    {
                        $dateTrip=$trip->getDateBegining();
                        $timeStampDateTrip=$dateTrip->getTimestamp();
                        if($timeStampDateTrip > $timeStampDateDay)
                        {
                            $listEstimatesForThisUser[]=$estimate;
                        }
                    }
                }

                if($timeStampDateDepart > $timeStampDateDay)
                {
                    $listEstimatesForThisUser[]=$estimate;                
                }
            }

            $listIdEstimates=array();
            if($listEstimatesForThisUser != null)
            {
                foreach($listEstimatesForThisUser as $idEstim)
                {
                    $id=$idEstim->getId();
                    $listIdEstimates[]=$id;
                }
            }
            $listIdUniqueByUser=array_unique($listIdEstimates);


            foreach($listIdUniqueByUser as $id)
            {
                $estimate=$em->getRepository('FrontOfficeBundle:Estimate')->find($id);
                $listEstimatesByUser[]=$estimate;
            }
        }           
       
        // Liste des voyages commandés par l'user
        $reservations=$em->getRepository('FrontOfficeBundle:Reservation')->findByUser($user->getId());

        $listFuturesResas=array();

        if($reservations != null)
        {
            foreach($reservations as $resa)
            {
                $dateResa=$resa->getTrip()->getDateBegining();
                $timeStampDateResa=$dateResa->getTimestamp();

                if($timeStampDateResa > $timeStampDateDay)
                {
                    $listFuturesResas[]=$resa;
                }            
            }            
        }
 
        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'estimatesByUser'=>$listEstimatesByUser,
            'reservations'=>$listFuturesResas
        ));
    }

     /**
     * Edit the user
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Request $request)
    {
        $session=$request->getSession();
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory FactoryInterface */
        $form = $this->createForm(UserType::class, $user);        

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        $session->getFlashBag()->add('editProfil', 'Votre profil est bien mis à jour !');
        return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

}