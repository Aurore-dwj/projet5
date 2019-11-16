<?php $title = 'redaction des Articles(admin)'; ?>
<?php ob_start(); 
?>
 <!--menu liens-->
<div><br><br><br>
  <div align="center">
   <h2>Bonjour cher admin</h2><br/>
   <h3><a href="index.php">Accueil</a></h3>
   <h3><a href="index.php?action=listArticlesAdmin">Articles</a></h3>
   <h3><a href="index.php?action=getArticlesAdmin&amp;signalement=1">Articles signalés</a></h3>
   <h3><a href="index.php?action=signalArticle&amp;signalement=1">Commentaires signalés</a></h3>
   <br/>
   <!--formulaire pour taper un nouvel article-->
  <h3>Rédaction Articles : </h3>

  <form class="form"method="post" action="index.php?action=redacArticles&amp;id= ">
   <input type="text" placeholder="title" id="title" name="title" /><br><br><br>
   <textarea class="mytextarea" name="content"  rows="5" cols="50" placeholder="Votre message"></textarea><br>
   <button type="submit" name="envoi_article"class="btn btn-primary">Envoyer article !</button><br><br>
 </form>

</div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('templateAdmin.php'); ?> 