<?php

namespace minipipo1\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $date;

    /**
     * @var string $titre
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var text $contenu
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;
    
    /**
     * @ORM\OneToMany(targetEntity="minipipo1\BlogBundle\Entity\Comment", mappedBy="article")
     */
    private $comments;
    
    /**
     * @ORM\ManyToOne(targetEntity="minipipo1\UserBundle\Entity\Membre")
     */
    private $auteur;
    
    public function __construct() {
            $this->date = new \Datetime();
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
}