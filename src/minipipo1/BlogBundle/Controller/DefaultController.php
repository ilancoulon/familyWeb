<?php

namespace minipipo1\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use minipipo1\BlogBundle\Entity\Article;
use minipipo1\BlogBundle\Form\ArticleType;
use minipipo1\BlogBundle\Entity\Comment;
use minipipo1\BlogBundle\Form\CommentType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DefaultController extends Controller {

        public function indexAction($page) {
                $em = $this->getDoctrine()->getEntityManager();
                $articles = $em->getRepository('minipipo1BlogBundle:Article')->findAllDesc();
                
                // Pagination
                $paginator = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                        $articles,
                        $page
                );
                
                $pagination_data = $pagination->getPaginationData();
                //if ($page >$pagination_data["pageCount"])
                         //throw $this->createNotFoundException('Page inexistante.');
                
                return $this->render('minipipo1BlogBundle:Blog:index.html.twig', array('pagination' => $pagination));
        }
        
        public function viewAction($id, $page) {
                if((!$article = $this->getDoctrine()->getEntityManager()->getRepository('minipipo1BlogBundle:Article')->find($id)))
                        throw $this->createNotFoundException("Cet article n'existe pas.");
                if ($article->getDel())
                        throw $this->createNotFoundException ("Cet article a été supprimé.");

                $comment = new Comment();
                $comment->setArticle($article);
                $form = $this->createForm(new CommentType($this->container->get('security.context')->getToken()->getUser()), $comment);
                
                $request = $this->get('request');
                if( $request->getMethod() == 'POST' )
                {
                        if (!$this->get('security.context')->isGranted('ROLE_AUTEUR'))
                                throw new AccessDeniedHttpException('Vous n\'avez pas les droits requis pour écrire un commentaire.');
                        $form->bindRequest($request);
                        if( $form->isValid() )
                        {
                                $em = $this->getDoctrine()->getEntityManager();
                                $em->persist($comment);
                                $em->flush();

                                $this->get('session')->setFlash('new_com',"Le commentaire a bien été publié.");
                                return $this->redirect( $this->generateUrl('minipipoblog_show', array('id' => $article->getId())) );
                        }
                }
                
                $coms = $this->getDoctrine()->getEntityManager()->getRepository('minipipo1BlogBundle:Comment')->findAllDesc($article);
                // Pagination
                $paginator = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                        $coms,
                        $page
                );
                
                $pagination_data = $pagination->getPaginationData();
                if ($page >$pagination_data["pageCount"] && $pagination_data["pageCount"] > 0)
                         throw $this->createNotFoundException('Page inexistante.');
                
                return $this->render('minipipo1BlogBundle:Blog:view.html.twig', array(
                        'article' => $article,
                        'pagination'    => $pagination,
                        'form' => $form->createView(),
                ));
        }
        
        /**
         * @Secure(roles="ROLE_AUTEUR")
         */
        function listAction($page) {
                $em = $this->getDoctrine()->getEntityManager();
                $articles = $em->getRepository('minipipo1BlogBundle:Article')->listArticle($this->container->get('security.context'));
                
                // Pagination
                $paginator = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                        $articles,
                        $page,
                        50
                );
                
                $pagination_data = $pagination->getPaginationData();
                if ($page >$pagination_data["pageCount"])
                         throw $this->createNotFoundException('Page inexistante.');
                
                return $this->render('minipipo1BlogBundle:Blog:list.html.twig', array('pagination' => $pagination));
        }
        
        /**
         * @Secure(roles="ROLE_AUTEUR")
         */
        public function newAction($id) {
                $em = $this->getDoctrine()->getEntityManager();
                
                if (!$id) {
                        $article = new Article();
                }
                else {
                        $article = $em->getRepository('minipipo1BlogBundle:Article')->find($id);
                        if (!$article)
                                throw $this->createNotFoundException('Article introuvable.');
                        if (!($this->get('security.context')->isGranted('ROLE_MODERATEUR') || $article->getAuteur()->getUser() == $this->container->get('security.context')->getToken()->getUser())) {
                                throw new AccessDeniedHttpException('Vous n\'avez pas le droit d\'éditer cet article.');
                        }
                }
                
                $form = $this->createForm(new ArticleType($this->container->get('security.context')->getToken()->getUser()), $article);

                $request = $this->get('request');
                if( $request->getMethod() == 'POST' )
                {
                        $form->bindRequest($request);
                        if( $form->isValid() )
                        {
                                $em->flush();

                                $this->get('session')->setFlash('new_article',"L'article a bien été publié.");
                                return $this->redirect( $this->generateUrl('minipipoblog_index') );
                        }
                }
                
                return $this->render('minipipo1BlogBundle:Blog:new.html.twig', array(
                        'article' => $article,
                        'form'   => $form->createView()
                ));
        }
        
        /**
         * @Secure(roles="ROLE_AUTEUR")
         */
        public function delAction(Article $article) {
                if (!($this->get('security.context')->isGranted('ROLE_MODERATEUR') || $article->getAuteur()->getUser() == $this->container->get('security.context')->getToken()->getUser())) {
                        throw new AccessDeniedHttpException('Vous n\'avez pas le droit de supprimer cet article.');
                }
                
                $em = $this->getDoctrine()->getEntityManager();
                
                $article->setDel(true);
                
                $em->flush();
                
                $this->get('session')->setFlash('de_article',"L'article a bien été supprimé.");
                return $this->redirect( $this->generateUrl('minipipoblog_redac') );
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
