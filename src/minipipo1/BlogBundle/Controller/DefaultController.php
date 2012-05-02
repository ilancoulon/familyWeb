<?php

namespace minipipo1\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use minipipo1\BlogBundle\Entity\Article;

class DefaultController extends Controller {

        public function indexAction() {
                $em = $this->getDoctrine()->getEntityManager();
                $articles = $em->getRepository('minipipo1BlogBundle:Article')->findAll();
                return $this->render('minipipo1BlogBundle:Blog:index.html.twig', array('articles' => $articles));
        }
        
        public function viewAction($id) {
                $em = $this->getDoctrine()->getEntityManager();
                $article = $em->getRepository('minipipo1BlogBundle:Article')->find($id);
                
                if (!$article) {
                        throw $this->createNotFoundException('Impossible de trouver cet article.');
                }
                
                return $this->render('minipipo1BlogBundle:Blog:view.html.twig', array('article' => $article));
        }

}
