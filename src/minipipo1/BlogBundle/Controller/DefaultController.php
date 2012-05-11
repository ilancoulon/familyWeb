<?php

namespace minipipo1\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use minipipo1\BlogBundle\Entity\Article;
use minipipo1\BlogBundle\Form\ArticleType;
use minipipo1\BlogBundle\Entity\Comment;
use minipipo1\BlogBundle\Form\CommentType;
use JMS\SecurityExtraBundle\Annotation\Secure;

class DefaultController extends Controller {

        public function indexAction() {
                $em = $this->getDoctrine()->getEntityManager();
                $articles = $em->getRepository('minipipo1BlogBundle:Article')->findAllDesc();
                return $this->render('minipipo1BlogBundle:Blog:index.html.twig', array('articles' => $articles));
        }
        
        public function viewAction($id) {
                $em = $this->getDoctrine()->getEntityManager();
                $article = $em->getRepository('minipipo1BlogBundle:Article')->find($id);
                
                $comment = new Comment();
                $comment->setArticle($article);
                $form = $this->createForm(new CommentType(), $comment);
                
                $request = $this->get('request');
                if( $request->getMethod() == 'POST' )
                {
                        $form->bindRequest($request);
                        if( $form->isValid() )
                        {
                                $em = $this->getDoctrine()->getEntityManager();
                                $em->persist($comment);
                                $em->flush();

                                $this->get('session')->setFlash('new_com',"Le commentaire a bien été publié.");
                                return $this->redirect( $this->generateUrl('minipipoblog_show', array('id' => $id)) );
                        }
                }
                
                if (!$article) {
                        throw $this->createNotFoundException('Impossible de trouver cet article.');
                }
                
                return $this->render('minipipo1BlogBundle:Blog:view.html.twig', array(
                        'article' => $article,
                        'form' => $form->createView(),
                ));
        }
        
        function listAction() {
                $em = $this->getDoctrine()->getEntityManager();
                $articles = $em->getRepository('minipipo1BlogBundle:Article')->findAllDesc();
                return $this->render('minipipo1BlogBundle:Blog:list.html.twig', array('articles' => $articles));
        }
        
        /**
         * @Secure(roles="ROLE_AUTEUR")
         */
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
                                return $this->redirect( $this->generateUrl('minipipoblog_index') );
                        }
                }
                
                return $this->render('minipipo1BlogBundle:Blog:new.html.twig', array(
                        'entity' => $article,
                        'form'   => $form->createView()
                ));
        }
        
        /**
         * @Secure(roles="ROLE_AUTEUR")
         */
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
        
        /**
         * @Secure(roles="ROLE_AUTEUR")
         */
        public function newComAction () {
                $comment = new Comment();
                $form = $this->createForm(new CommentType(), $comment);
                
                $request = $this->get('request');
                if( $request->getMethod() == 'POST' )
                {
                        $form->bindRequest($request);
                        if( $form->isValid() )
                        {
                                $em = $this->getDoctrine()->getEntityManager();
                                $em->persist($comment);
                                $em->flush();

                                $this->get('session')->setFlash('new_com',"Le commentaire a bien été publié.");
                                return $this->redirect( $this->generateUrl('minipipoblog_index') );
                        }
                }
        }

}
