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
                        $display = new ControllerUser();
            						$contact = $display->addMember($_POST['pseudo'], $_POST['mail'], $_POST['mdp']); 
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
              

		}else{ //pageAccueil(); //si aucune action, alors affiche moi la page d'accueil ;)
  			     
            $vue = new ControllerAccueil();
            $accueil = $vue->pageAccueil();
            return $accueil;
          }

	}catch(Exception $e) { 	
    echo 'Erreur : ' . $e->getMessage();
}
