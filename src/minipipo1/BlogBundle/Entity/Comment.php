<?php

namespace minipipo1\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $content;

    /**
     * @var datetime $date
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="minipipo1\BlogBundle\Entity\Article", inversedBy="comments")
     */
    private $article;


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
}