<?php
namespace OpenClass;
require 'vendor/autoload.php';

use OpenClass\Manager;
use Control\{ControllerUser, ControllerAdmin};


class CommentsManager extends Manager
{
	public function getComments($idArticle)//méthode de récupération des commentaire avec une jointure dans la requete pour récupérer le pseudo de l'user
	{
		$db = $this->dbConnect();
		$comments = $db->prepare('SELECT avis.id, membres.pseudo, avis.content, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM avis INNER JOIN membres ON avis.id_membre = membres.id WHERE id_article = ? ORDER BY comment_date DESC');
		$comments->execute(array($idArticle));

		return $comments;
	}

	public function postComment($idArticle, $idMembre, $content)//insertion des commentaires dans la table avis
	{
		$db = $this->dbConnect();
		$comments = $db->prepare('INSERT INTO avis(id_article, id_membre, content, comment_date) VALUES( ?, ?, ?, NOW())');
		$affectedLines = $comments->execute(array($idArticle, $idMembre, $content));

		return $affectedLines;
	}

	public function signalement($commentId) //requete pour signaler un commentaire (user)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('UPDATE avis SET signalement = 1 WHERE id = ?');
		$req->execute(array($commentId));

		return $req;
	}

	public function getCommentSignal($signalement) //récupère les commentaires signalés pour les afficher avec le signalement signé (admin)
	{
		$db = $this->dbConnect();
		$comments = $db->prepare('SELECT avis.id, membres.pseudo, avis.id_article, avis.id_membre, avis.content, avis.signalement, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM avis INNER JOIN membres ON avis.id_membre = membres.id WHERE signalement = 1 ORDER BY comment_date DESC');
		$comments->execute(array($signalement));
		return $comments;

		/*SELECT avis.id, membres.pseudo, avis.content, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM avis INNER JOIN membres ON avis.id_membre = membres.id WHERE id_article = ? ORDER BY comment_date DESC');*/

	}

	public function deSignal($commentId) //désignale un commentaire (admin)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('UPDATE avis SET signalement = 0 WHERE id = ?');
		$req->execute(array($commentId));

		return $req;
	}

	public function deleteComment($commentId) //supprime un commentaire (admin)
	{ 
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM avis WHERE id = ?');
        $req->execute(array($commentId));
       	return $req;
    }
	
}