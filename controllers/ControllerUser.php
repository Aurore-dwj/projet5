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

	public function connexion($pseudo,$motdepass) //connexion
	{
		$membre = new MembersManager();
		$connect = $membre->getConnect($pseudo);
		$isPasswordCorrect = password_verify($_POST['mdp'], $connect['motdepasse']);
		$mdp = $connect['motdepasse'];

		if (!$connect)
		{
			echo 'Mauvais identifiant ou mot de passe !';
		}
		else{

			if ($isPasswordCorrect) {
				if(isset($_POST['rememberme'])){ //chekbox se souvenir de moi
					setcookie('pseudo',$pseudo,time()+365*24*3600,null,null,false,true);//chargement des cookies pseudo et mdp
					setcookie('mdp',$mdp,time()+365*24*3600,null,null,false,true);
				}
				if(!isset($_SESSION['id']) AND isset($_COOKIE['pseudo'],$_COOKIE['mdp']) AND !empty($_COOKIE['pseudo']) AND !empty($_COOKIE['mdp'])) {//si pas de session mais cookies pseudo et mdp...
					$membre = new MembersManager();//on instancie la class MembersManager...
					$rem = $membre->remember($pseudo,$mdp);//et on appelle la fonction remember avec les infos rapportés du modèle
					return $rem;
					if($rem == 1) // si cookies pseuso et mdp == à 1
					{// on ouvre les différentes sessions et rdv à la page d'accueil
						session_start();
						$_SESSION['id'] = $connect['id'];
						$_SESSION['pseudo'] = $pseudo;
						$_SESSION['droits'] = $connect['droits'];

						header("Location: index.php");
					}else{ //sinon message:
						echo '<p style= "border: 1px solid red; text-align: center; font-size: 55px; margin: 90px 90px 90px;">Oups... Veuillez vous reconnecter !</p>';
					}
				}
				session_start();
				$_SESSION['id'] = $connect['id'];
				$_SESSION['pseudo'] = $pseudo;
				$_SESSION['droits'] = $connect['droits'];

				header("Location: index.php");


			}else{
				echo 'Mauvais identifiant ou mot de passe !';
			}
			if(!empty($_SESSION['droits']) && $_SESSION['droits'] == '1') 
				header("Location: index.php");

		}
	}

	public function deconnexion() //déconnexion
	{
		session_start();
		setcookie('pseudo','',time()-3600);
		setcookie('mdp','',time()-3600);
		$_SESSION = array();
		session_destroy();
		header("Location: index.php"); 
	}


}