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

        public function indexAction() {
                $em = $this->getDoctrine()->getEntityManager();
                $articles = $em->getRepository('minipipo1BlogBundle:Article')->findAllDesc();
                return $this->render('minipipo1BlogBundle:Blog:index.html.twig', array('articles' => $articles));
        }
        
        public function viewAction(Article $article) {
                $comment = new Comment();
                $comment->setArticle($article);
                $form = $this->createForm(new CommentType($this->container->get('security.context')->getToken()->getUser()), $comment);
                
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
                                return $this->redirect( $this->generateUrl('minipipoblog_show', array('id' => $article->getId())) );
                        }
                }
                
                return $this->render('minipipo1BlogBundle:Blog:view.html.twig', array(
                        'article' => $article,
                        'form' => $form->createView(),
                ));
        }
        
        /**
         * @Secure(roles="ROLE_AUTEUR")
         */
        function listAction() {
                $em = $this->getDoctrine()->getEntityManager();
                $articles = $em->getRepository('minipipo1BlogBundle:Article')->listArticle($this->container->get('security.context'));
                return $this->render('minipipo1BlogBundle:Blog:list.html.twig', array('articles' => $articles));
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
