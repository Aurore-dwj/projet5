<?php

session_start();

require 'vendor/autoload.php';
use Control\{ControllerAccueil, ControllerUser};
use OpenClass\{ArticlesManager, CommentsManager, Manager, MembersManager};


try {

		if (isset($_GET['action'])) { // affichage page d'accueil
      if ($_GET['action'] == 'pageAccueil') {
      pageAccueil(); 
    }

    elseif (isset($_GET['action'])) { // affichage formulaire d'inscription
      if ($_GET['action'] == 'displFormulContact') {
      $display = new ControllerUser();
      $contact = $display->displFormulContact();
    
      }     
    }

    if (isset($_GET['action'])) { //affiche formulaire de connexion
      if ($_GET['action'] == 'displConnexion') {
        $display = new ControllerUser();
        $contact = $display->displConnexion();
       
      }       
    }

    if (isset($_GET['action'])) { // ajout membre après divers tests 
      if ($_GET['action'] == 'addMember') {
        if (isset($_POST['addMember']) AND isset($_POST['pseudo'])  AND isset($_POST['mail']) AND isset($_POST['mdp'])) { 
          $pseudo = htmlspecialchars($_POST['pseudo']);
          $mail = htmlspecialchars($_POST['mail']);
          if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mdp'])) {
           $pseudolength = strlen($pseudo);
            if($pseudolength > 2) {
              if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
              $inscription = new ControllerUser();
              $contact = $inscription->addMember($_POST['pseudo'], $_POST['mail'], $_POST['mdp']); 
              return $contact;
              }else{
                throw new Exception('Adresse mail non valide !');
            }
            }else{
              throw new Exception('Votre pseudo doit contenir plus de deux caractères !');
          }
          }else{
            throw new Exception('Tous les champs doivent être complétés');
          }
        }
      }
    }

    if(isset($_GET['action'])) { //connexion
      if ($_GET['action'] == 'connexion') {
        if (isset($_POST['connexion']) AND isset($_POST['pseudo']) AND isset($_POST['mdp'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        
        if(!empty(trim($_POST['pseudo'])) AND !empty(trim($_POST['mdp']))){
        $connex = new ControllerUser();
        $nouvelconnex=$connex->connexion($_POST['pseudo'], $_POST['mdp']);
        return $nouvelconnex; 
        }else{
          throw new Exception('Tous les champs doivent être complétés');
           } 
        }
      }
    }

    if (isset($_GET['action'])) { //deconnexion
      if ($_GET['action'] == 'deconnexion') {
      $deconnex = new ControllerUser();
      $nouveldeconnex=$deconnex->deconnexion();
      
      } 
    }

    /*if (isset($_GET['action'])) { 
      if ($_GET['action'] == 'displFotoProfil') {
        $display = new ControllerUser();
        $fotoprofil = $display->displFotoProfil();
      
      }       
    }*/

    if (isset($_GET['action'])) {//affiche page édit et update infos (A SECURISER!)
      if ($_GET['action'] == 'updateInfos') {
       if(isset($_SESSION['id'])) {
        $all = new ControllerUser();
        $user = $all->updateInfos();
          if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
            $newpseudo = htmlspecialchars($_POST['newpseudo']);
            $controlleruser = new ControllerUser();
            $userpseudo = $controlleruser->updatePseudo($newpseudo);
            }
            if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
              $newmail = htmlspecialchars($_POST['newmail']);
              $controlleruser = new ControllerUser();
              $usermail = $controlleruser->updateMail($newmail);
              }
              if(isset($_POST['newmdp']) AND !empty($_POST['newmdp']) AND $_POST['newmdp'] != $user['motdepasse']) {
                $controlleruser = new ControllerUser();
                $usermdp = $controlleruser->updateMdp($newmdp);
              }
            } 
          }
        }

    if (isset($_GET['action'])) { //affiche profil (A SECURISER!)
      if ($_GET['action'] == 'affProfil') {
      $profil = new ControllerUser(); 
      $aff = $profil->affProfil();
    
        
      }       
    }  






		}else{ //pageAccueil(); //si aucune action, alors affiche moi la page d'accueil ;)

    $vue = new ControllerAccueil();
    $accueil = $vue->pageAccueil();
    
  }

}catch(Exception $e) { 	
  echo 'Erreur : ' . $e->getMessage();
}
