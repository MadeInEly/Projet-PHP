<?php
// Démarrage de la session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bibliothèque</title>
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
<br><br>
<div class="row">
  <div class="col-sm-9">
    <?php
    $numero = $_GET["numero"]; 
    require_once('connexion.php');

    // Récupérer les détails du livre
    $stmt = $connexion->prepare("SELECT prenom, nom, l.isbn13, l.detail, l.photo, l.disponible FROM auteur a INNER JOIN livre l ON (a.noauteur = l.noauteur) WHERE nolivre = :numero");
$stmt->bindValue(":numero", $numero);
$stmt->setFetchMode(PDO::FETCH_OBJ);
$stmt->execute();

while ($enregistrement = $stmt->fetch()) {
    echo '<h3>' . htmlspecialchars($enregistrement->prenom) . ' ' . htmlspecialchars($enregistrement->nom) . '</h3>';
    echo '<p>ISBN13 : ' . htmlspecialchars($enregistrement->isbn13) . '</p>';
    echo '<h4>Résumé du livre</h4>';
    echo '<p>' . htmlspecialchars($enregistrement->detail) . '</p>';

    if (isset($_SESSION['connecte']) && $_SESSION['connecte'] === true) {
        if ($enregistrement->disponible) {
            echo '<p style="color: green;">Disponible</p>';
            echo '<a href="detail.php?numero=' . $numero . '&action=emprunter" class="btn btn-primary">Emprunter</a>';
        } else {
            echo '<p style="color: red;">Indisponible</p>';
        }
    } else {
        echo '<p>Connectez-vous pour voir la disponibilité.</p>';
    }
}


    //  clic pour emprunter
    if (isset($_GET['action']) && $_GET['action'] === 'emprunter') {
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = []; // initialiser le panier vide
        }

        // Ajouter le numéro du livre au panier
        if (!in_array($numero, $_SESSION['panier'])) {
            $_SESSION['panier'][] = $numero;
            echo '<div class="alert alert-success mt-3">Livre ajouté !</div>';
        } else {
            echo '<div class="alert alert-warning mt-3">le livre déjà dans ton panier</div>';
        }
    }
    ?>
    <?php
    // Récupérer et afficher la couverture du livre
    $stmt = $connexion->prepare("SELECT photo FROM livre WHERE nolivre = :numero"); 
    $stmt->bindValue(":numero", $numero);
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    $stmt->execute();

    while ($enregistrement = $stmt->fetch()) {
        echo '<img src="covers/' . htmlspecialchars($enregistrement->photo) . '" alt="Image livre" class="img-fluid">';
    }
    ?>
  </div>
  <div class="col-sm-3">
    <img src="librairie.png" width="300px" height="350px">
    <?php include('authentification.php'); ?> <!-- Inclure pour la connexion -->
  </div>
</div>
</body>
</html>
