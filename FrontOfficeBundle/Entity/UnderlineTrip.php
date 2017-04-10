<?php

namespace FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UnderlineTrip
 *
 * @ORM\Table(name="underlineTrip")
 * @ORM\Entity(repositoryClass="FrontOfficeBundle\Repository\UnderlineTripRepository")
 */
class UnderlineTrip
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
     * @ORM\Column(name="undertitle", type="string", length=250, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 250,
     *      minMessage = "Votre titre ne peut pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Votre titre ne peut pas faire plus de  {{ limit }} caractères"
     * )
     */
    private $undertitle;

    /**
     * @var text
     *
     * @ORM\Column(name="main", type="text", length=6890, nullable=true)
     * @Assert\Length(
     *      min = 10,
     *      max = 6890,
     *      minMessage = "Votre texte ne peut pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut pas faire plus de  {{ limit }} caractères"
     * )
     */
    private $main;

     /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="FrontOfficeBundle\Entity\Trip", inversedBy="underlineTrip")
     * @ORM\JoinColumn(name="trip_id", referencedColumnName="id", nullable=true)
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
     * Set undertitle
     *
     * @param string $undertitle
     *
     * @return UnderlineTrip
     */
    public function setUndertitle($undertitle)
    {
        $this->undertitle = $undertitle;

        return $this;
    }

    /**
     * Get undertitle
     *
     * @return string
     */
    public function getUndertitle()
    {
        return $this->undertitle;
    }

    /**
     * Set main
     *
     * @param string $main
     *
     * @return UnderlineTrip
     */
    public function setMain($main)
    {
        $this->main = $main;

        return $this;
    }

    /**
     * Get main
     *
     * @return string
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * Set trip
     *
     * @param \FrontOfficeBundle\Entity\Trip $trip
     *
     * @return UnderlineTrip
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
     * Set photo
     *
     * @param string $photo
     *
     * @return UnderlineTrip
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }
}
