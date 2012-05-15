<?php

namespace minipipo1\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;

/**
 * minipipo1\BlogBundle\Entity\Article
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="minipipo1\BlogBundle\Entity\ArticleRepository")
 */
class Article
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
     * @var datetime $date
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @var string $titre
     *
     * @ORM\Column(name="titre", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $titre;

    /**
     * @var text $contenu
     *
     * @ORM\Column(name="contenu", type="text")
     * @Assert\NotBlank()
     */
    private $contenu;
    
    /**
     * @ORM\OneToMany(targetEntity="minipipo1\BlogBundle\Entity\Comment", mappedBy="article")
     */
    private $comments;
    
    /**
     * @var minipipo1\UserBundle\Entity\Membre $auteur
     * 
     * @ORM\ManyToOne(targetEntity="minipipo1\UserBundle\Entity\Membre")
     * @Assert\NotBlank()
     */
    private $auteur;
    
    /**
     * @var bool $del
     * 
     *  @ORM\Column(type="boolean")
     */
    private $del;
    
    public function __construct() {
            $this->date = new \Datetime();
            $this->del = false;
    }

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
     * Set date
     *
     * @param datetime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return datetime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set titre
     *
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param text $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    /**
     * Get contenu
     *
     * @return text 
     */
    public function getContenu()
    {
        return $this->contenu;
    }
    
    public function getComments() {
            return $this->comments;
    }
    public function addComment(\minipipo1\BlogBundle\Entity\Comment $comment) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
    }
    
    public function getAuteur() {
            return $this->auteur;
    }
    public function setAuteur(\minipipo1\UserBundle\Entity\Membre $auteur) {
            $this->auteur = $auteur;
    }
    
    public function getDel() {
            return $this->del;
    }
    public function setDel($del) {
            $this->del = $del;
    }
}