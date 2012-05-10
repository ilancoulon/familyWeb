<?php
namespace minipipo1\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="minipipo1_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="minipipo1\UserBundle\Entity\Membre", mappedBy="user")
     */
    private $membres;
    
    public function getMembres(){
            return $this->membres;
    }
    
    public function addMembre(\minipipo1\UserBundle\Entity\Membre $membre) {
            $this->membres[] = $membre;
            $membre->setUser($this);
    }
}
