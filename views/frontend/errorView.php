<?php $title = 'error'; ?>
<?php ob_start();?>
  
  
 
 <div class=".row-md-3">
        <div class=".col-md-3">
          <div align="center">
           
          
           <div align="center"><a href="index.php">Retour accueil</a></div><br>
          <div class="card mb-3 shadow-sm">

            <svg class="bd-placeholder-img card-img-top" width="100%" height="75" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Error</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">NOTIFICATION !</text></svg>
            <div class="card-body">

              <p class="card-text"> <?= $errorMessage ?></p>
            
              </div>
            </div>
          </div>
        </div>
      </div>
  
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>