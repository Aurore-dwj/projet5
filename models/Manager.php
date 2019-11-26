<?php
namespace OpenClass;
require 'vendor/autoload.php';

class Manager
{
	protected function dbConnect()// méthode de connexion à la bdd sans try/catch grâce au retour du routeur
	{
		
			$db = new \PDO('mysql:host=localhost;dbname=projet5;charset=utf8', 'root', '');
			return $db;
		
	}
}