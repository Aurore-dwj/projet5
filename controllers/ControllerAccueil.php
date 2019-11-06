<?php
namespace Control;
require 'vendor/autoload.php';


use OpenClass\{ArticlesManager, CommentsManager, Manager, MembersManager};

class ControllerAccueil extends Manager
{

	public function pageAccueil() // affichage page d'accueil
	{
		
		require('views/frontend/accueil.php');
	}
		
}

		
