<?php
namespace Control;
require 'vendor/autoload.php';


use OpenClass\{ArticlesManager, CommentsManager, Manager, MembersManager};

class ControllerUser
{

	public function displFormulContact() // affichage formulaire de contact
	{
		require('views/frontend/formulaireView.php');
	}

	public function addMember($pseudo, $mail, $mdp) //ajout membre après divers tests
	{
	$membre = new MembersManager();
	$test = new MembersManager();

	$mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
	
	$testOk = $test->testMail($mail);

	if($testOk == 0) {
		$newMembre = $membre->insertMembre($pseudo, $mail, $mdp);
		header("Location: index.php?action=displConnexion");
	}else{ 
		echo '<p style= "border: 1px solid red; text-align: center; font-size: 55px; margin: 90px 90px 90px;">Oups... Adresse email déjà utilisé  !</p>';}
	}

	public function displconnexion() //affichage formulaire connexion
	{
	require('views/frontend/connectView.php');
	}

		
}