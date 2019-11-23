<?php $title = 'Affiche le profil'; ?>
<?php ob_start();?>

<div id= cont align="center"><br><br>
<a href="index.php">Accueil </a><br>
      <a href="index.php?action=affInfosUser"> Modifier mes infos perso </a><br><br>

   <div id="meteo" align="center">
      <h1>La météo du motard</h1><br><br><br>
      <i class="wi"></i><br><br>
      
      <h3>
         <span id="ville"></span>
      </h3><br>
         
   
      <p>Vent : <span id="vent"></span> Km/h</p>

      <p>Température : <span id="temperature"></span> C° </p>
      <p>Conditions : <span id="conditions"></span></p>
   </div>
   <div id="profil" align="center">  
      <h1>
         Profil
      </h1> 

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

   </div>
</div>

      <?php $content = ob_get_clean(); ?>
      <?php require('template.php'); ?>