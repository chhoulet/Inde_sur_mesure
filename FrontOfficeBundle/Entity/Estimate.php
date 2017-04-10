<?php

namespace FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Estimate
 *
 * @ORM\Table(name="estimate")
 * @ORM\Entity(repositoryClass="FrontOfficeBundle\Repository\EstimateRepository")
 */
class Estimate
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateDeparture", type="date")
     * @Assert\DateTime()
     */
    private $dateDeparture;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSended", type="datetime")
     */
    private $dateSended;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAnswerSended", type="datetime", nullable=true)
     */
    private $dateAnswerSended;

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
     * @ORM\Column(name="nbrDays", type="integer")
     */
    private $nbrDays;

    /**
     * @var text
     *
     * @ORM\Column(name="comment", type="text", length=7000)
     * @Assert\Length(
     *      min = 10,
     *      max = 7000,
     *      minMessage = "Votre message ne peut faire moins de {{ limit }} caractères",
     *      maxMessage = "Votre message ne peut faire plus de {{ limit }} caractères"
     * )
     */
    private $comment;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer", nullable=true)
     */
    private $state=0;//0=reçue, 1 =en traitement, 2=vendue, 3=annulée

     /**
     * @var boolean
     *
     * @ORM\Column(name="archived", type="boolean")
     */
    private $archived=false;  

    /**
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="estimate")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     *
     * @ORM\ManyToMany(targetEntity="FrontOfficeBundle\Entity\Trip", mappedBy="estimate")   
     */
    private $trip;
   

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
     * Set dateDeparture
     *
     * @param \DateTime $dateDeparture
     *
     * @return Estimate
     */
    public function setDateDeparture($dateDeparture)
    {
        $this->dateDeparture = $dateDeparture;

        return $this;
    }

    /**
     * Get dateDeparture
     *
     * @return \DateTime
     */
    public function getDateDeparture()
    {
        return $this->dateDeparture;
    }

    /**
     * Set dateSended
     *
     * @param \DateTime $dateSended
     *
     * @return Estimate
     */
    public function setDateSended($dateSended)
    {
        $this->dateSended = $dateSended;

        return $this;
    }

    /**
     * Get dateSended
     *
     * @return \DateTime
     */
    public function getDateSended()
    {
        return $this->dateSended;
    }

    /**
     * Set nbrAdults
     *
     * @param integer $nbrAdults
     *
     * @return Estimate
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
     * @return Estimate
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
     * Set nbrDays
     *
     * @param integer $nbrDays
     *
     * @return Estimate
     */
    public function setNbrDays($nbrDays)
    {
        $this->nbrDays = $nbrDays;

        return $this;
    }

    /**
     * Get nbrDays
     *
     * @return integer
     */
    public function getNbrDays()
    {
        return $this->nbrDays;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Estimate
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
     * Set comment
     *
     * @param string $comment
     *
     * @return Estimate
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
     * Constructor
     */
    public function __construct()
    {
        $this->trip = new \Doctrine\Common\Collections\ArrayCollection();
    }

    
    /**
     * Set dateAnswerSended
     *
     * @param \DateTime $dateAnswerSended
     *
     * @return Estimate
     */
    public function setDateAnswerSended($dateAnswerSended)
    {
        $this->dateAnswerSended = $dateAnswerSended;

        return $this;
    }

    /**
     * Get dateAnswerSended
     *
     * @return \DateTime
     */
    public function getDateAnswerSended()
    {
        return $this->dateAnswerSended;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Estimate
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
     * @return Estimate
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
     * Add trip
     *
     * @param \FrontOfficeBundle\Entity\Trip $trip
     *
     * @return Estimate
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
}
