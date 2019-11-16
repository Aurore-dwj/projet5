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

	public function supprimerArticle($dataId)
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
	
	require('views/backend/signalArticle.php');
}

	public function modifierArticle($title, $content, $postId)
	{
		$modifie = new ArticlesManager();
		$updatearticle = $modifie->updateArticle($title, $content, $postId);
		header('Location: index.php?action=listArticlesAdmin');
	}

	public function designal($articId) //fonction modification commentaires signalés
	{ 	
	$articleManager = new ArticleManager();
	$designale = $articleManager->getArticlesSignal($articId);

	if($designale === false) {
		die('<p style= "border: 1px solid red; text-align: center; font-size: 55px; margin: 90px 90px 90px;">Oups... Impossible de designaler le commentaire!</p>');
	}else{ 
		header('Location: index.php?action=signalArticle&signalement=1');
	}
	
	require('views/backend/signalArticle.php');
}






}