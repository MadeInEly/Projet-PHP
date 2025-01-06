<?php
// Démarrage de la session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Biblioteque</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php
if (isset($_SESSION['profil']) && $_SESSION['profil'] === 'admin') {
    include('enteteadmin.php'); // Inclure entête pour les admin
} else {
    include('entete.php'); // Inclure l'entête normal pour le reste
}
?>

<br>
<br>
<div class="text-center">
<h4 class="text-center"><b>Dernières acquisitions</b></h4>
</div>
  <?php include ('carousel.php');?>  <!-- Inclure le carouseul d'image --> 
  </div>
    </div>
    <div class="col-sm-3">
        <img src="librairie.png" width="300px" height="350px">
        <?php include ('authentification.php');?>   <!-- Inclure pour la connexion -->
      </div>
  </div>
</body>
</html>