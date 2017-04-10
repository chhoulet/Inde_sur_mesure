<?php

namespace FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trip
 *
 * @ORM\Table(name="trip")
 * @ORM\Entity(repositoryClass="FrontOfficeBundle\Repository\TripRepository")
 */
class Trip
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
     * @ORM\Column(name="title", type="string", nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 320,
     *      minMessage = "Votre titre ne peut pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Votre titre ne peut pas faire plus de  {{ limit }} caractères"
     * )
     */
    private $title;

    /**
     * @var text
     *
     * @ORM\Column(name="comment1", type="text", length=9550, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 9550,
     *      minMessage = "Votre texte ne peut pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de  {{ limit }} caractères"
     * )
     */
    private $comment1;

    /**
     * @var text
     *
     * @ORM\Column(name="comment2", type="text", length=9550, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 9550,
     *      minMessage = "Votre texte ne peut pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de  {{ limit }} caractères"
     * )
     */
    private $comment2;

    /**
     * @var string
     *
     * @ORM\Column(name="period", type="string", length=90, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 90,
     *      minMessage = "Votre texte ne peut pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de  {{ limit }} caractères"
     * )
     */
    private $period;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=190, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 190,
     *      minMessage = "Le lieu de votre séjour ne peut pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Le lieu de votre séjour ne peut pas faire plus de  {{ limit }} caractères"
     * )
     */
    private $place;

    /**
     * @var \Date
     *
     * @ORM\Column(name="dateBegining", type="date", nullable=true)
     */
    private $dateBegining;

    /**
     * @var \Date
     *
     * @ORM\Column(name="dateEnding", type="date", nullable=true)
     */
    private $dateEnding;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetimetz")
     */
    private $dateCreated;

    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text", length=4990, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 4990,
     *      minMessage = "Votre texte ne peut pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de  {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="numberPerson", type="integer", nullable=true)
     */
    private $numberPerson;   

    /**
     * @var int
     *
     * @ORM\Column(name="numberDays", type="integer", nullable=true)
     */
    private $numberDays;

    /**
     * @var int
     *
     * @ORM\Column(name="origin", type="integer", nullable=true)
     */
    private $origin;

    /**
     * @var int
     *
     * @ORM\Column(name="globalPrice", type="integer", nullable=true)
     */
    private $globalPrice;   

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $brochure;

    /**
     * @var string
     *
     * @ORM\Column(name="active", type="string", length=1)
     */
    private $active=1;

    /**
     * @var boolean
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public=true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sold", type="boolean")
     */
    private $sold=false;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="integer")
     */
    private $state=0;//state=1 Refusé

    /**
     * @var integer
     *
     * @ORM\Column(name="bobleTrip", type="integer")
     */
    private $bobleTrip=1;//2 doublure d'un voyage privé

     /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="FrontOfficeBundle\Entity\Thematic", inversedBy="trip")
     * @ORM\JoinColumn(name="thematic_id", referencedColumnName="id", nullable=true)
     */
    private $thematic;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="FrontOfficeBundle\Entity\UnderlineTrip", mappedBy="trip", cascade={"persist","remove"})    
     */
    private $underlineTrip;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="FrontOfficeBundle\Entity\Image", mappedBy="trip", cascade={"persist","remove"})    
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="FrontOfficeBundle\Entity\Reservation", mappedBy="trip", cascade={"remove"})    
     */
    private $reservations;

     /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="FrontOfficeBundle\Entity\Article", mappedBy="trip", cascade={"remove"})    
     */
    private $article;

    /**
     * @var string
     *
     * @ORM\ManyToMany(targetEntity="FrontOfficeBundle\Entity\Estimate", inversedBy="trip")    
     * @ORM\JoinTable(name="estimate_trip")
     */
    private $estimate;

    /**    
     *
     * @ORM\ManyToMany(targetEntity="FrontOfficeBundle\Entity\Price", mappedBy="trip", cascade={"remove"})    
     */
    private $price; 

    /**    
     *
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", inversedBy="trip")
     * @ORM\JoinTable(name="trip_user")   
     */
    private $user; 

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Trip
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set period
     *
     * @param string $period
     *
     * @return Trip
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return string
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set place
     *
     * @param string $place
     *
     * @return Trip
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set dateBegining
     *
     * @param \DateTime $dateBegining
     *
     * @return Trip
     */
    public function setDateBegining($dateBegining)
    {
        $this->dateBegining = $dateBegining;

        return $this;
    }

    /**
     * Get dateBegining
     *
     * @return \DateTime
     */
    public function getDateBegining()
    {
        return $this->dateBegining;
    }

    /**
     * Set dateEnding
     *
     * @param \DateTime $dateEnding
     *
     * @return Trip
     */
    public function setDateEnding($dateEnding)
    {
        $this->dateEnding = $dateEnding;

        return $this;
    }

    /**
     * Get dateEnding
     *
     * @return \DateTime
     */
    public function getDateEnding()
    {
        return $this->dateEnding;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Trip
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set numberPerson
     *
     * @param integer $numberPerson
     *
     * @return Trip
     */
    public function setNumberPerson($numberPerson)
    {
        $this->numberPerson = $numberPerson;

        return $this;
    }

    /**
     * Get numberPerson
     *
     * @return integer
     */
    public function getNumberPerson()
    {
        return $this->numberPerson;
    }   

    /**
     * Set numberDays
     *
     * @param integer $numberDays
     *
     * @return Trip
     */
    public function setNumberDays($numberDays)
    {
        $this->numberDays = $numberDays;

        return $this;
    }

    /**
     * Get numberDays
     *
     * @return integer
     */
    public function getNumberDays()
    {
        return $this->numberDays;
    }

    /**
     * Set origin
     *
     * @param integer $origin
     *
     * @return Trip
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin
     *
     * @return integer
     */
    public function getOrigin()
    {
        return $this->origin;
    }      

    /**
     * Set thematic
     *
     * @param \FrontOfficeBundle\Entity\Thematic $thematic
     *
     * @return Trip
     */
    public function setThematic(\FrontOfficeBundle\Entity\Thematic $thematic = null)
    {
        $this->thematic = $thematic;

        return $this;
    }

    /**
     * Get thematic
     *
     * @return \FrontOfficeBundle\Entity\Thematic
     */
    public function getThematic()
    {
        return $this->thematic;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->underlineTrip = new \Doctrine\Common\Collections\ArrayCollection();
        $this->image = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add underlineTrip
     *
     * @param \FrontOfficeBundle\Entity\UnderlineTrip $underlineTrip
     *
     * @return Trip
     */
    public function addUnderlineTrip(\FrontOfficeBundle\Entity\UnderlineTrip $underlineTrip)
    {
        $this->underlineTrip[] = $underlineTrip;

        return $this;
    }

    /**
     * Remove underlineTrip
     *
     * @param \FrontOfficeBundle\Entity\UnderlineTrip $underlineTrip
     */
    public function removeUnderlineTrip(\FrontOfficeBundle\Entity\UnderlineTrip $underlineTrip)
    {
        $this->underlineTrip->removeElement($underlineTrip);
    }

    /**
     * Get underlineTrip
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUnderlineTrip()
    {
        return $this->underlineTrip;
    }

    /**
     * Add image
     *
     * @param \FrontOfficeBundle\Entity\Image $image
     *
     * @return Trip
     */
    public function addImage(\FrontOfficeBundle\Entity\Image $image)
    {
        $this->image[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \FrontOfficeBundle\Entity\Image $image
     */
    public function removeImage(\FrontOfficeBundle\Entity\Image $image)
    {
        $this->image->removeElement($image);
    }

    /**
     * Get image
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set comment1
     *
     * @param string $comment1
     *
     * @return Trip
     */
    public function setComment1($comment1)
    {
        $this->comment1 = $comment1;

        return $this;
    }

    /**
     * Get comment1
     *
     * @return string
     */
    public function getComment1()
    {
        return $this->comment1;
    }

    /**
     * Set comment2
     *
     * @param string $comment2
     *
     * @return Trip
     */
    public function setComment2($comment2)
    {
        $this->comment2 = $comment2;

        return $this;
    }

    /**
     * Get comment2
     *
     * @return string
     */
    public function getComment2()
    {
        return $this->comment2;
    }

    /**
     * Set brochure
     *
     * @param string $brochure
     *
     * @return Trip
     */
    public function setBrochure($brochure)
    {
        $this->brochure = $brochure;

        return $this;
    }

    /**
     * Get brochure
     *
     * @return string
     */
    public function getBrochure()
    {
        return $this->brochure;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Trip
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
     * Add price
     *
     * @param \FrontOfficeBundle\Entity\Price $price
     *
     * @return Trip
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
     * Add reservation
     *
     * @param \FrontOfficeBundle\Entity\Reservation $reservation
     *
     * @return Trip
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
     * Add user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Trip
     */
    public function addUser(\UserBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \UserBundle\Entity\User $user
     */
    public function removeUser(\UserBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set active
     *
     * @param string $active
     *
     * @return Trip
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add article
     *
     * @param \FrontOfficeBundle\Entity\Article $article
     *
     * @return Trip
     */
    public function addArticle(\FrontOfficeBundle\Entity\Article $article)
    {
        $this->article[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \FrontOfficeBundle\Entity\Article $article
     */
    public function removeArticle(\FrontOfficeBundle\Entity\Article $article)
    {
        $this->article->removeElement($article);
    }

    /**
     * Get article
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticle()
    {
        return $this->article;
    }

    
    /**
     * Set public
     *
     * @param boolean $public
     *
     * @return Trip
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set sold
     *
     * @param boolean $sold
     *
     * @return Trip
     */
    public function setSold($sold)
    {
        $this->sold = $sold;

        return $this;
    }

    /**
     * Get sold
     *
     * @return boolean
     */
    public function getSold()
    {
        return $this->sold;
    }

    /**
     * Set globalPrice
     *
     * @param integer $globalPrice
     *
     * @return Trip
     */
    public function setGlobalPrice($globalPrice)
    {
        $this->globalPrice = $globalPrice;

        return $this;
    }

    /**
     * Get globalPrice
     *
     * @return integer
     */
    public function getGlobalPrice()
    {
        return $this->globalPrice;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Trip
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
     * Add estimate
     *
     * @param \FrontOfficeBundle\Entity\Estimate $estimate
     *
     * @return Trip
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
     * Set bobleTrip
     *
     * @param integer $bobleTrip
     *
     * @return Trip
     */
    public function setBobleTrip($bobleTrip)
    {
        $this->bobleTrip = $bobleTrip;

        return $this;
    }

    /**
     * Get bobleTrip
     *
     * @return integer
     */
    public function getBobleTrip()
    {
        return $this->bobleTrip;
    }
}
