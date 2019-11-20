<?php $title = 'Affiche le profil'; ?>
<?php ob_start();?>

<div class="vuChapComment">

   <div align="center">
      <h1>La météo du motard</h1>
      <i class="wi"></i><br>
      <a href="index.php">Accueil </a><br>
      <a href="index.php?action=affInfosUser"> Modifier mes infos perso </a><br><br>
      <h3>
         <span id="ville"></span>
      </h3><br>

      <h3>
         <span id="temperature"></span> C° (<span id="conditions"></span>)
      </h3>
      <h2>
         Profil
      </h2> 

      <?php
      $data = $allinfos;
      ?>
      <p>
         Bonjour  
         <?= $data['pseudo']; ?>
      </p>
      
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