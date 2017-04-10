<?php

namespace FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="FrontOfficeBundle\Repository\ArticleRepository")
 */
class Article
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
     * @var int
     *
     * @ORM\Column(name="origin", type="integer")     
     */
    private $origin;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=250, nullable=true)
     * @Assert\Length(
     *      min = 10,
     *      max = 250,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut faire plus de {{ limit }} caractères"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="underTitle", type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 10,
     *      max = 255,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut faire plus de {{ limit }} caractères"
     * )
     */
    private $underTitle;

    /**
     * @var text
     *
     * @ORM\Column(name="text1", type="text", length=9550)
     * @Assert\Length(
     *      min = 20,
     *      max = 9550,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut faire plus de {{ limit }} caractères"
     * )
     */
    private $text1;

    /**
     * @var text
     *
     * @ORM\Column(name="text2", type="text", length=9550, nullable=true)
     * @Assert\Length(
     *      min = 20,
     *      max = 9550,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut faire plus de{{ limit }} caractères"
     * )
     */
    private $text2;

    /**
     * @var text
     *
     * @ORM\Column(name="text3", type="text", length=9550, nullable=true)
     * @Assert\Length(
     *      min = 20,
     *      max = 9550,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut faire plus de {{ limit }} caractères"
     * )
     */
    private $text3;

    /**
     * @var text
     *
     * @ORM\Column(name="text4", type="text", length=9550, nullable=true)
     * @Assert\Length(
     *      min = 20,
     *      max = 9550,
     *      minMessage = "Votre texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut faire plus de {{ limit }} caractères"
     * )
     */
    private $text4;

    /**
    *
    * @ORM\ManyToOne(targetEntity="FrontOfficeBundle\Entity\Trip", inversedBy="article")
    * @ORM\JoinColumn(name="trip_id", referencedColumnName="id", nullable=true)
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
     * Set title
     *
     * @param string $title
     *
     * @return Article
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
     * Set underTitle
     *
     * @param string $underTitle
     *
     * @return Article
     */
    public function setUnderTitle($underTitle)
    {
        $this->underTitle = $underTitle;

        return $this;
    }

    /**
     * Get underTitle
     *
     * @return string
     */
    public function getUnderTitle()
    {
        return $this->underTitle;
    }

    /**
     * Set text1
     *
     * @param string $text1
     *
     * @return Article
     */
    public function setText1($text1)
    {
        $this->text1 = $text1;

        return $this;
    }

    /**
     * Get text1
     *
     * @return string
     */
    public function getText1()
    {
        return $this->text1;
    }

    /**
     * Set text2
     *
     * @param string $text2
     *
     * @return Article
     */
    public function setText2($text2)
    {
        $this->text2 = $text2;

        return $this;
    }

    /**
     * Get text2
     *
     * @return string
     */
    public function getText2()
    {
        return $this->text2;
    }

    /**
     * Set text3
     *
     * @param string $text3
     *
     * @return Article
     */
    public function setText3($text3)
    {
        $this->text3 = $text3;

        return $this;
    }

    /**
     * Get text3
     *
     * @return string
     */
    public function getText3()
    {
        return $this->text3;
    }

    /**
     * Set text4
     *
     * @param string $text4
     *
     * @return Article
     */
    public function setText4($text4)
    {
        $this->text4 = $text4;

        return $this;
    }

    /**
     * Get text4
     *
     * @return string
     */
    public function getText4()
    {
        return $this->text4;
    }

    /**
     * Set origin
     *
     * @param integer $origin
     *
     * @return Article
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
     * Set trip
     *
     * @param \FrontOfficeBundle\Entity\Trip $trip
     *
     * @return Article
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
}
