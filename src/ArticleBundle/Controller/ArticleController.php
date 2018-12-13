<?php

namespace ArticleBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use ArticleBundle\Entity\Article;
use ArticleBundle\Form\ArticleType;

class ArticleController extends FOSRestController
{
    /**
     * Get All the articles
     * @return array
     * 
     * @View()
     * @Get("/articles")
     */

public function getArticlesAction() {

    $articles = $this->getDoctrine()->getRepository("ArticleBundle:Article")
    ->findAll();

    return array('articles' => $articles);
}
  

    /**
     * Get a article by ID
     * @param Article $article
     * @return array
     * 
     * @View()
     * @ParamConverter("article", class="ArticleBundle:Article")
     * @Get("/article/{id}")
     */

    public function getSingleArticleAction(Article $article){

        return array('article' => $article);
    
    }

    /**
     * Create a new Article
     * @var Request $request
     * @return View | array
     * 
     * @View()
     * @Post("/article")
     */

     public function postArticleAction(Request $request) {

        $article = new Article();
        $form = $this->createForm(new ArticleType(),$article);
        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return array("article" => $article);
        }

        return array(
            'form' => $form,
        );
     }

  /**
     * Editer une Article
     * Put action
     * @var Request $request
     * @var Article $article
     * @return array
     * 
     * @View()
     * @ParamConverter("article", class="ArticleBundle:Article")
     * @Put("/article/{id}")
     */  

public function putArticleAction(Request $request) {
    $article = new Article();
    $form = $this->createForm(new ArticleType(), $article);
    $form->submit($request);
    $form->handleRequest($request);

    if($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        return array("article" => $article);
    }

    return array(
        'form' => $form,
    );

}

    /** By Othmane Kais
     * Delete Article
     * Delete action
     * @var Article $article
     * @return array
     * 
     * @View()
     * @ParamConverter("article", class="ArticleBundle:Article")
     * @Delete("/article/{id}")
     */

     public function deleteArticleAction(Article $article) {

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return array("status" => "Deleted");
     }
    
}