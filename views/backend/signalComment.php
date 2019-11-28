<?php $title = 'Commentaires Signalés(admin)'; ?>
<!--affichage liste des commentaires signalés-->
<?php ob_start(); ?>

<div>
   <br><br>
   <div align="center">
         <br>
         <h2>Commentaires signalés :</h2>
         <br>
         <a href="index.php?action=listArticlesAdmin">Retour liste articles</a><br>
         <a href="index.php?action=adminViewConnect">Retour rédac</a>
         <?php
            $data = $comments;
            while ($data = $comments->fetch()): ?> 
         <!--affiche le nom de l'auteur du commentaire, son id, la date et le commentaire-->
         <div class="encart">
            <br>
            <p><em>Commentaire signalé par : <?= $data['pseudo'] ?></em></p>
            <p><em>Id : <?= $data['id'] ?></em></p>
            <p><em>Le : <?= $data['comment_date_fr'] ?></em></p>
            <p><?= nl2br(htmlspecialchars($data['content'])) ?></p>
            <br>
            <a href="index.php?action=supprimerCommentaire&amp;id=<?=$data['id'] ?>"><button type="submit" name="supprimerCommentaire"class="btn btn-secondary">Supprimer le commentaire</button></a>
            <a href="index.php?action=designalCommentaire&amp;id=<?=$data['id'] ?>"><button type="submit" name="designalCommentaire" class="btn btn-secondary">Désignaler le commentaire</button></a><br><br>
         </div>
         <?php
            endwhile;
            $comments->closeCursor();
             ?>
      </div>
   </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('templateAdmin.php'); ?>