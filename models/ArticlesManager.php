<?php
namespace OpenClass;
require 'vendor/autoload.php';

use OpenClass\Manager;



class ArticlesManager extends Manager
{
	public function postArticle($title, $content) // insertion article à la db
	{
		$db = $this->dbConnect();
		$inserarticle = $db->prepare('INSERT INTO articles(title, content, creation_date) VALUES (?, ?, NOW())');
        $article = $inserarticle->execute(array($title, $content));
		
		return $article;

	}
	
}