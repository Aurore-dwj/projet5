<?php $title = 'Photo du profil'; ?>
<?php ob_start();

?>

<div class="vuChapComment">
  <div align="center">
    <a href="index.php">Retour à l'acceuil</a>
    <h2>Mettre à jour mes infos</h2><br/><br/>
<?php

$data = $allinfos;

  
 ?>


    <form method="POST" action="index.php?action=affInfosUser" enctype="multipart/form-data">
        <table>
            <tr>  
                <td align="center">
                    <label>Ajouter une photo de profil: :</label>
                </td>
                <td>
                    <input type="file" name="avatar"><br>
                </td>
            </tr>

            <tr>
                <td align="right">
                    <label>Pseudo :</label>
                </td>
                <td>
                    <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php  echo $data['pseudo']; ?>" />
                </td>
            </tr>

            <td align="right">
                    <label>Mail :</label>
                </td>
                <td>
                    <input type="text" name="newmail" placeholder="Mail" value="<?php echo $data['mail']; ?>" />
                </td>
            </tr>

            <tr>
                <td align="right">
                    <label>Mot de passe :</label>
                </td>
                <td>
                    <input type="password" name="newmdp" placeholder="Mot de passe"/>
                </td>
            </tr>
        
            <tr>
                <td></td>
                <td align="left">
                    <br/>     
                    <button type="submit"value="Mise à jour profil"class="btn btn-secondary">Je mets à jour mes infos !</button>
                </td>
            </tr>
        </table>
    </form>



</div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
