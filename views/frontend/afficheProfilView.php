<?php $title = 'Affiche le profil'; ?>
<?php ob_start();?>

<div class="vuChapComment">
         <div align="center">
            <a href="index.php">Accueil </a><br>
         	<a href="index.php?action=affInfosUser"> Modifier mes infos perso </a>
            <h2>Connecté!</h2>
            <br/>
            <br/>

            <?php
            $data = $allinfos;
            ?>
            <p>
               Pseudo : <?php echo $data['pseudo']; ?><br>
               Mail : <?php echo $data['mail']; ?>
            </p>
            


<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>