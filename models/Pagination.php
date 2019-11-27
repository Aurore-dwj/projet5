<?php
namespace OpenClass;
require 'vendor/autoload.php';

use OpenClass\{ArticlesManager, CommentsManager, Manager, MembersManager};
use Control\{ControllerAccueil, ControllerUser, ControllerAdmin};

class Pagination extends Manager
{ 
    public function getArticlesPagination() { // comptage total du nombre de lignes dans la bdd avec la fonction d'agrégation mySql COUNT
        $db = $this->dbConnect();
        $totalarticles = $db->query('SELECT COUNT(*) AS nombredarticles FROM articles');
   
        return $totalarticles->fetch()['nombredarticles'];

    }

    public function getArticlesParRubriq()// comptage lignes articles par rubrique
    {
        $db = $this->dbConnect();
        $totalarticles = $db->query('SELECT id_rubrique, COUNT(id_rubrique) AS nb_artic FROM articles GROUP BY id_rubrique');
   
        return $totalarticles->fetch()['nb_artic'];

    }

    public function getArticlesPages($nombredarticles, $articlesparp) { // nb d'article divisé par le nb d'articles par page, arrondi à la virgule supérieur par la fonction PHP ceil
        $totalpages = ceil($nombredarticles/$articlesparp);
        return $totalpages;
    }
}
