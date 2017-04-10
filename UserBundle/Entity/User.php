<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)    
     */
    protected $name;

     /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)    
     */
    protected $firstname;

     /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255)    
     */
    protected $adress;

     /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=255)    
     */
    protected $postcode;

     /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)    
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=255)    
     */
    protected $phoneNumber;

     /**
     * @var string
     *
     * @ORM\ManyToMany(targetEntity="FrontOfficeBundle\Entity\Trip", mappedBy="user")
     */
    protected $trip;

     /**
     *
     * @ORM\OneToMany(targetEntity="FrontOfficeBundle\Entity\Estimate", mappedBy="user")
     */
    protected $estimate;

    /**
     *
     * @ORM\OneToMany(targetEntity="FrontOfficeBundle\Entity\Reservation", mappedBy="user")
     */
    protected $reservations;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
   {
       parent::__construct();
       // your own logic
   }

   public function getFullName()
   {
        return $this->getName() .' '. $this->getFirstname();
   }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Add trip
     *
     * @param \FrontOfficeBundle\Entity\Trip $trip
     *
     * @return User
     */
    public function addTrip(\FrontOfficeBundle\Entity\Trip $trip)
    {
        $this->trip[] = $trip;

        return $this;
    }

    /**
     * Remove trip
     *
     * @param \FrontOfficeBundle\Entity\Trip $trip
     */
    public function removeTrip(\FrontOfficeBundle\Entity\Trip $trip)
    {
        $this->trip->removeElement($trip);
    }

    /**
     * Get trip
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTrip()
    {
        return $this->trip;
    }

    /**
     * Add estimate
     *
     * @param \FrontOfficeBundle\Entity\Estimate $estimate
     *
     * @return User
     */
    public function addEstimate(\FrontOfficeBundle\Entity\Estimate $estimate)
    {
        $this->estimate[] = $estimate;

        return $this;
    }

    /**
     * Remove estimate
     *
     * @param \FrontOfficeBundle\Entity\Estimate $estimate
     */
    public function removeEstimate(\FrontOfficeBundle\Entity\Estimate $estimate)
    {
        $this->estimate->removeElement($estimate);
    }

    /**
     * Get estimate
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstimate()
    {
        return $this->estimate;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return User
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     *
     * @return User
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Add reservation
     *
     * @param \FrontOfficeBundle\Entity\Reservation $reservation
     *
     * @return User
     */
    public function addReservation(\FrontOfficeBundle\Entity\Reservation $reservation)
    {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \FrontOfficeBundle\Entity\Reservation $reservation
     */
    public function removeReservation(\FrontOfficeBundle\Entity\Reservation $reservation)
    {
        $this->reservations->removeElement($reservation);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservations()
    {
        return $this->reservations;
    }
}
