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
      return $contact;
      }     
    }

    if (isset($_GET['action'])) { //affiche formulaire de connexion
      if ($_GET['action'] == 'displConnexion') {
        $display = new ControllerUser();
        $contact = $display->displConnexion();
        return $contact;
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
      return $nouveldeconnex;
      } 
    }

    if (isset($_GET['action'])) { //affiche page ajout modif photo profil
      if ($_GET['action'] == 'displFotoProfil') {
        $display = new ControllerUser();
        $fotoprofil = $display->displFotoProfil();
        return $fotoprofil;
      }       
    }

    if (isset($_GET['action'])) { //affiche profil
      if ($_GET['action'] == 'affProfil') {
      $profil = new ControllerUser(); 
      $aff = $profil->affProfil();
      return $aff;
        
      }       
    }  






		}else{ //pageAccueil(); //si aucune action, alors affiche moi la page d'accueil ;)

    $vue = new ControllerAccueil();
    $accueil = $vue->pageAccueil();
    return $accueil;
  }

}catch(Exception $e) { 	
  echo 'Erreur : ' . $e->getMessage();
}
