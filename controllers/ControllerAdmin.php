<?php
namespace Control;
require 'vendor/autoload.php';

use OpenClass\{ArticlesManager, CommentsManager, Manager, MembersManager, Pagination};
use Control\{ControllerAccueil, ControllerUser};

class ControllerAdmin
{
    public function redacArticles($idRubrique, $idUser, $title, $content) // rédaction article Admin
    
    {
        $articleEdit = new ArticlesManager(); //création objet ArticlesManager
        $createarticle = $articleEdit->postArticle($idRubrique, $idUser, $title, $content); //appel de la fonction
        if ($createarticle === false)
        {
            throw new \Exception('Impossible d \'ajouter un article...');
        }
        else
        {
            header('Location: index.php?action=listArticlesAdmin');
        }
    }

    public function adminViewConnect() //accès dashboard admin
    
    {
        require ('views/backend/redacArticleAdmin.php');
    }

    public function listArticlesAdmin() // liste articles admin + pagination
    
    {

        $pagination = new Pagination();// nouvel objet de la class Pagination
        $articlesparp = 3;// nombre d'articles par page
        $nombredarticles = $pagination->getArticlesPagination(); //appel fonction pour récupérer le nombres d'articles à paginer
        $totalpages = $pagination->getArticlesPages($nombredarticles, $articlesparp);// appel fonction pour récupérer le nombre de pages

        //tests url + si utilisateur injecte autre chose qu'un chiffre ou veux mette un chiffre plus grand que le nombre de pages, on retourne à la page courante cad la page 1
        if (isset($_GET['page']) and !empty($_GET['page']) and $_GET['page'] > 0 and $_GET['page'] <= $totalpages)
        {
            $_GET['page'] = intval($_GET['page']);
            $pageCourante = $_GET['page'];
        }
        else
        {
            $pageCourante = 1;
        }
        $depart = ($pageCourante - 1) * $articlesparp;

        $articlesManager = new ArticlesManager();// nouvel objet de la class ArticlesManager
        $artic = $articlesManager->getArticlesAdmin($depart, $articlesparp);//appel fonction pour récupérer données articles

        require ('views/backend/listArticlesAdmin.php');
    }

    public function articAdmin() // get article à modifier
    
    {
        $articleManager = new ArticlesManager();
        $artic = $articleManager->getArticleAdmin($_GET['id']);

        require ('views/backend/modifierArticleAdmin.php');
    }

    public function supprimerArticle($dataId) // supprimme l'article
    
    {
        $supprime = new ArticlesManager();
        $deletedarticle = $supprime->deletArticle($dataId);

        if ($deletedarticle === false)
        {
            throw new \Exception('Impossible de supprimer cet article!');
        }
        else
        {
            header('Location: index.php?action=listArticlesAdmin');
        }
    }

    public function getArticlesAdmin() //fonction récupère les articles signalés
    
    {
        $articleManager = new ArticlesManager();
        $artic = $articleManager->getArticlesSignal($_GET['signalement']);

        require ('views/backend/signalArticle.php');
    }
    public function modifierArticle($title, $content, $postId) // modifie article
    
    {
        $modifie = new ArticlesManager();
        $updatearticle = $modifie->updateArticle($title, $content, $postId);
        header('Location: index.php?action=listArticlesAdmin');
    }

    public function designalArticle($articId) //désignale article signalés
    
    {
        $articleManager = new ArticlesManager();
        $designale = $articleManager->deSignal($articId);

        if ($designale === false)
        {
            throw new \Exception('Impossible de designaler cet article!');
        }
        else
        {
            header('Location: index.php?action=getArticlesAdmin&signalement=1');
        }
        require ('views/backend/signalArticle.php');
    }

    public function getCommentAdmin() //fonction récupère les commentaires signalés
    
    {
        $commentsManager = new CommentsManager();
        $comments = $commentsManager->getCommentSignal($_GET['signalement']);

        require ('views/backend/signalComment.php');
    }
    public function designalCommentaire($commentId) //fonction modification commentaires signalés
    
    {
        $commentsManager = new CommentsManager();
        $designale = $commentsManager->deSignal($commentId);

        if ($designale === false)
        {
            throw new \Exception('Oups... Impossible de designaler le commentaire!');
        }
        else
        {
            header('Location: index.php?action=getCommentAdmin&signalement=1');
        }

        require ('views/backend/signalComment.php');
    }

    public function supprimerCommentaire($commentId) // supprimme l'article
    
    {
        $supprime = new CommentsManager();
        $deletedComment = $supprime->deleteComment($commentId);

        if ($deletedComment === false)
        {
            throw new \Exception('Impossible de supprimer ce commentaire !');
        }
        else
        {
            header('Location: index.php?action=listArticlesAdmin');
        }
    }
}

