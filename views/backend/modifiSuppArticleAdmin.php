<?php $title = 'Articles à modifier(admin)'; ?>
<?php ob_start();

?>

<div>
	<div align="center">
	
		<p><a href="index.php?action=listArticlesAdmin">Retour à la liste des articles</a></p><br>
		<?php
		while ($data = $article->fetch())
		{
			?>
			<div class="news">

				<h3>Modifier ou supprimer un article</h3>

				<form class="form"method="post" action="index.php?action=modifChapitre&amp;id=<?=$data['id'] ?>">
					<h4><em>Id : </em><?= $data['id'] ?></h4><br>
					<textarea type="text" name="title" rows="1" placeholder="title"><?=$data['title'] ?></textarea><br><br>
					<textarea class="mytextarea" name="content"  rows="5" cols="50" placeholder="content"><?=$data['content'] ?></textarea><br><br>
					<button type="submit" name="modifbillet"class="btn btn-secondary">Modifier article!</button><br>
					<a href="index.php?action=supprimArticle&amp;id=<?=$data['id'] ?>"><button type="submit"class="btn btn-secondary">Supprimer article !</button></a>
				</form>

			</div>

			<?php
		}
		$article->closeCursor();	
		?>
	</div>
	
</div>

<?php

?>
<?php $content = ob_get_clean(); ?>
<?php require('adminTemplate.php'); ?>
