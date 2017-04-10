<?php

namespace FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="FrontOfficeBundle\Repository\ReservationRepository")
 */
class Reservation
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
     * @ORM\Column(name="name", type="string", length=80, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 80,
     *      minMessage = "Votre nom ne peut comporter moins de {{ limit }} caractères",
     *      maxMessage = "Votre nom ne peut comporter plus de {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=80, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 80,
     *      minMessage = "Votre prénom ne peut comporter moins de {{ limit }} caractères",
     *      maxMessage = "Votre prénom ne peut comporter plus de {{ limit }} caractères"
     * )
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=85, nullable=true)
     * @Assert\NotBlank()
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=90, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 90,
     *      minMessage = "L'adresse ne peut comporter moins de {{ limit }} caractères",
     *      maxMessage = "L'adresse ne peut comporter plus de {{ limit }} caractères"
     * )
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "La ville ne peut comporter moins de {{ limit }} caractères",
     *      maxMessage = "La ville  ne peut comporter plus de {{ limit }} caractères"
     * )
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=20, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Le code postal ne peut comporter moins de {{ limit }} caractères",
     *      maxMessage = "Le code postal  ne peut comporter plus de {{ limit }} caractères"
     * )
     */
    private $postcode;

    /**
     * @var text
     *
     * @ORM\Column(name="comment", type="text", length=4850, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 4850,
     *      minMessage = "Votre message ne peut comporter moins de {{ limit }} caractères",
     *      maxMessage = "Votre message ne peut comporter plus de {{ limit }} caractères"
     * )
     */
    private $comment;

     /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=955, nullable=true)
     */
    private $phone;

     /**
     * @var string
     *
     * @ORM\Column(name="commentAdmin", type="string", length=955, nullable=true)
     */
    private $commentAdmin;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrAdults", type="integer")
     */
    private $nbrAdults;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrChildren", type="integer")
     */
    private $nbrChildren;

    /**
     * @var int
     *
     * @ORM\Column(name="amountTotal", type="integer", nullable=true)
     */
    private $amountTotal;

     /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer", nullable=true)
     */
    private $state=0; // 0=reçue, 1 =en traitement, 2=vendue,  3=annulée, 4=archivée

     /**
     * @var boolean
     *
     * @ORM\Column(name="archived", type="boolean")
     */
    private $archived=false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accepted", type="boolean")
     */
    private $accepted=false;

     /**
     * @var datetime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

     /**    
     *
     * @ORM\ManyToMany(targetEntity="FrontOfficeBundle\Entity\Price", inversedBy="reservations")
     * @ORM\JoinTable(name="price_reservation")
     */
    private $price;

     /**    
     *
     * @ORM\ManyToOne(targetEntity="FrontOfficeBundle\Entity\Trip", inversedBy="reservations")
     * @ORM\JoinColumn(name="trip_id", referencedColumnName="id")
     */
    private $trip;

     /**    
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="reservations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


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
     * Set name
     *
     * @param string $name
     *
     * @return Reservation
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
     * @return Reservation
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
     * Set mail
     *
     * @param string $mail
     *
     * @return Reservation
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Reservation
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
     * Set city
     *
     * @param string $city
     *
     * @return Reservation
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
     * Set postcode
     *
     * @param string $postcode
     *
     * @return Reservation
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
     * Set comment
     *
     * @param string $comment
     *
     * @return Reservation
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }  

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Reservation
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->price = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add price
     *
     * @param \FrontOfficeBundle\Entity\Price $price
     *
     * @return Reservation
     */
    public function addPrice(\FrontOfficeBundle\Entity\Price $price)
    {
        $this->price[] = $price;

        return $this;
    }

    /**
     * Remove price
     *
     * @param \FrontOfficeBundle\Entity\Price $price
     */
    public function removePrice(\FrontOfficeBundle\Entity\Price $price)
    {
        $this->price->removeElement($price);
    }

    /**
     * Get price
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set amountTotal
     *
     * @param integer $amountTotal
     *
     * @return Reservation
     */
    public function setAmountTotal($amountTotal)
    {
        $this->amountTotal = $amountTotal;

        return $this;
    }

    /**
     * Get amountTotal
     *
     * @return integer
     */
    public function getAmountTotal()
    {
        return $this->amountTotal;
    }

    /**
     * Set trip
     *
     * @param \FrontOfficeBundle\Entity\Trip $trip
     *
     * @return Reservation
     */
    public function setTrip(\FrontOfficeBundle\Entity\Trip $trip = null)
    {
        $this->trip = $trip;

        return $this;
    }

    /**
     * Get trip
     *
     * @return \FrontOfficeBundle\Entity\Trip
     */
    public function getTrip()
    {
        return $this->trip;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Reservation
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Reservation
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set nbrAdults
     *
     * @param integer $nbrAdults
     *
     * @return Reservation
     */
    public function setNbrAdults($nbrAdults)
    {
        $this->nbrAdults = $nbrAdults;

        return $this;
    }

    /**
     * Get nbrAdults
     *
     * @return integer
     */
    public function getNbrAdults()
    {
        return $this->nbrAdults;
    }

    /**
     * Set nbrChildren
     *
     * @param integer $nbrChildren
     *
     * @return Reservation
     */
    public function setNbrChildren($nbrChildren)
    {
        $this->nbrChildren = $nbrChildren;

        return $this;
    }

    /**
     * Get nbrChildren
     *
     * @return integer
     */
    public function getNbrChildren()
    {
        return $this->nbrChildren;
    }


    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Reservation
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set archived
     *
     * @param boolean $archived
     *
     * @return Reservation
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Get archived
     *
     * @return boolean
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * Set accepted
     *
     * @param boolean $accepted
     *
     * @return Reservation
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return boolean
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set commentAdmin
     *
     * @param string $commentAdmin
     *
     * @return Reservation
     */
    public function setCommentAdmin($commentAdmin)
    {
        $this->commentAdmin = $commentAdmin;

        return $this;
    }

    /**
     * Get commentAdmin
     *
     * @return string
     */
    public function getCommentAdmin()
    {
        return $this->commentAdmin;
    }
}
