<?php
namespace OpenClass;
require 'vendor/autoload.php';


use OpenClass\{ArticlesManager, CommentsManager, Manager, MembersManager};
use Control\{ControllerAccueil, ControllerUser, ControllerAdmin};

class Pagination extends Manager
{ 
	public function getArticlesPagination() { // comptage total du nombre d'articles dans la bdd
        $db = $this->dbConnect();
        $totalarticles = $db->query('SELECT COUNT(id) AS nombredarticles FROM articles');
   
        return $totalarticles->fetch()['nombredarticles'];

    }
    public function getArticlesPages($nombredarticles, $articlesparp) { // nb d'article divisé par le nb d'articles par page, arrondi par la fonction PHP ceil
        $totalpages = ceil($nombredarticles/$articlesparp);
        return $totalpages;
    }
}