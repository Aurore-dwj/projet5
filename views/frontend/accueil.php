<?php $title = 'Accueil'; ?>
<?php ob_start(); ?>
<nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
   <?php if(isset($_SESSION['pseudo'])) : ?>
   <span id="bonjSession">
   Bonjour
   <?= $_SESSION['pseudo'];?>
   </span>
   <?php else: ?>
   <span id="bonjSession">Bonjour</span>
   <?php endif ?>
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault"aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
   <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
         <li class="nav-item active">
            <a class="nav-link" href="index.php">
            <span>
            <i class="fa fa-home"></i>
            Accueil
            <span class="sr-only">(current)</span>
            </a>
         </li>
         <?php if(isset($_SESSION['pseudo'])) : ?>
         <li class="nav-item"><a class="nav-link" href="index.php?action=affProfil&amp;id=<?=$_SESSION['id'] ?>">Profil</a></li>
         <li class="nav-item"><a class="nav-link" href="index.php?action=deconnexion">Déconnexion</a></li>
         <?php if($_SESSION['droits'] == 1) : ?>
         <li class="nav-item">
            <a class="nav-link" href="index.php?action=adminViewConnect">Admin</a>
            <?php endif ?>
            <?php else: ?>
         <li class="nav-item"><a class="nav-link" href="index.php?action=displConnexion">Connexion</a></li>
         <li class="nav-item"><a class="nav-link" href="index.php?action=displFormulContact">Créer un compte</a></li>
         <?php endif ?>
      </ul>
      <form class="form-inline my-2 my-lg-0">
         <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
         <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
   </div>
</nav>
<main role="main">
   <div class="jumbotron">
      <div class="container">
         <h1 class="titre1">Yamaha 1300XJR une moto de légende...</h1>
         <h5 class="titre2">Ce gros roaster au catalogue depuis plus de 20 ans méritait bien un petit blog...</h5>
         <p>
            <a class="btn btn-secondary btn-lg" href="index.php?action=userViewConnect" role="button">Publier un article</a>
         </p>
      </div>
   </div>
   <div class="container">
      <div class="row">
         <div class="col-md-4">
            <h2 >Histoire</h2>
            <p>
               Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.
            </p>
            <p>
               <a class="btn btn-secondary" href="index.php?action=listArticlesUser&amp;id_rubrique=1" role="button">Articles</a>
            </p>
         </div>
         <div class="col-md-4">
            <h2>Caractère</h2>
            <p>
               Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.
            </p>
            <p>
               <a class="btn btn-secondary" href="index.php?action=listArticlesUser&amp;id_rubrique=2" role="button">Articles</a>
            </p>
         </div>
         <div class="col-md-4">
            <h2>Entretien</h2>
            <p>
               Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper.
            </p>
            <p>
               <a class="btn btn-secondary" href="index.php?action=listArticlesUser&amp;id_rubrique=3" role="button">Articles</a>
            </p>
         </div>
      </div>
   </div>
</main>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>

