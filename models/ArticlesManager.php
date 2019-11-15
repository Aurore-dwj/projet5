<?php
namespace OpenClass;
require 'vendor/autoload.php';

use OpenClass\{Manager, Pagination};
use Control\{ControllerAccueil, ControllerUser, ControllerAdmin};



class ArticlesManager extends Manager
{
	public function postArticle($title, $content) // insertion article à la db
	{
		$db = $this->dbConnect();
		$inserarticle = $db->prepare('INSERT INTO articles(title, content, creation_date) VALUES (?, ?, NOW())');
        $article = $inserarticle->execute(array($title, $content));
		
		return $article;

	}

	public function getArticlesAdmin($depart, $articlesparp) // méthode de récupération articles
	{
		
		$db = $this->dbConnect();

		$articles = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM articles ORDER BY creation_date DESC LIMIT 0, 50');
		
		
		return $articles;
	}

	public function postArticlesUser($title, $content) // insertion article user à la db
	{
		$db = $this->dbConnect();
		$inserarticle = $db->prepare('INSERT INTO articles(title, content, creation_date) VALUES (?, ?, NOW())');
        $article = $inserarticle->execute(array($title, $content));
		
		return $article;

	}

	public function getArticlesUser($depart, $articlesparp) // méthode de récupération articles user
	{
		
		$db = $this->dbConnect();
		$articles = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM articles ORDER BY creation_date DESC LIMIT 0, 50');
		
		return $articles;
	}

	public function getArticleAdmin($dataId) // méthode de récupération article à modifier
	{
		
		$db = $this->dbConnect();
    	$req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM articles WHERE id = ?');
		$req->execute(array($dataId));
	
    	return $req;
	}

	public function deletArticle($dataId) //supprime un chapitre et ses commentaires
	{ 
        $db = $this->dbConnect();
        //$comment = $db->prepare('DELETE FROM avis WHERE id_billet = ?');
        //$comment->execute([$dataId]);
        $req = $db->prepare('DELETE FROM articles WHERE id = ?');
        $req->execute(array($dataId));
       	return $req;
    }

    public function updateArticle($title, $content, $postId)
    {
    	$db = $this->dbConnect();
		$updArticle = $db->prepare('UPDATE articles SET title = ?, content = ? WHERE id = ?');
        $artOk = $updArticle->execute(array($title, $content, $postId));
		return $artOk;
    }




	
}