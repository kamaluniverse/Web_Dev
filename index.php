<?php

include 'libs/load.php';

?>
<!doctype html>
<html lang="en">

  <body>
    
<?php 
 load_template('_header');
 ?>

<main>

<?php load_template('_calltoaction'); ?>

 <?php load_template('_photopost'); ?>
</main>

<?php 
  load_template('footer');
  ?>

    <script src="../app/assets/dist/js/bootstrap.bundle.min.js"></script>

      
  </body>
</html>
