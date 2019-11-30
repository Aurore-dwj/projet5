<?php $title = 'Photo du profil'; ?>
<?php ob_start(); ?>

<div>
   <div align="center">
      <a href="index.php">Retour à l'acceuil</a>
      <h2>Mettre à jour mes infos</h2>
      <br/><br/>
      <?php
         $data = $allinfos;
         
         ?>
      <form method="POST" action="index.php?action=getAvatar" enctype="multipart/form-data">
         <table>
            <tr>
               <td align="center">
                  <label>Ajouter une photo de profil : </label>
               </td>
               <td>
                  <input type="file" name="avatar"><br>
                  <a href="index.php?action=getAvatar&amp;id=<?=$_SESSION['id'] ?>"><button type="submit" name="getAvatar"class="btn btn-secondary">Ajouter une photo</button></a><br><br>
               </td>
            </tr>
         </table>
      </form>
      <form method="POST" action="index.php?action=updateUserPseudo">
         <table>
            <tr>
               <td align="right">
                  <label>Pseudo :</label>
               </td>
               <td><br>
                  <input type="text" name="newpseudo" placeholder="Pseudo" value="<?= $data['pseudo']; ?>" />
                  <a href="index.php?action=updateUserPseudo&amp;id=<?=$_SESSION['id'] ?>"><button type="submit" name="updateUserPseudo"class="btn btn-secondary">Je modifie mon Pseudo</button></a><br><br>
               </td>
            </tr>
         </table>
      </form>
      <form method="POST" action="index.php?action=updateUserMail">
         <table>
            <td align="right">
               <label>Mail :</label>
            </td>
            <td><br>
               <input type="text" name="newmail" placeholder="Mail" value="<?= $data['mail']; ?>" />
               <a href="index.php?action=updateUserMail&amp;id=<?=$_SESSION['id'] ?>"><button type="submit" name="updateUserMail"class="btn btn-secondary">Je modifie mon Mail</button></a><br><br>
            </td>
            </tr>
         </table>
      </form>
      <form method="POST" action="index.php?action=updateUserMdp">
         <table>
            <tr>
               <td align="right">
                  <label>Mot de passe :</label>
               </td>
               <td><br>
                  <input type="password" name="newmdp" placeholder="Mot de passe"/>
                  <a href="index.php?action=updateUserMdp&amp;id=<?=$_SESSION['id'] ?>"><button type="submit" name="updateUserMdp"class="btn btn-secondary">Je modifie mon Mot de passe</button></a><br><br>
               </td>
            </tr>
            <tr>
         </table>
      </form>
   </div>
</div>
   

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
