<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FrontOfficeBundle\Entity\UnderlineTrip;
use FrontOfficeBundle\Form\UnderlineTripType;
use FrontOfficeBundle\Entity\Trip;
use FrontOfficeBundle\Entity\Image;
use FrontOfficeBundle\Form\TripType;
use FrontOfficeBundle\Form\UserType;

class DashboardController extends Controller
{
    public function dashboardAction()
    {
        $em=$this->getDoctrine()->getManager();

        //Recueil des reservations en cours :
        $listResa=$em->getRepository('FrontOfficeBundle:Reservation')->getReservationsUnProcessed();
        $nbrResas=$em->getRepository('FrontOfficeBundle:Reservation')->countReservationsUnProcessed();
        $nbrResasProcessed=$em->getRepository('FrontOfficeBundle:Reservation')->countReservationsProcessed();        
        
        //Recueil des demandes de devis en cours:
        $listEstimates=$em->getRepository('FrontOfficeBundle:Estimate')->getEstimatesNonTreated();
        $nbrEstimates=$em->getRepository('FrontOfficeBundle:Estimate')->countEstimatesNonProcessedNonLimited();
        $nbrestimatesprocessed=$em->getRepository('FrontOfficeBundle:Estimate')->countEstimatesProcessed();

        //Calcul du CA généré par les résas et sélection des résas vendues l'année en cours:
          //Définition du timestamp au 1er janvier:
        $dateOfDay= new \Datetime();
        $yearActual=$dateOfDay->format('Y');               
        $beginingYear=$dateOfDay->format('01-01-'.$yearActual);
        $timestampBegin=strtotime($beginingYear);

          //Sélection des résas vendues dans l'année en cours et de leur montant total(€) et calcul du CA de l'année:
        $resasSold=$em->getRepository('FrontOfficeBundle:Reservation')->getReservationsSold();
        $resasSoldYear=array();
        foreach($resasSold as $resa)
        {
            $dateResa=$resa->getDateCreated();
            $stampResa=$dateResa->getTimestamp();
            if($stampResa > $timestampBegin)
            {
                $resasSoldYear[]=$resa;
            }
        }

        $amountResasSoldYear=array();
        foreach($resasSoldYear as $resaS)
        {
            $amount=$resaS->getAmountTotal();
            $amountResasSoldYear[]=$amount;
        }

        $amountTotalRésas=array_sum($amountResasSoldYear);
        $nbrResasSold=count($resasSoldYear);

      // Sélection des voyages sur-mesure vendus dans l'année en cours et de leur montant total(€) et calcul du CA de l'année:
        $tripsSold=$em->getRepository('FrontOfficeBundle:Trip')->getPrivateTrips();

        $tripsSoldYear=array();
        foreach($tripsSold as $trip)
        {
            $dateTrip=$trip->getDateCreated();
            $stampTrip=$dateTrip->getTimestamp();
            if($stampTrip > $timestampBegin)
            {
                $tripsSoldYear[]=$trip;
            }
        }

        $countTripPrivateSold=count($tripsSoldYear);

        $amountTripsSoldYear=array();
        foreach($tripsSoldYear as $tripS)
        {
            $amount=$tripS->getGlobalPrice();
            $amountTripsSoldYear[]=$amount;
        }

        $amountTotalTrips=array_sum($amountTripsSoldYear);

        $amountToTalInde=$amountTotalTrips + $amountTotalRésas;
          
        return $this->render('BackOfficeBundle:Dashboard:dashboard.html.twig', 
            array(                                    
                  'nbrResas'           =>$nbrResas,
                  'nbrEstimates'       =>$nbrEstimates,
                  'listResa'           =>$listResa,
                  'nbrResasProcessed'  =>$nbrResasProcessed,
                  'nbrResasSold'       =>$nbrResasSold,
                  'listEstimates'      =>$listEstimates,
                  'nbrestimatesprocessed'=>$nbrestimatesprocessed,                                    
                  'countTripPrivateSold'=>$countTripPrivateSold,
                  'yearActual'         =>$yearActual,
                  'resasSoldYear'      =>$resasSoldYear,
                  'amountTotalRésas'   =>$amountTotalRésas,
                  'tripsSoldYear'      =>$tripsSoldYear,
                  'amountTotalTrips'   =>$amountTotalTrips,
                  'amountToTalInde'    =>$amountToTalInde));
    }
}
    	
        
