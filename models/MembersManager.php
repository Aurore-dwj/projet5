<?php
namespace OpenClass;
require 'vendor/autoload.php';

use OpenClass\Manager;



class MembersManager extends Manager
{
	public function getConnect($pseudo)//récupère les information relative à la connexion de l'utilisateur inscrit en db
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT id, motdepasse, droits FROM membres WHERE pseudo = :pseudo');
		$req->execute(array('pseudo' =>$pseudo));
		$connect = $req->fetch();
		return $connect;
	}

	public function insertMembre($pseudo, $mail, $mdp)//insertion infos nouveau membre en db
	{
		$db = $this->dbConnect();
		$insertmbr = $db->prepare("INSERT INTO membres(pseudo, mail, motdepasse, droits) VALUES(?, ?, ?, 0)");
        $insertmbr->execute(array($pseudo, $mail, $mdp));
        return $insertmbr;

	}

	public function testMail($mail)//test pour contrer doublon mail
	{
		$db = $this->dbConnect();
		 $reqmail = $db->prepare("SELECT * FROM membres WHERE mail = ?");
               $reqmail->execute(array($mail));
           	   $mailexist = $reqmail->rowCount();
               return $mailexist;
	}
}