<?php $title = 'redaction des Articles User'; ?>
<?php ob_start(); 
?>
 <!--menu liens-->
<div>
  <div align="center">
   <h3>Connecté!</h3><br/><br/>
   <h2>
    Bonjour 
    <?= $_SESSION['pseudo'];?>
  </h2>
   <h3><a href="index.php">Accueil</a></h3>
  
  
   <!--formulaire pour taper un nouvel article-->
  <h3>Rédaction Articles : </h3>

  <form class="form"method="post" action="index.php?action=redacArticlesUser&amp;id= ">
   <input type="text" placeholder="title" id="title" name="title" /><br><br><br>
   <textarea class="mytextarea" name="content"  rows="5" cols="50" placeholder="Votre message"></textarea><br>
   <button type="submit" name="envoi_article"class="btn btn-primary">Envoyer article !</button><br><br>
 </form>

</div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?> 