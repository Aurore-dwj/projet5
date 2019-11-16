<?php $title = 'Articles Signalés(admin)'; ?>
<!--affichage liste des commentaires signalés-->
<?php ob_start();

?>
<div>
	<div align="center">
    <div><br>
      <h2>Articles signalés :</h2><br>
      <a href="index.php?action=listArticlesAdmin">Retour vers les chapitres</a>
      
      <?php
      $data = $artic;
     while ($data = $artic->fetch())
    {
        ?> <!--affiche l'id de auteur la date et le commentaire-->
        <div class="news"><br>
         <p><em>Id : <?= $data['id'] ?></em></p>
         <p><em>Le : <?= $data['creation_date_fr'] ?></em></p>
          <p><em><?= $data['title'] ?></em></p>
         <p><?= nl2br(($data['content'])) ?></p><br>
         <a href="index.php?action=supprimerArticle&amp;id=<?=$data['id'] ?>"><button type="submit" name="supprimerArticle"class="btn btn-secondary">Supprime ton commentaire !</button></a>
         <a href="index.php?action=designalArticle&amp;id=<?=$data['id'] ?>"><button type="submit" name="designalArticle" class="btn btn-secondary">Désignale ce commentaire !</button></a><br><br>
       </div>
       <?php
     }
     $artic->closeCursor();
     ?>
   </div>
 </div>
</div>

<?php

?>
<?php $content = ob_get_clean(); ?>
<?php require('templateAdmin.php'); ?>