<?php $title = 'Articles Signalés(admin)'; ?>
<!--affichage liste des commentaires signalés-->
<?php ob_start();

?>
<div>
	<div align="center">
    <div><br><br><br>
      <h2>Commentaires signalés :</h2><br>
      <a href="index.php?action=listArticlesAdmin">Retour liste articles</a><br>
      <a href="index.php?action=adminViewConnect">Retour rédac</a>
      
      <?php
      $data = $comments;
    while ($data = $comments->fetch())
    {
       ?> <!--affiche l'id de auteur la date et le commentaire-->
        <div class="news"><br>
         <p><em>Id : <?= $data['id'] ?></em></p>
         <p><em>Le : <?= $data['comment_date_fr'] ?></em></p>
       
         <p><?= nl2br(($data['content'])) ?></p><br>
         <a href="index.php?action=supprimerCommentaire&amp;id=<?=$data['id'] ?>"><button type="submit" name="supprimerCommentaire"class="btn btn-secondary">Supprimer le commentaire</button></a>
         <a href="index.php?action=designalCommentaire&amp;id=<?=$data['id'] ?>"><button type="submit" name="designalCommentaire" class="btn btn-secondary">Désignaler le commentaire</button></a><br><br>
       </div>
       <?php
    }
   $comments->closeCursor();
     ?>
   </div>
 </div>
</div>

<?php

?>
<?php $content = ob_get_clean(); ?>
<?php require('templateAdmin.php'); ?>