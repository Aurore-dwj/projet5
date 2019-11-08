<?php $title = 'Affiche le profil'; ?>
<?php ob_start();?>

<div class="vuChapComment">
         <div align="center">
         	<a href="index.php">Accueil </a>
         	<a href="index.php?action=displFotoProfil">Modifier photo de profil </a>
            <h2>Connecté!</h2>
            <br/>
            <br/>
            <p>
               Bonjour  
               <?php echo $_SESSION['pseudo']; ?>
            </p>
            


<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>