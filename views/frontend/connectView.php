<?php $title = 'connexion'; ?>
<?php ob_start(); 
?>

<div class="vuChapComment">
   <div align="center">
      <a href="index.php">Retour à la page d'accueil</a><br>
      <h2>Connexion</h2>
      <br /><br />
      <form method="POST" action="index.php?action=connexion" method="POST">
         <input type="text" name="pseudo" placeholder="pseudo" />
         <input type="password" name="mdp" placeholder="Mot de passe" />
         <br /><br />
         <button type="submit"name="connexion"class="btn btn-secondary">Je me connecte!</button>
      </form>
   </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?> 