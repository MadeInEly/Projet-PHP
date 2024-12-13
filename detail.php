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
  $numero = $_GET["numero"]; 
require_once('connexion.php');
  $stmt = $connexion->prepare("SELECT prenom,nom,l.isbn13,l.detail,l.photo from auteur a inner join livre l on (a.noauteur = l.noauteur) where nolivre = :numero "); 
  $stmt->bindValue(":numero", $numero);
  $stmt->setFetchMode(PDO::FETCH_OBJ);
  $stmt->execute();

while($enregistrement = $stmt->fetch())
{
echo 'Auteur : ' .$enregistrement->prenom. ' ' .$enregistrement->nom.  '<br> ';
echo 'ISBN13 : ' .$enregistrement->isbn13. '<br>';
echo 'Résumé du livre <br> <br>';
echo ' '.$enregistrement->detail. ' ';
}
?>
</div>
<div class="col-sm-3">
<?php
 $numero = $_GET["numero"]; 
 require_once('connexion.php');
 $stmt = $connexion->prepare("SELECT photo from livre where nolivre = :numero "); 
 $stmt->bindValue(":numero", $numero);
 $stmt->setFetchMode(PDO::FETCH_OBJ);
 $stmt->execute();

while($enregistrement = $stmt->fetch())
{
    echo '<img src="covers/'.$enregistrement->photo.'" alt="Image livre" width="300" height="500">';
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


