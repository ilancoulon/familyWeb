<?php

namespace minipipo1\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use minipipo1\BlogBundle\Entity\Article;
use minipipo1\BlogBundle\Form\ArticleType;

class DefaultController extends Controller {

        public function indexAction() {
                $em = $this->getDoctrine()->getEntityManager();
                $articles = $em->getRepository('minipipo1BlogBundle:Article')->findAllDesc();
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
        
        public function newAction() {
                $article = new Article();
                $form = $this->createForm(new ArticleType(), $article);

                $request = $this->get('request');
                if( $request->getMethod() == 'POST' )
                {
                        $form->bindRequest($request);
                        if( $form->isValid() )
                        {
                                $em = $this->getDoctrine()->getEntityManager();
                                $em->persist($article);
                                $em->flush();

                                $this->get('session')->setFlash('new_article',"L'article a bien été publié.");
                                return $this->redirect( $this->generateUrl('minipipoblog_new') );
                        }
                }
                
                return $this->render('minipipo1BlogBundle:Blog:new.html.twig', array(
                        'entity' => $article,
                        'form'   => $form->createView()
                ));
        }
        
        public function editAction($id) {
                $em = $this->getDoctrine()->getEntityManager();

                $entity = $em->getRepository('minipipo1BlogBundle:Article')->find($id);

                if (!$entity) {
                        throw $this->createNotFoundException('Article introuvable.');
                }

                $editForm = $this->createForm(new ArticleType(), $entity);

                return $this->render('minipipo1BlogBundle:Article:edit.html.twig', array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                ));
        }

}
