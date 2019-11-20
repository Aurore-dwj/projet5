<?php

session_start();

require 'vendor/autoload.php';
use Control\{ControllerAccueil, ControllerUser, ControllerAdmin};
use OpenClass\{ArticlesManager, CommentsManager, Manager, MembersManager, Pagination};


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
              $contact = $inscription->addMember($_POST['pseudo'], $_POST['mail'], $_POST['mdp'], 'default.jpg'); 
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

    if (isset($_GET['action'])) {//affiche page édit et update infos (A SECURISER!)
      if ($_GET['action'] == 'affInfosUser') {
       if(isset($_SESSION['id'])) {
        $all = new ControllerUser();
        $user = $all->affInfosUser();

      if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] /*!= $user['pseudo']*/) {
        $newpseudo = htmlspecialchars($_POST['newpseudo']);
        $controlleruser = new ControllerUser();
        $userpseudo = $controlleruser->updatePseudo($newpseudo);
      }
    if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] /*!= $user['mail']*/){
      $newmail = htmlspecialchars($_POST['newmail']);
      $controlleruser = new ControllerUser();
      $usermail = $controlleruser->updateMail($newmail);
    } 
  if(isset($_POST['newmdp']) AND !empty($_POST['newmdp']) AND $_POST['newmdp'] /*!= $user['motdepasse']*/) {
    $newmdp = password_hash($_POST['newmdp'], PASSWORD_DEFAULT);
    $controlleruser = new ControllerUser();
    $usermdp = $controlleruser->updateMdp($newmdp);
  }
} 
} 
}

    if (isset($_GET['action'])) { //avatar
      if ($_GET['action'] == 'getAvatar') {   
        if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
          $tailleMax = 2097152;
          $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
          if($_FILES['avatar']['size'] <= $tailleMax) {
            $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
            if(in_array($extensionUpload, $extensionsValides)) {
              $chemin = "publics/membres/avatars/".$_SESSION['id'].".".$extensionUpload;
              $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
              if($resultat) {
                $newavatar=$_SESSION['id'].".".$extensionUpload;
                $controlleruser = new ControllerUser();
                $userAvatar = $controlleruser->getAvatar($newavatar);

                
                header('Location: index.php?id='.$_SESSION['id']);
              } else {
                throw new Exception('Erreur durant l\'importation de votre photo de profil');
              }
            } else {
              throw new Exception('Votre photo de profil doit être au format jpg, jpeg, gif ou png');
            }
          } else {
            throw new Exception('Votre photo de profil ne doit pas dépasser 2Mo');
          }
        }
      }
    }

        if (isset($_GET['action'])) { //affiche profil
          if ($_GET['action'] == 'affProfil') {
            $profil = new ControllerUser(); 
            $aff = $profil->affProfil();
          }       
        }

    if (isset($_GET['action'])) { //connexion gestion et rédac articles Admin 
      if ($_GET['action'] == 'adminViewConnect') {
        if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)) {//CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
        header('Location: index.php');
      }else{
        if (isset($_SESSION) && $_SESSION['droits'] == '1') {
          $controlleradmin = new ControllerAdmin(); 
          $adminconnect= $controlleradmin->adminViewConnect();
        }else { 
          throw new Exception("Oups... Vous n\'avez aucun droit administrateur !");
        }
      }
    }
  }





    if (isset($_GET['action'])) { // rédation nouvel article admin
      if ($_GET['action'] == 'redacArticles') {
        if (isset($_POST['envoi_article']) AND isset($_POST['id_rubrique']) AND isset($_SESSION['id']) AND isset($_POST['title']) AND isset($_POST['content'])) 
        {
          $title = ($_POST['title']);
          $content = ($_POST['content']);
          $idUser = ($_SESSION['id']);
          $idRubrique = ($_POST['id_rubrique']);
          if(!empty(trim($_POST['title'])) AND !empty(trim($_POST['content'])))
          {         
            $redacArticle = new ControllerAdmin(); 
            $aff = $redacArticle->redacArticles($idRubrique,$idUser,$title,$content);
          }else{
            throw new Exception('Vous n\'avez pas saisi d\'article !');
          }             
        }
      }
    }  

    if (isset($_GET['action'])) { //affichage liste des articles Admin
      if ($_GET['action'] == 'listArticlesAdmin') {
        if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)) { //CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
        header('Location: index.php');
      }else{
       $listarticlesAdmin = new ControllerAdmin(); 
       $list= $listarticlesAdmin->listArticlesAdmin(); 

     }
   }
 }

    if (isset($_GET['action'])) { //connexion rédac article user
      if ($_GET['action'] == 'userViewConnect') {
        $controller = new ControllerUser(); 
        $connect= $controller->userViewConnect();
      }
    }



    if (isset($_GET['action'])) { // rédation nouvel article user
      if ($_GET['action'] == 'redacArticlesUser') {
        if (isset($_POST['envoi_article']) AND isset($_POST['id_rubrique']) AND isset($_SESSION['id']) AND isset($_POST['title']) AND isset($_POST['content'])) 
        {
          $title = htmlspecialchars($_POST['title']);
          $content = htmlspecialchars($_POST['content']);
          $idUser = ($_SESSION['id']);
          $idRubrique = ($_POST['id_rubrique']);
          if(!empty(trim($_POST['title'])) AND !empty(trim($_POST['content'])))
          {         
            $redacArticle = new ControllerUser(); 
            $aff = $redacArticle->redacArticlesUser($idRubrique, $idUser, $title, $content);
          }else{
            throw new Exception('Vous n\'avez pas saisi d\'article !');
          }             
        }
      }
    } 

                                                      
      if($_GET['action'] == 'listArticlesUser') {//affichage liste des articles user histoire
       if(isset($_GET['id_rubrique']) AND isset($_POST['depart']) AND isset($_POST['articlesparp'])) {
        $idRubrique = ($_GET['id_rubrique']);
        $depart = ($_POST['depart']);
        $articlesparp = ($_POST['articlesparp']);
       $listarticles = new ControllerUser();
       $list= $listarticles->listArticlesUser($idRubrique, $depart, $articlesparp); 
         }
         if ($_GET['action'] == 'affichArticle') { //affiche un article 
         if (isset($_GET['id']) && $_GET['id'] > 0) {
          $article = new ControllerUser(); 
          $afficheMoiLarticle = $article->affichArticle(); 
        }else{
          throw new Exception('Oups... Aucun identifiant chapitre envoyé !');
        }
      }

        elseif ($_GET['action'] == 'addComment') { //ajout d'un commentaire
        if (isset($_GET['id']) && $_GET['id'] > 0) {
         if(!empty($_GET['id']) && ($_POST['content'])) {
          $content = htmlspecialchars($_POST['content'])
          $controlleruser = new ControllerUser();
          $addcomment = $controlleruser->addComment($_GET['id'], $_SESSION['id'], $_POST['content']);
          }else{
            throw new Exception('Oups... Tous les champs ne sont pas remplis !');
            }
          }else{
            throw new Exception('Oups... Aucun identifiant article !');
        }
      }
    }
  
   

            if (isset($_GET['action'])) { //récupère et affiche les commentaires signalés
              if ($_GET['action'] == 'getCommentAdmin') {
                if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)) {//CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
                header('Location: index.php');
              }else{
                if (isset($_GET['signalement']) && $_GET['signalement'] == '1') {
                  $controlleradmin = new ControllerAdmin(); 
                  $comments = $controlleradmin->getCommentAdmin($_GET['signalement']);
                }else{ 
                  throw new Exception('Oups....erreur de désignalement !');
                }
              }
            }
          }

            if (isset($_GET['action'])) { //signale un commentaire
              if ($_GET['action'] == 'signalCommentUser') {
                if ((isset($_GET['id'])) && (!empty($_GET['id']))){
                  $controlleruser = new ControllerUser(); 
                  $signale = $controlleruser->signalCommentUser($_GET['id']);

                }else{
                  throw new Exception('Oups....erreur de signalement !');
                }
              }
            }



            if (isset($_GET['action'])) { //affiche un article à modifier ou à supprimer Admin
             if ($_GET['action'] == 'articAdmin') {
              if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)) {
                header('Location: index.php');
              }else{
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                  $controlleradmin = new ControllerAdmin(); 
                  $affiche = $controlleradmin->articAdmin(); 
                }
              } 
            }
          }

            if (isset($_GET['action'])) { //supprime article
              if ($_GET['action'] == 'supprimerArticle') {
                if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)) {//CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
                header('Location: index.php');
              }else{
                if ((isset($_GET['id'])) && (!empty($_GET['id']))) {
                  $controlleradmin = new ControllerAdmin(); 
                  $supprimer = $controlleradmin->supprimerArticle($_GET['id']); 
                }
              }
            }
          }

      if (isset($_GET['action'])) { //modifie article 
        if ($_GET['action'] == 'modifierArticle') {
          if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)) {//CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
          header('Location: index.php');
        }else{
          if ((isset($_GET['id'])) && (!empty($_GET['id']))) {
            $controlleradmin = new ControllerAdmin(); 
            $modifier = $controlleradmin->modifierArticle($_POST['title'], $_POST['content'], $_GET['id']); 
          }
        }
      }
    }

       if (isset($_GET['action'])) { //signale un article
        if ($_GET['action'] == 'signalerArticleUser') {
          if ((isset($_GET['id'])) && (!empty($_GET['id']))){
            $controlleruser = new ControllerUser(); 
            $signale = $controlleruser->signalerArticleUser($_GET['id']);
            
          }else{
            throw new Exception('Oups....erreur de signalement !');
          }
        }
      }

        if (isset($_GET['action'])) { //récupère articles signalés
          if ($_GET['action'] == 'getArticlesAdmin') {
            if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)) {//CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
            header('Location: index.php');
          }else{
            if (isset($_GET['signalement']) && $_GET['signalement'] == '1') {
              $controlleradmin = new ControllerAdmin(); 
              $designale = $controlleradmin->getArticlesAdmin($_GET['signalement']);
            }else{ 
              throw new Exception('Oups....erreur de désignalement !');
            }
          }
        }
      }

        if (isset($_GET['action'])) { //désignale article signalé
          if ($_GET['action'] == 'designalArticle') {
            if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)) {//CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
            header('Location: index.php');
          }else{
            if ((isset($_GET['id'])) && (!empty($_GET['id']))){
             $controlleradmin = new ControllerAdmin(); 
             $designale = $controlleradmin->designalArticle($_GET['id']);

           }else{ 
            throw new Exception('Oups....erreur de désignalement !');
          }
        }
      }
    }

        if (isset($_GET['action'])) { //désignale commentaire signalé
          if ($_GET['action'] == 'designalCommentaire') {
            if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)) {//CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
            header('Location: index.php');
            }else{
              if ((isset($_GET['id'])) && (!empty($_GET['id']))){
                $controlleradmin = new ControllerAdmin(); 
                $designale = $controlleradmin->designalCommentaire($_GET['id']);
             
                }else{ 
                  throw new Exception('Oups....erreur de désignalement !');
              }
            }
          }
        }

        if (isset($_GET['action'])) { //supprime commentaire
              if ($_GET['action'] == 'supprimerCommentaire') {
                if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)) {//CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
                header('Location: index.php');
              }else{
                if ((isset($_GET['id'])) && (!empty($_GET['id']))) {
                  $controlleradmin = new ControllerAdmin(); 
                  $supprimer = $controlleradmin->supprimerCommentaire($_GET['id']); 
                }
              }
            }
          }











		}else{ //pageAccueil(); //si aucune action, alors affiche moi la page d'accueil ;)

    $vue = new ControllerAccueil();
    $accueil = $vue->pageAccueil();
    
  }

}catch(Exception $e) { 	
  echo 'Erreur : ' . $e->getMessage();
}
