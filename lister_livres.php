<?php
// Démarrage de la session
session_start();



// UC5 : Voir panier.
// NE PAS OUBLIER DE FAIRE DEMARRAGE SESSION POUR LE 20/12 ¤¤¤¤¤¤¤¤¤¤

// Démarrage de la session

// session_start();

// vérification si l'utilisateur est co

//if (!isset($_SESSION['connecte']) || $_SESSION['connecte'] !== true) {

  //  echo '<div style="color: red;">Accès refusé. Veuillez vous connecter.</div>';

//    exit;

//}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bibliotheque</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php include ('entete.php');?>
<br>
<br>
<div class="col-sm-9">
<?php


require_once('connexion_bibliodrive.php');

$auteur = isset($_GET['nmbr']) ? '%' . $_GET['nmbr'] . '%' : '%';


$stmt = $connexion->prepare("SELECT nolivre, titre, anneeparution, auteur.nom, photo FROM livre INNER JOIN auteur ON (auteur.noauteur = livre.noauteur) WHERE nom like :auteur");

$stmt->bindValue(":auteur", $auteur);
$stmt->setFetchMode(PDO::FETCH_OBJ);

// Les résultats retournés par la requête seront traités en 'mode' objet

$stmt->execute();

 



while ($enregistrement = $stmt->fetch()) {
  echo "<a href='http://localhost/projet-php/detail.php?numero=" . $enregistrement->nolivre . "'>" . 
       $enregistrement->titre . " - " . $enregistrement->anneeparution . 
       "<br></a>";
}


   
?>
</div>
    </div>
    <div class="col-sm-3">
        <img src="librairie.png" width="300px" height="350px">
        <?php include ('authentification.php');?>   <!-- Inclure pour la connexion -->
      </div>
  </div>
</body>
</html>
