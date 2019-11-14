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

		$articles = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM articles ORDER BY creation_date DESC LIMIT 0, 20');
		
		
		return $articles;
	}

	public function postArticlesUser($title, $content) // insertion article user à la db
	{
		$db = $this->dbConnect();
		$inserarticle = $db->prepare('INSERT INTO articles(title, content, creation_date) VALUES (?, ?, NOW())');
        $article = $inserarticle->execute(array($title, $content));
		
		return $article;

	}

	public function getArticlesUser($depart, $articlesparp) // méthode de récupération articles
	{
		
		$db = $this->dbConnect();

		$articles = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM articles ORDER BY creation_date DESC LIMIT 0, 20');
		
		
		return $articles;
	}
	
}