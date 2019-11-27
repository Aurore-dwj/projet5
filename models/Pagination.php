<?php
namespace OpenClass;
require 'vendor/autoload.php';


use OpenClass\{ArticlesManager, CommentsManager, Manager, MembersManager};
use Control\{ControllerAccueil, ControllerUser, ControllerAdmin};

class Pagination extends Manager
{ 
	public function getArticlesPagination() { // comptage total du nombre d'articles dans la bdd avec la fonction PHP COUNT
        $db = $this->dbConnect();
        $totalarticles = $db->query('SELECT COUNT(*) AS nombredarticles FROM articles');
   
        return $totalarticles->fetch()['nombredarticles'];

    }

    public function getArticlesParRubriq()// comptage des articles par rubrique
    {
    	$db = $this->dbConnect();
        $totalarticles = $db->query('SELECT id_rubrique, COUNT(*) AS nb_artic FROM articles GROUP BY id_rubrique');
   
        return $totalarticles->fetch()['nb_artic'];

    }

    public function getArticlesPages($nombredarticles, $articlesparp) { // nb d'article divisé par le nb d'articles par page, arrondi à la virgule supérieur par la fonction PHP ceil
        $totalpages = ceil($nombredarticles/$articlesparp);
        return $totalpages;
    }
}