<?php
namespace Control;
require 'vendor/autoload.php';


use OpenClass\{ArticlesManager, CommentsManager, Manager, MembersManager, Pagination};
use Control\{ControllerAccueil, ControllerUser};

class ControllerAdmin
{
	public function redacArticles($idUser, $title, $content)
	{
		$articleEdit = new ArticlesManager();//création objet ArticlesManager
		$createarticle = $articleEdit->postArticle($idUser, $title, $content);//retour modèle fonction postChapitre
	
	if($createarticle === false) {
		die('<p style= "border: 1px solid red; text-align: center; font-size: 55px; margin: 90px 90px 90px;">Impossible d \'ajouter un article...');//condition si false on arrête le script
	}else{//si true chargement de la page qui affichera la liste des chapitres
		header('Location: index.php?action=listArticlesAdmin');
		}
	}

	public function adminViewConnect() //connexion gestion admin 
	{
	require('views/backend/redacArticleAdmin.php');
	}

	public function listArticlesAdmin() // liste articles admin
	{
		$articlesManager = new ArticlesManager();
		$pagination = new Pagination();
		$articlesparp = 4;
		$nombredarticles = $pagination->getArticlesPagination();
		$totalpages = $pagination->getArticlesPages($nombredarticles, $articlesparp);
		//die(var_dump($totalpages));
		if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $totalpages) {
   			$_GET['page'] = intval($_GET['page']);
   			$pageCourante = $_GET['page'];
			} else {
   			$pageCourante = 1;
			}
			$depart = ($pageCourante-1)*$articlesparp;
			$artic = $articlesManager->getArticlesAdmin($depart, $articlesparp);
			require('views/backend/listArticlesHistoireAdmin.php');
			//die(var_dump($artic));
	}

	public function articAdmin()// get article à modifier
	{
		$articleManager = new ArticlesManager();
		$artic = $articleManager->getArticleAdmin($_GET['id']);
	
		require('views/backend/modifierArticleAdmin.php');
	}

	public function supprimerArticle($dataId)// supprimme l'article
	{
		$supprime = new ArticlesManager();
		$deletedarticle = $supprime->deletArticle($dataId);

		if($deletedarticle === false) {
		die('<p style= "border: 1px solid red; text-align: center; font-size: 55px; margin: 90px 90px 90px;"> Impossible de supprimer un article...</p>');
		}else{
		header('Location: index.php?action=listArticlesAdmin');
		}
	}


	public function getArticlesAdmin() //fonction récupère les articles signalés
	{ 	
	$articleManager = new ArticlesManager();
	$artic = $articleManager->getArticlesSignal($_GET['signalement']);
	//die(var_dump($artic));
	require('views/backend/signalArticle.php');
	}

	public function modifierArticle($title, $content, $postId)
	{
		$modifie = new ArticlesManager();
		$updatearticle = $modifie->updateArticle($title, $content, $postId);
		header('Location: index.php?action=listArticlesAdmin');
	}

	public function designalArticle($articId) //fonction modification commentaires signalés
	{ 	
	$articleManager = new ArticlesManager();
	$designale = $articleManager->deSignal($articId);

	if($designale === false) {
		die('<p style= "border: 1px solid red; text-align: center; font-size: 55px; margin: 90px 90px 90px;">Oups... Impossible de designaler le commentaire!</p>');
	}else{ 
		header('Location: index.php?action=getArticlesAdmin&signalement=1');
	}
	
	require('views/backend/signalArticle.php');
	}

	public function getCommentAdmin() //fonction récupère les commentaires signalés
	{ 	
	$commentsManager = new CommentsManager();
	$comments = $commentsManager->getCommentSignal($_GET['signalement']);
	 //die(var_dump($comments));
	require('views/backend/signalComment.php');
	}

	public function designalCommentaire($commentId) //fonction modification commentaires signalés
	{ 	
	$commentsManager = new CommentsManager();
	$designale = $commentsManager->deSignal($commentId);

	if($designale === false) {
		die('<p style= "border: 1px solid red; text-align: center; font-size: 55px; margin: 90px 90px 90px;">Oups... Impossible de designaler le commentaire!</p>');
	}else{ 
		header('Location: index.php?action=getCommentAdmin&signalement=1');
	}
	
	require('views/backend/signalComment.php');
	}

	public function supprimerCommentaire($commentId)// supprimme l'article
	{
		$supprime = new CommentsManager();
		$deletedComment = $supprime->deleteComment($commentId);

		if($deletedComment === false) {
		die('<p style= "border: 1px solid red; text-align: center; font-size: 55px; margin: 90px 90px 90px;"> Impossible de supprimer un article...</p>');
		}else{
		header('Location: index.php?action=listArticlesAdmin');
		}
	}






}