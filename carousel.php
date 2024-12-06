<?php
require_once('connexion.php');
$stmt = $connexion->prepare("SELECT photo FROM livre ORDER BY dateajout DESC LIMIT 3");
$stmt->setFetchMode(PDO::FETCH_OBJ);
$stmt->execute();
?>
<!-- Carousel -->

<?php 
echo '<div id="demo" class="carousel slide" data-bs-ride="carousel">

  <!-- Indicators/dots -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
  </div>
  
  <!-- The slideshow/carousel -->
  <div class="carousel-inner">';
  $x = 0;
    while ($enregistement = $stmt->fetch() ) {
    if ( $x == 0 ) {
            echo '<div class="carousel-item active">
            <img src="covers/'.$enregistement->photo.'" alt="Image" class="d-block mx-auto" style="width:25%; height:auto;">
            </div>';
            $x += 1; 
        } else {
            echo '<div class="carousel-item">
            <img src="covers/'.$enregistement->photo.'" alt="Image" class="d-block mx-auto" style="width:25%; height:auto;">
          </div>';
        }
    }
?>
  <!-- Left and right controls/icons -->
  <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<div class="container-fluid mt-3">
  <h5 class="text-center">(Carousel)</h5>
</div>
