<?php

session_start();

require('controllers/frontend.php');
require('controllers/backend.php');

try {

		if (isset($_GET['action'])) { // affichage page d'accueil
			if ($_GET['action'] == 'pageAccueil') {
  			pageAccueil(); 
		}





		}
		else { 
  			pageAccueil(); //si aucune action, alors affiche moi la page d'accueil ;)
		}

	} catch(Exception $e) { 	
    echo 'Erreur : ' . $e->getMessage();
}
