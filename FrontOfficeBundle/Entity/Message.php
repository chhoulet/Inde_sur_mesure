<?php

namespace FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="FrontOfficeBundle\Repository\MessageRepository")
 */
class Message
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
     * @ORM\Column(name="author", type="string", length=60)
     * @Assert\Length(
     *      min = 2,
     *      max = 60,
     *      minMessage = "Votre nom ne peut pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Votre nom ne peut pas faire plus de  {{ limit }} caractères"
     * )
     * @Assert\NotBlank()
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150)
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=555)
     * @Assert\NotBlank()   
     */
    private $subject;

    /**
     * @var text
     *
     * @ORM\Column(name="main", type="text", length=6550)
     * @Assert\Length(
     *      min = 20,
     *      max = 6550,
     *      minMessage = "Le texte ne peut pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Le texte ne peut pas faire plus de {{ limit }} caractères."
     * )
     * @Assert\NotBlank()
     */
    private $main;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSended", type="datetime")
     */
    private $dateSended;

    /**
     * @var int
     *
     * @ORM\Column(name="origin", type="integer")
     */
    private $origin;

    /**
     * @var bool
     *
     * @ORM\Column(name="answered", type="boolean")
     */
    private $answered=0;

    


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
     * Set author
     *
     * @param string $author
     *
     * @return Message
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Message
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Message
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set main
     *
     * @param string $main
     *
     * @return Message
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
     * Set dateSended
     *
     * @param \DateTime $dateSended
     *
     * @return Message
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
     * Set origin
     *
     * @param integer $origin
     *
     * @return Message
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
     * Set answered
     *
     * @param boolean $answered
     *
     * @return Message
     */
    public function setAnswered($answered)
    {
        $this->answered = $answered;

        return $this;
    }

    /**
     * Get answered
     *
     * @return boolean
     */
    public function getAnswered()
    {
        return $this->answered;
    }
}
