<?php

namespace minipipo1\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
        public function findAllDesc() {
                return $this->createQueryBuilder('a')
                                 ->where("a.del = false")
                                 ->orderBy("a.date", "DESC")
                                 ->getQuery();
        }
        
        public function listArticle(\Symfony\Component\Security\Core\SecurityContext $context) {
                $queryBuilder = $this->createQueryBuilder('a')
                        ->select('a')
                        ->where("a.del = false")
                        ->orderBy("a.date", "DESC");
                if (!$context->isGranted("ROLE_MODERATEUR")) {
                        $queryBuilder
                                ->join('a.auteur', 'm')
                                ->addSelect('m')
                                ->where("m.user = :user")
                                ->setParameter('user', $context->getToken()->getUser());
                }
                
                return $queryBuilder->getQuery();
        }
}