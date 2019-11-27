<?php $title = 'Articles Signalés(admin)'; ?>
<!--affichage liste des commentaires signalés-->
<?php ob_start(); ?>

<div>
   <div align="center">
      <div>
         <br><br><br>
         <h2>Articles signalés :</h2>
         <br>
         <a href="index.php?action=listArticlesAdmin">Retour liste articles</a><br>
         <a href="index.php?action=adminViewConnect">Retour rédac</a>
         <?php
            $data = $artic;
            while ($data = $artic->fetch()): ?> 
         <!--affiche l'id du signaleur, son pseudo, et la date -->
         <div class="encart">
            <br>
            <p><em>Article signalé par : <?= $data['pseudo'] ?></em></p>
            <p><em>Id : <?= $data['id'] ?></em></p>
            <p><em>Le : <?= $data['creation_date_fr'] ?></em></p>
            <p><em><?= $data['title'] ?></em></p>
            <p><?= nl2br($data['content']) ?></p>
            <br>
            <a href="index.php?action=supprimerArticle&amp;id=<?=$data['id'] ?>"><button type="submit" name="supprimerArticle"class="btn btn-secondary">Supprimer article !</button></a>
            <a href="index.php?action=designalArticle&amp;id=<?=$data['id'] ?>"><button type="submit" name="designalArticle" class="btn btn-secondary">Désignaler article !</button></a><br><br>
         </div>
         <?php endwhile;
            $artic->closeCursor();
            ?>
      </div>
   </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('templateAdmin.php'); ?>