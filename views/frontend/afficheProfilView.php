<?php $title = 'Affiche le profil'; ?>
<?php ob_start();?>

<div class="vuChapComment">
         <div align="center">
            <a href="index.php">Accueil </a><br>
         	<a href="index.php?action=affInfosUser"> Modifier mes infos perso </a><br><br>
         
            
            <?php
            $data = $allinfos;
            ?>
            <h2>
               Bonjour  
               <?= $data['pseudo']; ?>
            </h2>
            <br>
            <?php
            if(!empty($data['avatar'])){
               ?>
            
            <img class="improfil" width="100" src="publics/membres/avatars/<?= $data['avatar']; ?>"/>
             <?php
         }
         ?>
            <br />
            <p>
               Pseudo : <?= $data['pseudo']; ?><br>
               Mail : <?= $data['mail']; ?>
            </p>
            


<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>