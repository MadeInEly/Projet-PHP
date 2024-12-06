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

    <div class="col-sm-3">
        <img src="librairie.png" width="300px" height="350px">
        <?php include ('authentification.php');?>   <!-- Inclure pour la connexion -->
      </div>
  </div>
<?php 
$auteur = $_POST["submit"];
require_once('bibliotheque.php');

$stmt = $connexion->prepare("SELECT * FROM utilisateur");

$stmt->setFetchMode(PDO::FETCH_OBJ);

// Les résultats retournés par la requête seront traités en 'mode' objet

$stmt->execute();

 

// Parcours des enregistrements retournés par la requête : premier, deuxième…

while($enregistrement = $stmt->fetch())

{

  // Affichage des champs nom et prenom de la table 'utilisateur'

  echo '<h1>', $enregistrement->nom, ' ', $enregistrement->prenom,' ', $enregistrement->mot_de_passe,'</h1>';

}

?>
</body>
</html>