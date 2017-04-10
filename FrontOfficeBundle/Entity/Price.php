<?php

namespace FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Price
 *
 * @ORM\Table(name="price")
 * @ORM\Entity(repositoryClass="FrontOfficeBundle\Repository\PriceRepository")
 */
class Price
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=120)
     * @Assert\Length(
     *      min = 2,
     *      max = 120,
     *      minMessage = "La catégorie ne peut comporter moins de {{ limit }} caractères",
     *      maxMessage = "La catégorie ne peut comporter plus de {{ limit }} caractères"
     * )
     */
    private $category;

    /**
     * @var int
     *
     * @ORM\Column(name="single", type="integer", nullable=true)
     */
    private $single;

    /**
     * @var int
     *
     * @ORM\Column(name="couple", type="integer", nullable=true)
     */
    private $couple;    

    /**
     * @var int
     *
     * @ORM\Column(name="numberRoomsSingle", type="integer", nullable=true)
     */
    private $numberRoomsSingle=0;

    /**
     * @var int
     *
     * @ORM\Column(name="numberRoomsCouple", type="integer", nullable=true)
     */
    private $numberRoomsCouple=0;

    /**    
     *
     * @ORM\ManyToMany(targetEntity="FrontOfficeBundle\Entity\Trip", inversedBy="price")
     * @ORM\JoinTable(name="price_trip")
     */
    private $trip;

    /**   
     *
     * @ORM\ManyToMany(targetEntity="FrontOfficeBundle\Entity\Reservation", mappedBy="price")
     */
    private $reservations;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Price
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->trip = new \Doctrine\Common\Collections\ArrayCollection();
    }

   

    /**
     * Add trip
     *
     * @param \FrontOfficeBundle\Entity\Trip $trip
     *
     * @return Price
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
     * Set single
     *
     * @param integer $single
     *
     * @return Price
     */
    public function setSingle($single)
    {
        $this->single = $single;

        return $this;
    }

    /**
     * Get single
     *
     * @return integer
     */
    public function getSingle()
    {
        return $this->single;
    }

    /**
     * Set couple
     *
     * @param integer $couple
     *
     * @return Price
     */
    public function setCouple($couple)
    {
        $this->couple = $couple;

        return $this;
    }

    /**
     * Get couple
     *
     * @return integer
     */
    public function getCouple()
    {
        return $this->couple;
    }   

    /**
     * Add reservation
     *
     * @param \FrontOfficeBundle\Entity\Reservation $reservation
     *
     * @return Price
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

    

    /**
     * Set numberRoomsSingle
     *
     * @param integer $numberRoomsSingle
     *
     * @return Price
     */
    public function setNumberRoomsSingle($numberRoomsSingle)
    {
        $this->numberRoomsSingle = $numberRoomsSingle;

        return $this;
    }

    /**
     * Get numberRoomsSingle
     *
     * @return integer
     */
    public function getNumberRoomsSingle()
    {
        return $this->numberRoomsSingle;
    }

    /**
     * Set numberRoomsCouple
     *
     * @param integer $numberRoomsCouple
     *
     * @return Price
     */
    public function setNumberRoomsCouple($numberRoomsCouple)
    {
        $this->numberRoomsCouple = $numberRoomsCouple;

        return $this;
    }

    /**
     * Get numberRoomsCouple
     *
     * @return integer
     */
    public function getNumberRoomsCouple()
    {
        return $this->numberRoomsCouple;
    }
}
