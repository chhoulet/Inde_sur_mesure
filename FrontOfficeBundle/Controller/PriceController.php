<?php

namespace FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FrontOfficeBundle\Form\ReservationType;
use FrontOfficeBundle\Entity\Reservation;

class PriceController extends Controller
{
	public function ShowAction(Request $request, $id)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$affich=1;
		$trip=$em->getRepository('FrontOfficeBundle:Trip')->find($id);

		if($trip != null)	
		{	
			$reservation=new Reservation();
			$prices=$trip->getPrice();

			foreach($prices as $price)
			{
				$reservation->addPrice($price);				
			}

			$user=$this->getUser();

			$form=$this->createForm(ReservationType::class, $reservation);
			if($user != null)
			{
				//Récupération des données de l'user
				$email=$user->getEmail();
				$name=$user->getName();
				$firstname= $user->getFirstname();
				$adress= $user->getAdress();
				$city=$user->getCity();
				$postcode=$user->getPostcode();
				$phone=$user->getPhoneNumber();
				//

				//Instanciation d'un objet Réservation et hydratation avec les données de l'User			
				$reservation->setName($name);			
				$reservation->setFirstname($firstname);			
				$reservation->setMail($email);			
				$reservation->setAdress($adress);			
				$reservation->setCity($city);			
				$reservation->setPostcode($postcode);			
				$reservation->setPhone($phone);
				$reservation->setUser($user);
				//
							

				// Test pour tester si l'user n'a pas déjà réservé ce voyage
				$listUsersForThisTrip=$trip->getUser();
				$listUserId=array();
				foreach($listUsersForThisTrip as $userTrip)
				{
					$idUser=$userTrip->getId();
					$listUserId[]=$idUser;
				}
				//

				if(!in_array($user->getId(), $listUserId))
				{					
					$form->handleRequest($request);

					if($form->isValid() && $form->isSubmitted())
					{						
						// Recueil des données de la commande:	
						$priceSelected=$reservation->getPrice();
						$customer=$reservation->getName() . $reservation->getFirstname();
						$mail=$reservation->getMail();
						$completeAdresse=$reservation->getAdress() . $reservation->getCity() . $reservation->getPostcode();			

						// Calcul du montant de la commande
						$amount=array();
						foreach($priceSelected as $price)
						{
							$single=$price->getSingle();
							$couple=$price->getCouple();
							$numberRoomsSingle=$price->getNumberRoomsSingle();
							$numberRoomsCouple=$price->getNumberRoomsCouple();							

							$pricePerSingle=$single*$numberRoomsSingle;
							$pricePerCouple=$couple*$numberRoomsCouple;
							$finalPrice=$pricePerSingle+$pricePerCouple;

							array_push($amount, $finalPrice);
						}
						//

						$listPrices=array();
						foreach($priceSelected as $price)
						{
							$numberRoomsSingl=$price->getNumberRoomsSingle();
							$numberRoomsCoupl=$price->getNumberRoomsCouple();							
							if($numberRoomsSingl != 0 || $numberRoomsCoupl != 0)
							{
								$listPrices[]=$price;
							}
							
						}

						if($listPrices == null)						
						{							
							$session->getFlashBag()->add('resaNull', 'Vous ne pouvez valider votre réservation si vous n\'avez pas saisi au moins un tarif ! ');
							return $this->render('FrontOfficeBundle:Price:show.html.twig', 
								array('trip'=>$trip,'prices'=>$prices,'form'=>$form->createView(), 'affich'=>$affich));								
						}

						//Hydratation de l'objet Reservation avec les donnees de l'user					
						$amountTotal=array_sum($amount);
						$reservation->setAmountTotal($amountTotal);
						$reservation->setDateCreated(new \DateTime());
						$reservation->setTrip($trip);
						$reservation->setUser($user);
						$trip->addReservation($reservation);
						$trip->addUser($user);

						$em->persist($reservation);			
						$em->flush();

						$subject= 'Votre réservation pour le voyage ' . $trip->getTitle();
						$mailTo=$email;
						$mailFrom='contact@OrientServices.fr';
						$body='Votre réservation au nom de ' . $customer . ' est bien enregistrée ! Nous reprendrons contact avec vous dans les plus brefs délais pour valider définitivement votre voyage !';

						$this->get('front_office_mail_service')->send($subject, $mailTo, $mailFrom, $body);

						$session->getFlashBag()->add('resa', $reservation->getFirstname() .' ' . $reservation->getName() . ' , votre réservation est bien enregistrée ! Un mail récapitulatif vient de vous être envoyé ! Nous revenons vers vous dans les plus brefs délais pour valider définitivement votre séjour. Merci de votre confiance.');
						return $this->redirectToRoute('front_office_trip_oneTrip', array('id'=>$id));
					}

					return $this->render('FrontOfficeBundle:Price:show.html.twig', 
						array('trip'=>$trip,'prices'=>$prices,'form'=>$form->createView(), 'affich'=>$affich));
				}
				else
				{
					$affich=2;
					$session->getFlashBag()->add('NotUnique','Bonjour, une réservation est déjà enregistrée au nom de ' .  $reservation->getFirstname() .' ' . $reservation->getName() . '.');
					return $this->render('FrontOfficeBundle:Price:show.html.twig', 
						array('trip'=>$trip,'prices'=>$prices,'form'=>$form->createView(),'affich'=>$affich));
				}	
			}
			else
			{
				return $this->render('FrontOfficeBundle:Price:show.html.twig', 
						array('trip'=>$trip,'prices'=>$prices,'form'=>$form->createView(),'affich'=>$affich));
			}
		}
		else
		{
			throw new NotFoundHttpException("Le voyage recherché n'existe pas !");			
		}
	}	
}

