<?php
namespace Control;
require 'vendor/autoload.php';

use OpenClass\{ArticlesManager, CommentsManager, Manager, MembersManager, Pagination};

class ControllerUser
{

    public function displFormulContact() // affichage formulaire de contact
    
    {
        require ('views/frontend/formulaireView.php');
    }

    public function addMember($pseudo, $mail, $mdp, $avatar) //ajout membre après divers tests
    
    {
        $membre = new MembersManager();
        $test = new MembersManager();

        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); //hash mot de passe
        $testOk = $test->testMail($mail); // test pour ne pas avoir de mail en doublon
        if ($testOk == 0)
        {
            $newMembre = $membre->insertMembre($pseudo, $mail, $mdp, 'default.jpg');
            header("Location: index.php?action=displConnexion");
        }
        else
        {
            throw new \Exception('Oups... Adresse email déjà utilisée');
        }
    }

    public function displConnexion() //affichage formulaire connexion
    
    {
        require ('views/frontend/connectView.php');
    }

    public function connexion($pseudo, $motdepass) //connexion
    
    {
        $membre = new MembersManager();
        $connect = $membre->getConnect($pseudo);
        $isPasswordCorrect = password_verify($_POST['mdp'], $connect['motdepasse']);
        $mdp = $connect['motdepasse'];

        if (!$connect)
        {
            throw new \Exception('Oups... Mauvais identifiant ou mot de passe !');
        }
        else
        {

            if ($isPasswordCorrect)
            {
                if (isset($_POST['rememberme']))
                { //checkbox se souvenir de moi
                    setcookie('pseudo', $pseudo, time() + 365 * 24 * 3600, null, null, false, true); //chargement des cookies pseudo et mdp
                    setcookie('mdp', $mdp, time() + 365 * 24 * 3600, null, null, false, true);
                }
                if (!isset($_SESSION['id']) and isset($_COOKIE['pseudo'], $_COOKIE['motdepasse']) and !empty($_COOKIE['pseudo']) and !empty($_COOKIE['motdepasse']))
                { //si pas de session mais cookies pseudo et mdp...
                    $membre = new MembersManager(); //on instancie la class MembersManager...
                    $rem = $membre->remember($_COOKIE['pseudo'], $_COOKIE['motdepasse']); //et on appelle la fonction remember avec les infos rapportés du modèle
                
                    if ($rem == 1) // si cookies pseuso et mdp == à 1
                    
                    { // on ouvre les différentes sessions et rdv à la page d'accueil
                        session_start();
                        $_SESSION['id'] = $connect['id'];
                        $_SESSION['pseudo'] = $pseudo; 
                        $_SESSION['droits'] = $connect['droits'];

                        header("Location: index.php");
                    }
                    else
                    { //sinon message:
                        throw new \Exception('Oups... Veuillez vous reconnecter !');
                    }
                }
                session_start();
                $_SESSION['id'] = $connect['id'];
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['droits'] = $connect['droits'];

                header("Location: index.php");

            }
            else
            {
                throw new \Exception('Mauvais identifiant ou mot de passe !');
            }
            if (!empty($_SESSION['droits']) && $_SESSION['droits'] == '1') {
                ////CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
                header("Location: index.php");
            }           
        }
    }

    public function deconnexion() //déconnexion
    
    {
        session_start();
        setcookie('pseudo', '', time() - 3600);
        setcookie('mdp', '', time() - 3600);
        $_SESSION = array();
        session_destroy();
        header("Location: index.php");
    }

    public function affProfil() // affiche les infos du profil à l'ouverture de la page profil
    
    {
        $infosmembre = new MembersManager();
        $allinfos = $infosmembre->infosProfil();
        require ('views/frontend/afficheProfilView.php');
    }

    public function affInfosUser() // affiche les infos user dans les champs de la page modifier infos
    
    {
        $infosmembre = new MembersManager();
        $allinfos = $infosmembre->infosProfil();
        require ('views/frontend/profilView.php');

    }

    public function updatePseudo($newpseudo) //update le pseudo
    
    {
        $infosmembre = new MembersManager();
        $pseudoinfos = $infosmembre->infoPseudo($newpseudo);
        header('Location: index.php?action=affProfil&id='.$_SESSION['id']);
    }

    public function updateMail($newmail) // uptate le mail
    
    {
        $test = new MembersManager();
        $testOk = $test->testMail($newmail);
        if ($testOk == 0)
        { // test pour ne pas avoir de mail en doublon
            $infosmembre = new MembersManager();
            $mailinfos = $infosmembre->infoMail($newmail);
            header('Location: index.php?action=affProfil&id='.$_SESSION['id']);
        }
    }

    public function updateMdp($newmdp) // update le motdepasse
    
    {
        $infosmembre = new MembersManager();
        $mdpinfos = $infosmembre->infoMdp($newmdp);
        header('Location: index.php?action=affProfil&id='.$_SESSION['id']);
    }

    public function getAvatar($newavatar) // update avatar
    
    {
        $membreManager = new MembersManager();
        $avatarinfos = $membreManager->infosAvatar($newavatar);
        throw new \Exception('Avatar modifié !');
    }

    public function userViewConnect() //dashboard rédac article user
    
    {
        require ('views/frontend/redacArticleUser.php');
    }

    public function redacArticlesUser($idRubrique, $idUser, $title, $content) // rédaction article user
    
    {
        $articleEdit = new ArticlesManager();
        $createarticle = $articleEdit->postArticlesUser($idRubrique, $idUser, $title, $content);

        if ($createarticle === false)
        {
            throw new \Exception('Impossible d \'ajouter un article...');
        }
        else
        {
            throw new \Exception('Article sauvegardé !');
        }
    }

    public function listArticlesUser($idRubrique) // liste des articles user + pagination
    
    {

        $pagination = new Pagination(); // nouvel objet de la class Pagination
        $articlesparp = 3; // nombre d'articles par page
        $nombredarticles = $pagination->getArticlesParRubriq(); // appel fonction pour récupérer le nombre d'articles par rubrique à paginer
        $totalpages = $pagination->getArticlesPages($nombredarticles, $articlesparp); // appel fonction pour récupérer le nombre de pages
        //tests url + si utilisateur injecte autre chose qu'un chiffre ou veux mette un chiffre plus grand que le nombre de pages, on retourne à la page courante cad la page 1
        if (isset($_GET['page']) and !empty($_GET['page']) and $_GET['page'] > 0 and $_GET['page'] <= $totalpages)
        {
            $_GET['page'] = intval($_GET['page']);
            $pageCourante = $_GET['page'];
        }
        else
        {
            $pageCourante = 1;
        }
        $depart = ($pageCourante - 1) * $articlesparp;

        $articlesManager = new ArticlesManager(); // nouvel objet de la class ArticlesManager
        $artic = $articlesManager->getArticlesUser($idRubrique, $depart, $articlesparp); //appel fonction pour récupérer données articles
        require ('views/frontend/listArticlesUser.php');

    }

    public function signalerArticleUser($articId) // signale un article
    
    {
        $commentManager = new ArticlesManager();
        $signal = $commentManager->signalement($articId);

        if ($signal === false)
        {

            throw new \Exception('Oups... Impossible de signaler cet article !');
        }
        else
        {

            throw new \Exception('Article signalé !<br><em>Un modérateur va controller l\'article que vous nous avez signalé dans les plus brefs délais,<br>merci :)');

        }
    }

    public function affArticle() // affiche un article et ses commentaires rattachés
    
    {
        $articlesManager = new ArticlesManager();
        $commentsManager = new CommentsManager();

        $artic = $articlesManager->getArticle($_GET['id']);
        $comments = $commentsManager->getComments($_GET['id']);

        require ('views/frontend/commentView.php');

    }

    public function addComment($idArticle, $idMembre, $content) //ajout commentaire
    
    {
        $commentsManager = new CommentsManager();
        $content = htmlspecialchars($content);
        $affectedLines = $commentsManager->postComment($idArticle, $_SESSION['id'], $content);

        if ($affectedLines === false)
        { //si le commentaire n'arrive pas à la bdd...
            throw new \Exception('Oups... Impossible d\'ajouter ce commentaire !'); // on arrête le script avec un die
            
        }
        else
        {
            header('Location: index.php?action=affArticle&id=' . $idArticle); // sinon on peut admirer son joli commentaire :)
            
        }
    }

    public function signalCommentUser($commentId) // signale un article
    
    {
        $commentManager = new CommentsManager();
        $signal = $commentManager->signalement($commentId);

        if ($signal === false)
        {
            throw new \Exception('Oups... Impossible de signaler ce commentaire !');
        }
        else
        {
            throw new \Exception('Commentaire signalé !<br><em>Un modérateur va controller le commentaire que vous nous avez signalé dans les plus brefs délais,<br>merci :)');

        }
    }

}

