<?php
namespace Control;
require 'vendor/autoload.php';


use OpenClass\{ArticlesManager, CommentsManager, Manager, MembersManager};

class ControllerAdmin
{
	public function redacArticles($title, $content)
	{
		$articleEdit = new ArticlesManager();//création objet ArticlesManager
		$createarticle = $articleEdit->postArticle($title, $content);//retour modèle fonction postChapitre
	
	if($createarticle=== false) {
		die('<p style= "border: 1px solid red; text-align: center; font-size: 55px; margin: 90px 90px 90px;">Impossible d \'ajouter un article...');//condition si false on arrête le script
	}else{//si true chargement de la page qui affichera la liste des chapitres
		header('Location: index.php?action=listArticlesAdmin');
		}
	}

	public function adminViewConnect() //connexion gestion Admin 
	{
	require('views/backend/redacArticleAdmin.php');
	}






}