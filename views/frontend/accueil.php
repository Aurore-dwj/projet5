<?php $title = 'Accueil'; ?>
<?php ob_start();?>
  
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
  <span id="bonjSession">Bonjour</span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#"><span><i class="fa fa-home"></i> Accueil <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Météo</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Connexion</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Créer un compte</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      
      <h1 class="titre">Yam 1300XJR une bécane de légende...</h1>
      <h5 class="titre">Ce gros roaster au catalogue Yamaha depuis plus de 20 ans méritait bien un petit blog...</h5>
      <p><a class="btn btn-secondary btn-lg" href="#" role="button">Dernier article publié</a></p>
    </div>
  </div>

  <div class="container">
    <!-- Example row of columns -->
    <div class="row">
      <div class="col-md-4">
        <h2 >Histoire</h2>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh. </p>
        <p><a class="btn btn-secondary" href="views/frontend/listArticlesHistoire.php" role="button">Articles</a></p>
      </div>
      <div class="col-md-4">
        <h2>Caractère</h2>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh. </p>
        <p><a class="btn btn-secondary" href="views/frontend/listArticlesCaracteres.php" role="button">Articles</a></p>
      </div>
      <div class="col-md-4">
        <h2>Entretien</h2>
        <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. </p>
        <p><a class="btn btn-secondary" href="views/frontend/listArticlesEntretien.php" role="button">Articles</a></p>
      </div>
    </div>

    <hr>

  </div> <!-- /container -->

</main>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>

