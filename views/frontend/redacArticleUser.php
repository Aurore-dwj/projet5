<?php $title = 'redaction des Articles User'; ?>
<?php ob_start(); 
?>
 <!--menu liens-->
<div>
  <div align="center"><br><br><br><br><br>
  <?php if(isset($_SESSION['id'])) { ?> 
   <h2>
    Bonjour 
    <?= $_SESSION['pseudo'];?>
  </h2>
   <a href="index.php">Accueil</a>
  <!--formulaire pour taper un nouvel article-->
  <h3>Rédaction Articles : </h3>
  
  <form class="form"method="post" action="index.php?action=redacArticlesUser&amp;id= ">
   <input type="text" placeholder="title" id="title" name="title" /><br><br><br>
   <textarea class="mytextarea" name="content"  rows="5" cols="50" placeholder="Votre message"></textarea><br>
    <button type="submit" name="envoi_article"class="btn btn-primary">Envoyer article !</button><br><br>
  </form>
  <?php 
  }else{
  echo '<h3 class="error">Pour l\'ajout d\'un commentaire, veuillez vous connecter !</h3><br><br><br><br>
  <p><a href="index.php">Retour accueil ?</a></p>
  <p><a href="index.php?action=displFormulContact">Pas encore insrit ?</a></p>
  <p><a href="index.php?action=displConnexion">Connexion ?</a></p'; 
  }

  ?>

</div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?> 