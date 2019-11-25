<!--ROUTEUR-->
<?php
session_start();

require 'vendor/autoload.php';
use Control\{ControllerAccueil, ControllerUser, ControllerAdmin, Exception};
use OpenClass\{ArticlesManager, CommentsManager, Manager, MembersManager, Pagination};

try
{
    // affichage page d'accueil
    if (isset($_GET['action']))
    {
        if ($_GET['action'] == 'pageAccueil')
        {
            $display = new ControllerAccueil();
            $contact = $display->pageAccueil();

        }

        // affichage formulaire d'inscription
        if ($_GET['action'] == 'displFormulContact')
        {
            $display = new ControllerUser();
            $contact = $display->displFormulContact();

        }

        //affiche formulaire de connexion
        if ($_GET['action'] == 'displConnexion')
        {
            $display = new ControllerUser();
            $contact = $display->displConnexion();

        }

        // ajout membre après divers tests
        if ($_GET['action'] == 'addMember')
        {
            if (isset($_POST['addMember']) and isset($_POST['pseudo']) and isset($_POST['mail']) and isset($_POST['mdp']))
            {
                $pseudo = htmlspecialchars($_POST['pseudo']);
                $mail = htmlspecialchars($_POST['mail']);
                if (!empty($_POST['pseudo']) and !empty($_POST['mail']) and !empty($_POST['mdp']))
                {
                    $pseudolength = strlen($pseudo);
                    if ($pseudolength > 2)
                    {
                        if (filter_var($mail, FILTER_VALIDATE_EMAIL))
                        {
                            $inscription = new ControllerUser();
                            $contact = $inscription->addMember($_POST['pseudo'], $_POST['mail'], $_POST['mdp'], 'default.jpg');
                            return $contact;
                        }
                        else
                        {
                            throw new Exception('Adresse mail non valide !');
                        }
                    }
                    else
                    {
                        throw new Exception('Votre pseudo doit contenir plus de deux caractères !');
                    }
                }
                else
                {
                    throw new Exception('Tous les champs doivent être complétés');
                }
            }
        }

        //connexion
        if ($_GET['action'] == 'connexion')
        {
            if (isset($_POST['connexion']) and isset($_POST['pseudo']) and isset($_POST['mdp']))
            {
                $pseudo = htmlspecialchars($_POST['pseudo']);

                if (!empty(trim($_POST['pseudo'])) and !empty(trim($_POST['mdp'])))
                {
                    $connex = new ControllerUser();
                    $nouvelconnex = $connex->connexion($_POST['pseudo'], $_POST['mdp']);
                    return $nouvelconnex;
                }
                else
                {
                    throw new Exception('Oups...Tous les champs doivent être complétés !');
                }
            }
        }

        //deconnexion
        if ($_GET['action'] == 'deconnexion')
        {
            $deconnex = new ControllerUser();
            $nouveldeconnex = $deconnex->deconnexion();

        }

        //affiche les infos du profil à l'ouverture et update infos si besoin
        if ($_GET['action'] == 'affInfosUser')
        {
            if (isset($_SESSION['id']))
            {
                $all = new ControllerUser();
                $user = $all->affInfosUser();

                if (isset($_POST['newpseudo']) and !empty($_POST['newpseudo']) and $_POST['newpseudo'] != $user['pseudo'])
                {
                    $newpseudo = htmlspecialchars($_POST['newpseudo']);
                    $controlleruser = new ControllerUser();
                    $userpseudo = $controlleruser->updatePseudo($newpseudo);
                }
                if (isset($_POST['newmail']) and !empty($_POST['newmail']) and $_POST['newmail'] != $user['mail'])
                {
                    $newmail = htmlspecialchars($_POST['newmail']);
                    $controlleruser = new ControllerUser();
                    $usermail = $controlleruser->updateMail($newmail);
                }
                if (isset($_POST['newmdp']) and !empty($_POST['newmdp']) and $_POST['newmdp'] != $user['motdepasse'])
                {
                    $newmdp = password_hash($_POST['newmdp'], PASSWORD_DEFAULT);
                    $controlleruser = new ControllerUser();
                    $usermdp = $controlleruser->updateMdp($newmdp);
                }
            }
        }

        //chargement du fichier avatar 
        if ($_GET['action'] == 'getAvatar')
        {
            if (isset($_FILES['avatar']) and !empty($_FILES['avatar']['name']))
            {
                $tailleMax = 2097152;
                $extensionsValides = array(
                    'jpg',
                    'jpeg',
                    'gif',
                    'png'
                );
                if ($_FILES['avatar']['size'] <= $tailleMax)
                {
                    $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.') , 1));
                    if (in_array($extensionUpload, $extensionsValides))
                    {
                        $chemin = "publics/membres/avatars/" . $_SESSION['id'] . "." . $extensionUpload;
                        $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                        if ($resultat)
                        {
                            $newavatar = $_SESSION['id'] . "." . $extensionUpload;
                            $controlleruser = new ControllerUser();
                            $userAvatar = $controlleruser->getAvatar($newavatar);

                            header('Location: index.php?id=' . $_SESSION['id']);
                        }
                        else
                        {
                            throw new Exception('Erreur durant l\'importation de votre photo de profil');
                        }
                    }
                    else
                    {
                        throw new Exception('Votre photo de profil doit être au format jpg, jpeg, gif ou png');
                    }
                }
                else
                {
                    throw new Exception('Votre photo de profil ne doit pas dépasser 2Mo');
                }
            }
        }

        //affiche le profil
        if ($_GET['action'] == 'affProfil')
        {
            $profil = new ControllerUser();
            $aff = $profil->affProfil();
        }

        //rédac articles Admin
        if ($_GET['action'] == 'adminViewConnect')
        {
            if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0))
            { //CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
                header('Location: index.php');
            }
            else
            {
                if (isset($_SESSION) && $_SESSION['droits'] == '1')
                {
                    $controlleradmin = new ControllerAdmin();
                    $adminconnect = $controlleradmin->adminViewConnect();
                }
                else
                {
                    throw new Exception("Oups... Vous n\'avez aucun droit administrateur !");
                }
            }
        }

        //accès dashboard et rédation nouvel article admin
        if ($_GET['action'] == 'redacArticles')
        {
            if (isset($_POST['envoi_article']) and isset($_POST['id_rubrique']) and isset($_SESSION['id']) and isset($_POST['title']) and isset($_POST['content']))
            {
                $title = ($_POST['title']);
                $content = ($_POST['content']);
                $idUser = ($_SESSION['id']);
                $idRubrique = ($_POST['id_rubrique']);
                if (!empty(trim($_POST['title'])) and !empty(trim($_POST['content'])))
                {
                    $redacArticle = new ControllerAdmin();
                    $aff = $redacArticle->redacArticles($idRubrique, $idUser, $title, $content);
                }
                else
                {
                    throw new Exception('Vous n\'avez pas saisi d\'article !');
                }
            }
        }

        //affichage liste des articles Admin
        if ($_GET['action'] == 'listArticlesAdmin')
        {
            if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0))
            { //CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
                header('Location: index.php');
            }
            else
            {
                $listarticlesAdmin = new ControllerAdmin();
                $list = $listarticlesAdmin->listArticlesAdmin();

            }
        }

        //dashboard rédac article user
        if ($_GET['action'] == 'userViewConnect')
        {
            $controller = new ControllerUser();
            $connect = $controller->userViewConnect();
        }

        // rédation nouvel article user
        if ($_GET['action'] == 'redacArticlesUser')
        {
            if (isset($_POST['envoi_article']) and isset($_POST['id_rubrique']) and isset($_SESSION['id']) and isset($_POST['title']) and isset($_POST['content']))
            {
                $title = htmlspecialchars($_POST['title']);
                $content = htmlspecialchars($_POST['content']);
                $idUser = ($_SESSION['id']);
                $idRubrique = ($_POST['id_rubrique']);
                if (!empty(trim($_POST['title'])) and !empty(trim($_POST['content'])))
                {
                    $redacArticle = new ControllerUser();
                    $aff = $redacArticle->redacArticlesUser($idRubrique, $idUser, $title, $content);
                }
                else
                {
                    throw new Exception('Vous n\'avez pas saisi d\'article !');
                }
            }
        }

        //affichage liste des articles user
        if ($_GET['action'] == 'listArticlesUser')
        {

            if (isset($_GET['id_rubrique']) && $_GET['id_rubrique'] > 0)
            {

                $listarticles = new ControllerUser();
                $list = $listarticles->listArticlesUser($_GET['id_rubrique']);
            }
            
        }

        elseif ($_GET['action'] == 'affArticle')
        { //affiche un article
            if (isset($_GET['id']) && $_GET['id'] > 0)
            {
                $artic = new ControllerUser();
                $afficheMoiLarticle = $artic->affArticle();

            }
            else
            {
                throw new Exception('Oups... Aucun identifiant d\'article envoyé !');
            }
        }

        if ($_GET['action'] == 'addComment')
        { //ajout d'un commentaire
            if (isset($_GET['id']) && $_GET['id'] > 0)
            {
                if (!empty($_GET['id']) && ($_POST['content']))
                {

                    $controlleruser = new ControllerUser();
                    $addcomment = $controlleruser->addComment($_GET['id'], $_SESSION['id'], $_POST['content']);
                }
                else
                {
                    throw new Exception('Oups... Tous les champs ne sont pas remplis !');
                }
            }
            else
            {
                throw new Exception('Oups... Aucun identifiant article !');
            }
        }

        //affiche article signalé après son signalement User
        if( $_GET['action'] == 'articleSignale')
            {
                if (isset($_GET['id']) && $_GET['id'] > 0)
                {
                    $listarticles = new ControllerUser();
                    $list = $listarticles->articleSignale();
                }
            }

        //récupère et affiche les commentaires signalés Admin
        if ($_GET['action'] == 'getCommentAdmin')
        {
            if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0))
            { //CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
                header('Location: index.php');
            }
            else
            {
                if (isset($_GET['signalement']) && $_GET['signalement'] == '1')
                {
                    $controlleradmin = new ControllerAdmin();
                    $comments = $controlleradmin->getCommentAdmin($_GET['signalement']);
                }
                else
                {
                    throw new Exception('Oups....erreur de désignalement !');
                }
            }
        }

        //signale un commentaire User
        if ($_GET['action'] == 'signalCommentUser')
        {
            if ((isset($_GET['id'])) && (!empty($_GET['id'])))
            {
                $controlleruser = new ControllerUser();
                $signale = $controlleruser->signalCommentUser($_GET['id']);

            }
            else
            {
                throw new Exception('Oups....erreur de signalement !');
            }
        }

        //affiche un article à modifier ou à supprimer Admin
        if ($_GET['action'] == 'articAdmin')
        {
            if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0))
            {
                header('Location: index.php');
            }
            else
            {
                if (isset($_GET['id']) && $_GET['id'] > 0)
                {
                    $controlleradmin = new ControllerAdmin();
                    $affiche = $controlleradmin->articAdmin();
                }
            }
        }

        //supprime article Admin
        if ($_GET['action'] == 'supprimerArticle')
        {
            if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0))
            { //CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
                header('Location: index.php');
            }
            else
            {
                if ((isset($_GET['id'])) && (!empty($_GET['id'])))
                {
                    $controlleradmin = new ControllerAdmin();
                    $supprimer = $controlleradmin->supprimerArticle($_GET['id']);
                }
            }
        }

        //modifie article Admin
        if ($_GET['action'] == 'modifierArticle')
        {
            if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0))
            { //CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
                header('Location: index.php');
            }
            else
            {
                if ((isset($_GET['id'])) && (!empty($_GET['id'])))
                {
                    $controlleradmin = new ControllerAdmin();
                    $modifier = $controlleradmin->modifierArticle($_POST['title'], $_POST['content'], $_GET['id']);
                }
            }
        }

        //signale un article User
        if ($_GET['action'] == 'signalerArticleUser')
        {
            if ((isset($_GET['id'])) && (!empty($_GET['id'])))
            {
                $controlleruser = new ControllerUser();
                $signale = $controlleruser->signalerArticleUser($_GET['id']);

            }
            else
            {
                throw new Exception('Oups....erreur de signalement !');
            }
        }

        //récupère articles signalés Admin
        if ($_GET['action'] == 'getArticlesAdmin')
        {
            if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0))
            { //CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
                header('Location: index.php');
            }
            else
            {
                if (isset($_GET['signalement']) && $_GET['signalement'] == '1')
                {
                    $controlleradmin = new ControllerAdmin();
                    $designale = $controlleradmin->getArticlesAdmin($_GET['signalement']);
                }
                else
                {
                    throw new Exception('Oups....erreur de désignalement !');
                }
            }
        }

        //désignale article signalé Admin
        if ($_GET['action'] == 'designalArticle')
        {
            if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0))
            { //CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
                header('Location: index.php');
            }
            else
            {
                if ((isset($_GET['id'])) && (!empty($_GET['id'])))
                {
                    $controlleradmin = new ControllerAdmin();
                    $designale = $controlleradmin->designalArticle($_GET['id']);

                }
                else
                {
                    throw new Exception('Oups....erreur de désignalement !');
                }
            }
        }

        //désignale commentaire signalé Admin
        if ($_GET['action'] == 'designalCommentaire')
        {
            if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0))
            { //CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
                header('Location: index.php');
            }
            else
            {
                if ((isset($_GET['id'])) && (!empty($_GET['id'])))
                {
                    $controlleradmin = new ControllerAdmin();
                    $designale = $controlleradmin->designalCommentaire($_GET['id']);

                }
                else
                {
                    throw new Exception('Oups....erreur de désignalement !');
                }
            }
        }

        //supprime commentaire Admin
        if ($_GET['action'] == 'supprimerCommentaire')
        {
            if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0))
            { //CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
                header('Location: index.php');
            }
            else
            {
                if ((isset($_GET['id'])) && (!empty($_GET['id'])))
                {
                    $controlleradmin = new ControllerAdmin();
                    $supprimer = $controlleradmin->supprimerCommentaire($_GET['id']);
                }
            }
        }

    }
    else
    { //pageAccueil(); //si aucune action, alors affiche moi la page d'accueil ;)
        $vue = new ControllerAccueil();
        $accueil = $vue->pageAccueil();

    }

}
catch(Exception $e)
{
    $errorMessage = $e->getMessage();
    require('views/frontend/errorView.php');
}

