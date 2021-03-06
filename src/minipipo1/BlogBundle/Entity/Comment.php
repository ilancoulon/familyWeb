<?php

namespace minipipo1\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * minipipo1\BlogBundle\Entity\Comment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="minipipo1\BlogBundle\Entity\CommentRepository")
 */
class Comment
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
     * @var text $content
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @var datetime $date
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;
    
    /**
     * @ORM\ManyToOne(targetEntity="minipipo1\BlogBundle\Entity\Article", inversedBy="comments")
     * @Assert\NotBlank()
     */
    private $article;
    
    /**
     * @ORM\ManyToOne(targetEntity="minipipo1\UserBundle\Entity\Membre")
     * @Assert\NotBlank()
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
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text 
     */
    public function getContent()
    {
        return $this->content;
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
    
    public function getArticle () {
            return $this->article;
    }
    
    public function setArticle (\minipipo1\BlogBundle\Entity\Article $article) {
            $this->article = $article;
    }
    
    public function getAuteur() {
            return $this->auteur;
    }
    
    public function setAuteur(\minipipo1\UserBundle\Entity\Membre $auteur) {
            $this->auteur = $auteur;
    }
}