<?php $title = 'Article à modifier(admin)'; ?>
<?php ob_start();

?>

<div class="vuChapComment">
	<div align="center">
		
		<p><a href="index.php?action=listArticlesAdmin">Retour liste articles</a></p><br>
		<?php
		while ($data = $artic->fetch())
		{
			?>
			<div class="news">

				<h3>Modifier article</h3>

				<form class="form"method="post" action="index.php?action=modifierArticle&amp;id=<?=$data['id'] ?>">
					<h4><em>Id : </em><?= $data['id'] ?></h4><br>
					<textarea type="text" name="title" rows="1" placeholder="title"><?=$data['title'] ?></textarea><br><br>
					<textarea class="mytextarea" name="content"  rows="5" cols="50" placeholder="content"><?=$data['content'] ?></textarea><br><br>
					<button type="submit" name="modifierArticle"class="btn btn-secondary">Modifier article</button><br>
				</form>

			</div>

			<?php
		}
		$artic->closeCursor();	
		?>
	</div>
	
</div>

<?php

?>
<?php $content = ob_get_clean(); ?>
<?php require('templateAdmin.php'); ?>
