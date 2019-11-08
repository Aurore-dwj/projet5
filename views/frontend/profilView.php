<?php $title = 'Photo du profil'; ?>
<?php ob_start();?>

<div class="vuChapComment">
  <div align="center">
    <a href="index.php">Retour à l'acceuil</a>
    <h2>Ajouter une photo de profil:</h2><br/><br/>

    <form method="POST" action="" enctype="multipart/form-data">
        <table>
            <tr>  
                <td align="center">
                    <label>Ajouter photo de profil :</label>
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
                    <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $_SESSION['pseudo']; ?>" />
                </td>
            </tr>

            <tr>
                <td align="right">
                    <label>Mot de passe :</label>
                </td>
                <td>
                    <input type="password" name="newmdp1" placeholder="Mot de passe"/>
                </td>
            </tr>

            <tr>
                <td></td>
                <td align="left">
                    <br/>     
                    <button type="submit"value="Mise à jour profil"class="btn btn-secondary">J'enregistre ma photo!</button>
                </td>
            </tr>
        </table>
    </form>
</div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
