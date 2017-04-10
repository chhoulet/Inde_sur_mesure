<?php

namespace FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Thematic
 *
 * @ORM\Table(name="thematic")
 * @ORM\Entity(repositoryClass="FrontOfficeBundle\Repository\ThematicRepository")
 */
class Thematic
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
     * @ORM\Column(name="name", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Votre nom ne peut comporter moins de {{ limit }} caractères",
     *      maxMessage = "Votre nom ne peut comporter plus de {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="underline", type="string", length=550, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 550,
     *      minMessage = "Votre sous-titre ne peut comporter moins de {{ limit }} caractères",
     *      maxMessage = "Votre sous-titre ne peut comporter plus de {{ limit }} caractères"
     * )
     */
    private $underline;

    /**
     * @var text
     *
     * @ORM\Column(name="underline1", type="text", length=2550, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 2550,
     *      minMessage = "Votre sous-titre ne peut comporter moins de {{ limit }} caractères",
     *      maxMessage = "Votre sous-titre ne peut comporter plus de {{ limit }} caractères"
     * )
     */
    private $underline1;

    /**
     * @var text
     *
     * @ORM\Column(name="underline2", type="text", length=2550, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 2550,
     *      minMessage = "Votre sous-titre ne peut comporter moins de {{ limit }} caractères",
     *      maxMessage = "Votre sous-titre ne peut comporter plus de {{ limit }} caractères"
     * )
     */
    private $underline2;

    /**
     * @var text
     *
     * @ORM\Column(name="main1", type="text", length=9550)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 9550,
     *      minMessage = "Votre texte ne peut comporter moins de {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut comporter plus de {{ limit }} caractères"
     * )
     */
    private $main1;

    /**
     * @var text
     *
     * @ORM\Column(name="main2", type="text", length=9550, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 9550,
     *      minMessage = "Votre texte ne peut comporter moins de {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut comporter plus de {{ limit }} caractères"
     * )
     */
    private $main2;

    /**
     * @var string
     *
     * @ORM\Column(name="active", type="string", length=1)
     */
    private $active=1;

    /**
     *      
     * @ORM\OneToMany(targetEntity="FrontOfficeBundle\Entity\Image", mappedBy="thematic", cascade={"persist", "remove"})
     */
    private $image;

    /**
     *      
     * @ORM\OneToMany(targetEntity="FrontOfficeBundle\Entity\Trip", mappedBy="thematic")
     */
    private $trip;


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
     * @return Thematic
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
     * Set main1
     *
     * @param string $main1
     *
     * @return Thematic
     */
    public function setMain1($main1)
    {
        $this->main1 = $main1;

        return $this;
    }

    /**
     * Get main1
     *
     * @return string
     */
    public function getMain1()
    {
        return $this->main1;
    }

    /**
     * Set main2
     *
     * @param string $main2
     *
     * @return Thematic
     */
    public function setMain2($main2)
    {
        $this->main2 = $main2;

        return $this;
    }

    /**
     * Get main2
     *
     * @return string
     */
    public function getMain2()
    {
        return $this->main2;
    }

    /**
     * Set underline
     *
     * @param string $underline
     *
     * @return Thematic
     */
    public function setUnderline($underline)
    {
        $this->underline = $underline;

        return $this;
    }

    /**
     * Get underline
     *
     * @return string
     */
    public function getUnderline()
    {
        return $this->underline;
    }
   

    /**
     * Set underline1
     *
     * @param string $underline1
     *
     * @return Thematic
     */
    public function setUnderline1($underline1)
    {
        $this->underline1 = $underline1;

        return $this;
    }

    /**
     * Get underline1
     *
     * @return string
     */
    public function getUnderline1()
    {
        return $this->underline1;
    }

    /**
     * Set underline2
     *
     * @param string $underline2
     *
     * @return Thematic
     */
    public function setUnderline2($underline2)
    {
        $this->underline2 = $underline2;

        return $this;
    }

    /**
     * Get underline2
     *
     * @return string
     */
    public function getUnderline2()
    {
        return $this->underline2;
    }

    /**
     * Add trip
     *
     * @param \FrontOfficeBundle\Entity\Trip $trip
     *
     * @return Thematic
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
     * Constructor
     */
    public function __construct()
    {
        $this->image = new \Doctrine\Common\Collections\ArrayCollection();
        $this->trip = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add image
     *
     * @param \FrontOfficeBundle\Entity\Image $image
     *
     * @return Thematic
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
     * Set active
     *
     * @param string $active
     *
     * @return Thematic
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
}
