<?php

namespace minipipo1\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * minipipo1\UserBundle\Entity\Membre
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="minipipo1\UserBundle\Entity\MembreRepository")
 */
class Membre
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string $mail
     *
     * @ORM\Column(name="mail", type="string", length=255)
     * @Assert\Email()
     */
    private $mail;

    /**
     * @var date $birth_date
     *
     * @ORM\Column(name="birth_date", type="date")
     * @Assert\Date()
     */
    private $birth_date;
    
    /**
     * @ORM\ManyToOne(targetEntity="minipipo1\UserBundle\Entity\User", inversedBy="membres")
     */
    private $user;
    
    /**
     * @var bool $wantEmail 
     * 
     * @ORM\Column(name="wantEmail", type="boolean")
     */
    private $wantEmail;


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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Set mail
     *
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
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
     * Set birth_date
     *
     * @param date $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birth_date = $birthDate;
    }

    /**
     * Get birth_date
     *
     * @return date 
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }
    
    public function getUser(){
            return $this->user;
    }
    
    public function setUser(\minipipo1\UserBundle\Entity\User $user) {
            $this->user = $user;
    }
    
    public function __toString() {
            return $this->name;
    }
    
    public function getWantEmail() {
            return $this->wantEmail;
    }
    public function setWantEmail($wantEmail) {
            $this->wantEmail = $wantEmail;
    }
}