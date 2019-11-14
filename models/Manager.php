<?php
namespace OpenClass;
require 'vendor/autoload.php';

class Manager
{
	protected function dbConnect()// méthode de connexion à la bdd
	{
		try
		{
			$db = new \PDO('mysql:host=localhost;dbname=projet5;charset=utf8', 'root', '');
			return $db;
		}
		catch (Exception $e)
		{
			die('Erreur : ' .$e->getMessage());
		}
	}
}