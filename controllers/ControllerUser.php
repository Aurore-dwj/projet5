<?php
namespace Control;
require 'vendor/autoload.php';


use OpenClass\{ArticlesManager, CommentsManager, Manager, MembersManager,Pagination};


class ControllerUser
{

	public function displFormulContact() // affichage formulaire de contact
	{
		require('views/frontend/formulaireView.php');
	}

	public function addMember($pseudo, $mail, $mdp, $avatar) //ajout membre après divers tests
	{
		$membre = new MembersManager();
		$test = new MembersManager();

		$mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

		$testOk = $test->testMail($mail);// test pour ne pas avoir de mail en doublon

		if($testOk == 0) {
			$newMembre = $membre->insertMembre($pseudo, $mail, $mdp,'default.jpg');
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
				if(!isset($_SESSION['id']) AND isset($_COOKIE['pseudo'],$_COOKIE['motdepasse']) AND !empty($_COOKIE['pseudo']) AND !empty($_COOKIE['motdepasse'])) {//si pas de session mais cookies pseudo et mdp...
					$membre = new MembersManager();//on instancie la class MembersManager...
					$rem = $membre->remember($_COOKIE['pseudo'], $_COOKIE['motdepasse']);//et on appelle la fonction remember avec les infos rapportés du modèle
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

	public function affProfil()
	{
		$infosmembre = new MembersManager();
		$allinfos = $infosmembre->infosProfil();
		require('views/frontend/afficheProfilView.php');
	}



	public function affInfosUser() // affiche les infos user
	{
		$infosmembre = new MembersManager();
		$allinfos = $infosmembre->infosProfil();
		require('views/frontend/profilView.php');
		
		
	}

	public function updatePseudo($newpseudo) //update le pseudo
	{
		$infosmembre = new MembersManager();
		$pseudoinfos = $infosmembre->infoPseudo($newpseudo);
		header('Location: index.php');
	}

	public function updateMail($newmail)// uptate le mail
	{
		
		$test = new MembersManager();
		$testOk = $test->testMail($newmail);
		if($testOk == 0) {// test pour ne pas avoir de mail en doublon
		$infosmembre = new MembersManager();
		$mailinfos = $infosmembre->infoMail($newmail);
		header('Location: index.php');
			}
	}

	public function updateMdp($newmdp)// update le motdepasse
	{
		$infosmembre = new MembersManager();
		$mdpinfos = $infosmembre->infoMdp($newmdp);
		header('Location: index.php');
	}

	public function getAvatar($newavatar)// update avatar
	{
		$membreManager = new MembersManager();
		$avatarinfos = $membreManager->infosAvatar($newavatar);

	}

	public function userViewConnect() //connexion rédac article user
	{
	require('views/frontend/redacArticleUser.php');
	}

	public function redacArticlesUser($idRubrique, $idUser, $title, $content)
	{
		$articleEdit = new ArticlesManager();
		$createarticle = $articleEdit->postArticlesUser($idRubrique, $idUser, $title, $content);
	
	if($createarticle === false) {
		die('<p style= "border: 1px solid red; text-align: center; font-size: 55px; margin: 90px 90px 90px;">Impossible d \'ajouter un article...');
	}else{
		header('Location: index.php?action=listArticlesUser');
		}
	}

	public function listArticlesUser() // liste articles admin
	{
		$articlesManager = new ArticlesManager();
		$pagination = new Pagination();
		$articlesparp = 4;
		$nombredarticles = $pagination->getArticlesPagination();
		$totalpages = $pagination->getArticlesPages($nombredarticles, $articlesparp);
		//die(var_dump($totalpages));
		if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $totalpages) {
   			$_GET['page'] = intval($_GET['page']);
   			$pageCourante = $_GET['page'];
			} else {
   			$pageCourante = 1;
			}
			$depart = ($pageCourante-1)*$articlesparp;
			$artic = $articlesManager->getArticlesUser($depart, $articlesparp);
			require('views/frontend/listArticlesHistoire.php');
			//die(var_dump($artic));
	}

	public function signalerArticleUser($articId)// signale un article
	{
		$commentManager = new ArticlesManager();
		$signal = $commentManager->signalement($articId);

	if($signal === false) {
		die('<p style= "border: 1px solid red; text-align: center; font-size: 55px; margin: 90px 90px 90px;">Oups... Impossible de signaler !</p>');
	}else{ 
		header('Location: index.php?action=listArticlesUser');

		}
	}

	public function affichArticle()
	{
		$articlesManager = new ArticlesManager();
		$commentsManager = new CommentsManager();

		$artic = $articlesManager->getArticles($_GET['id']);
		$comments = $commentsManager->getComments($_GET['id']);

	require('views/frontend/commentView.php');

	}

	public function addComment($idArticle, $idMembre, $content) //ajout commentaire
	{
	$commentsManager = new CommentsManager();

	$affectedLines = $commentsManager->postComment($idArticle, $_SESSION['id'], $content);
	
	if ($affectedLines === false){ //si le commentaire n'arrive pas à la bdd...
		die('<p style= "border: 1px solid red; text-align: center; font-size: 55px; margin: 90px 90px 90px;">Oups... Impossible d\'ajouter le commentaire !</p>');// on arrête le script avec un die

	}else{header('Location: index.php?action=affichArticle&id=' . $idArticle); // sinon on peut admirer son joli commentaire :)

		}
	}

	public function signalCommentUser($commentId)// signale un article
	{
		$commentManager = new CommentsManager();
		$signal = $commentManager->signalement($commentId);

	if($signal === false) {
		die('<p style= "border: 1px solid red; text-align: center; font-size: 55px; margin: 90px 90px 90px;">Oups... Impossible de signaler !</p>');
	}else{ 
		header('Location: index.php?action=listArticlesUser');

		}
	}




}