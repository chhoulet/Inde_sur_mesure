<?php

namespace FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="FrontOfficeBundle\Repository\ImageRepository")
 */
class Image
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
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="filename1", type="string", length=255, nullable=true)
     */
    private $filename1;

    /**
     * @var string
     *
     * @ORM\Column(name="filename2", type="string", length=255, nullable=true)
     */
    private $filename2;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="FrontOfficeBundle\Entity\Thematic", inversedBy="image")
     * @ORM\JoinColumn(name="thematic_id", referencedColumnName="id", nullable=true)
     */
    private $thematic;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="FrontOfficeBundle\Entity\Trip", inversedBy="image")
     * @ORM\JoinColumn(name="trip_id", referencedColumnName="id", nullable=true)    
     */
    private $trip;

     /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="FrontOfficeBundle\Entity\Newsletter", inversedBy="image")
     * @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id", nullable=true)    
     */
    private $newsletter;


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
     * Set filename
     *
     * @param string $filename
     *
     * @return Image
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set filename1
     *
     * @param string $filename1
     *
     * @return Image
     */
    public function setFilename1($filename1)
    {
        $this->filename1 = $filename1;

        return $this;
    }

    /**
     * Get filename1
     *
     * @return string
     */
    public function getFilename1()
    {
        return $this->filename1;
    }

    /**
     * Set filename2
     *
     * @param string $filename2
     *
     * @return Image
     */
    public function setFilename2($filename2)
    {
        $this->filename2 = $filename2;

        return $this;
    }

    /**
     * Get filename2
     *
     * @return string
     */
    public function getFilename2()
    {
        return $this->filename2;
    }

    /**
     * Set thematic
     *
     * @param \FrontOfficeBundle\Entity\Thematic $thematic
     *
     * @return Image
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
     * Set trip
     *
     * @param \FrontOfficeBundle\Entity\Trip $trip
     *
     * @return Image
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
     * Set newsletter
     *
     * @param \FrontOfficeBundle\Entity\Newsletter $newsletter
     *
     * @return Image
     */
    public function setNewsletter(\FrontOfficeBundle\Entity\Newsletter $newsletter = null)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return \FrontOfficeBundle\Entity\Newsletter
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }
}
