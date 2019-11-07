<?php $title = 'Formulaire inscription'; ?>
<?php ob_start();?>
<div align="center">
    <a href="index.php">Retour accueil</a>
    <br>
    <br>
    <form action="index.php?action=addMember" method="POST">
        <table>
            <tr>
                <td align="right">
                    <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />
                    <br>
                </td>
            </tr>
            <td align="right">
                <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
                <br>
            </td>
        </tr>
        <tr>
            <td align="right">
                <input type="password" placeholder="Entrez un mot de passe" id="mdp" name="mdp" />
                <br>
                <br>
            </td>
        </tr>
        <tr>
            <td align="right">
                <button type="submit"name="addMember"class="btn btn-secondary">Je veux créer mon compte !</button>
                <br>
                <br>
            </td>
        </tr>
    </table>
</form>
</div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
