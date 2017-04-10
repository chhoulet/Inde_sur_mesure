<?php

namespace FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Newsletter
 *
 * @ORM\Table(name="newsletter")
 * @ORM\Entity(repositoryClass="FrontOfficeBundle\Repository\NewsletterRepository")
 */
class Newsletter
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="undertitle", type="string", length=255)
     */
    private $undertitle;

    /**
     * @var text
     *
     * @ORM\Column(name="text1", type="text", length=4000)
     */
    private $text1;

    /**
     * @var text
     *
     * @ORM\Column(name="text2", type="text", length=4000, nullable=true)
     */
    private $text2;

    /**
     * @var text
     *
     * @ORM\Column(name="text3", type="text", length=4000, nullable=true)
     */
    private $text3;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSended", type="datetime", nullable=true)
     */
    private $dateSended;

    /**
    *
    * @ORM\OneToMany(targetEntity="FrontOfficeBundle\Entity\Image", mappedBy="newsletter", cascade={"remove"})
    *
    */
    private $image;


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
     * @param text $title
     *
     * @return Newsletter
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return text
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set undertitle
     *
     * @param text $undertitle
     *
     * @return Newsletter
     */
    public function setUndertitle($undertitle)
    {
        $this->undertitle = $undertitle;

        return $this;
    }

    /**
     * Get undertitle
     *
     * @return text
     */
    public function getUndertitle()
    {
        return $this->undertitle;
    }

    /**
     * Set text1
     *
     * @param text $text1
     *
     * @return Newsletter
     */
    public function setText1($text1)
    {
        $this->text1 = $text1;

        return $this;
    }

    /**
     * Get text1
     *
     * @return text
     */
    public function getText1()
    {
        return $this->text1;
    }

    /**
     * Set text2
     *
     * @param text $text2
     *
     * @return Newsletter
     */
    public function setText2($text2)
    {
        $this->text2 = $text2;

        return $this;
    }

    /**
     * Get text2
     *
     * @return text
     */
    public function getText2()
    {
        return $this->text2;
    }

    /**
     * Set text3
     *
     * @param text $text3
     *
     * @return Newsletter
     */
    public function setText3($text3)
    {
        $this->text3 = $text3;

        return $this;
    }

    /**
     * Get text3
     *
     * @return text
     */
    public function getText3()
    {
        return $this->text3;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Newsletter
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
     * Set dateSended
     *
     * @param \DateTime $dateSended
     *
     * @return Newsletter
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
     * Constructor
     */
    public function __construct()
    {
        $this->image = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add image
     *
     * @param \FrontOfficeBundle\Entity\Image $image
     *
     * @return Newsletter
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
}
