<?php

namespace FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DateTrip
 *
 * @ORM\Table(name="date_trip")
 * @ORM\Entity(repositoryClass="FrontOfficeBundle\Repository\DateTripRepository")
 */
class DateTrip
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
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="month", type="string", length=255, nullable=true)
     */
    private $month;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateBegining", type="date", nullable=true)
     * @Assert\DateTime()
     */
    private $dateBegining;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deteEnding", type="date", nullable=true)
     * @Assert\DateTime()
     */
    private $deteEnding;

    /**
     * @var int
     *
     * @ORM\Column(name="daysNumber", type="smallint", nullable=true)
     */
    private $daysNumber;

    /**
     * @var text
     *
     * @ORM\Column(name="comment", type="text", length=2500, nullable=true)
     * @Assert\Length(
     *      min = 10,
     *      max = 2500,
     *      minMessage = "Votre texte ne peut faire moins de {{ limit }} caractères",
     *      maxMessage = "Votre texte ne peut faire plus de {{ limit }} caractères"
     * )
     */
    private $comment;


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
     * Set year
     *
     * @param integer $year
     *
     * @return DateTrip
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set month
     *
     * @param string $month
     *
     * @return DateTrip
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set dateBegining
     *
     * @param \DateTime $dateBegining
     *
     * @return DateTrip
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
     * Set deteEnding
     *
     * @param \DateTime $deteEnding
     *
     * @return DateTrip
     */
    public function setDeteEnding($deteEnding)
    {
        $this->deteEnding = $deteEnding;

        return $this;
    }

    /**
     * Get deteEnding
     *
     * @return \DateTime
     */
    public function getDeteEnding()
    {
        return $this->deteEnding;
    }

    /**
     * Set daysNumber
     *
     * @param integer $daysNumber
     *
     * @return DateTrip
     */
    public function setDaysNumber($daysNumber)
    {
        $this->daysNumber = $daysNumber;

        return $this;
    }

    /**
     * Get daysNumber
     *
     * @return int
     */
    public function getDaysNumber()
    {
        return $this->daysNumber;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return DateTrip
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
}

