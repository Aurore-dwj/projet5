<?php
namespace Control;
require 'vendor/autoload.php';


use OpenClass\{ArticlesManager, CommentsManager, Manager, MembersManager, Pagination};
use Control\{ControllerAccueil, ControllerUser};

class ControllerAdmin
{
	public function redacArticles($title, $content)
	{
		$articleEdit = new ArticlesManager();//création objet ArticlesManager
		$createarticle = $articleEdit->postArticle($title, $content);//retour modèle fonction postChapitre
	
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
		//die(var_dump($nombredarticles));
		if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $totalpages) {
   			$_GET['page'] = intval($_GET['page']);
   			$pageCourante = $_GET['page'];
			} else {
   			$pageCourante = 1;
			}
			$depart = ($pageCourante-1)*$articlesparp;

		









		/*if (!isset($_GET['page'])) {
			$pageCourante = 1;
		} else {
			if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $totalPages) {
				$pageCourante = (intval($_GET['page']) - 1) * $articlesparp;
				}
			}*/
			
			$artic = $articlesManager->getArticlesAdmin($depart, $articlesparp);
			//die(var_dump($artic));

			require('views/backend/listArticlesHistoireAdmin.php');
		}






}