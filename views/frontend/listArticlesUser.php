<?php $title = 'Liste des articles '; ?>
<?php ob_start();?>
  
  <div class="collapse bg-dark" id="navbarHeader">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-md-7 py-4">
          <h4 class="text-white">A propos</h4>
          <p class="text-muted">Site réalisé dans le cadre d'une formation de developeur web junior Openclassrooms</p>
        </div>
        <div class="col-sm-4 offset-md-1 py-4">
          <h4 class="text-white">Catégories</h4>
          <ul class="list-unstyled">
            <li><a href="index.php?action=listArticlesUser&amp;id_rubrique=1" class="text-white">Histoire</a></li>
            <li><a href="index.php?action=listArticlesUser&amp;id_rubrique=2" class="text-white">Caractère</a></li>
            <li><a href="index.php?action=listArticlesUser&amp;id_rubrique=3" class="text-white">Entretien</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container d-flex justify-content-between">
      <a href="#" class="navbar-brand d-flex align-items-center">
        <?php
$data = $artic;
   while ($data = $artic->fetch())
   {

    ?>  
        <strong>Catégorie : <?= $data['libele'] ?></strong>
      </a>
      <?php  if(isset($_SESSION['id'])) : ?> 
      <a href="index.php?action=userViewConnect">Retour rédac</a>&nbsp;&nbsp;
      <a href="index.php">Retour accueil</a>
      <?php else: ?>
       <a href="index.php">Retour accueil</a>
       <?php endif ?>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
</header>

<div class=".row-md-3">
        <div class=".col-md-3">
          <div class="card mb-3 shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="75" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>liste articles user</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em"><?=($data['title']) ?></text></svg>
            <div class="card-body">
              <p class="card-text"> <?= nl2br($data['content']) ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="index.php?action=articleSignale&amp;id=<?= $data['id'] ?>"><button type="button" class="btn btn-sm btn-outline-secondary">Signaler</button></a>
                  <a href="index.php?action=affArticle&amp;id=<?= $data['id'] ?>"><button type="button" class="btn btn-sm btn-outline-secondary">Commentaires</button></a>
                </div>
                <small class="text-muted"><em>le <?= $data['creation_date_fr'] ?></em></small>
                <small class="text-muted"><em>De la part de : <?= $data['pseudo'] ?></em></small>
              </div>
            </div>
          </div>
        </div>
      </div>
    
       
  <?php
}
$artic->closeCursor(); 
 ?>

<div align="center">
<?php

      for($i=1;$i<=$totalpages;$i++) {
         if($i == $pageCourante) {
          echo $i.'&nbsp;&nbsp;';
         } else {
            echo '<a href="index.php?action=listArticlesUser&amp;id_rubrique='.$_GET['id_rubrique'].'&amp;page='.$i.'"> '.$i.'</a>&nbsp;&nbsp;';
         }
      }
      ?>

</div>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>

