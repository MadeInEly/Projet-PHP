</body>
</html>
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
<?php include ('entete.html');?>  <!-- Inclure le carouseul d'image --> 
<br>
<br>
<div class="col-sm-9">
<?php
$auteur=$_GET["nmbr"];
require_once('connexion_bibliodrive.php');

$stmt = $connexion->prepare("SELECT nolivre, titre, anneeparution, auteur.nom, photo FROM livre INNER JOIN auteur ON (auteur.noauteur = livre.noauteur) WHERE nom like :auteur");

$stmt->bindValue(":auteur", $auteur);
$stmt->setFetchMode(PDO::FETCH_OBJ);

// Les résultats retournés par la requête seront traités en 'mode' objet

$stmt->execute();

 

// Parcours des enregistrements retournés par la requête : premier, deuxième…

while ($enregistrement = $stmt->fetch())
 {
  echo "<a href='http://localhost/biblio/detail.php?numero=".$enregistrement->nolivre."'>", $enregistrement->titre, $enregistrement->anneeparution,"<br></a></h1>";
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

