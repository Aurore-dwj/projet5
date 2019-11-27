<?php
namespace Control;
require 'vendor/autoload.php';


class ControllerAccueil
{

	public function pageAccueil() // affichage page d'accueil
	{
		require('views/frontend/accueil.php');
	}
		
}

		
