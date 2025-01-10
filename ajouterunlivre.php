
<?php session_start();
//$stmt = $connexion->prepare("SELECT noauteur, nom, prenom FROM auteur"); // Prépare la requête
//$stmt->setFetchMode(PDO::FETCH_OBJ); // prendre le resultat pour un objet
//$stmt->execute();
//$auteurs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
<title>Bibliothèque</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
<div class="col-sm-9">
<?php
if (isset($_SESSION['profil']) && $_SESSION['profil'] === 'admin') {
    include('enteteadmin.php'); // Inclure entête pour les admin
} else {
    include('entete.php'); // Inclure l'entête normal pour le reste
}


?>

<div class="container-fluid"> <!-- Pour bien ranger  -->  
    <div class="row">
        <div class="col-md-9">
            <h2 class="text-center" style="color: purple">Ajouter un livre</h2>
            <form  method="POST" class="p-3 border border-2">
                
                <div class="mb-3 row">
                    <label for="titre" class="form-label col-sm-2 col-form-label">Titre :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="isbn" class="form-label col-sm-2 col-form-label">ISBN13 :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="isbn" name="isbn" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="annee" class="form-label col-sm-2 col-form-label">Année de production :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="annee" name="annee" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="resume" class="form-label col-sm-2 col-form-label">Résumé :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="resume" name="resume" required></textarea>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="image" class="form-label col-sm-2 col-form-label">Image :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="image"  name="image" required>
                    </div>
                </div>

                <!-- menu qui déroule avec les auteurs -->
                <div class="mb-3 row">
                    <label for="auteur" class="form-label col-sm-2 col-form-label">Auteur :</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="auteur" name="auteur" required>
                        <?php
require_once 'connexion.php'; // Inclure la connexion bd
try {
    $stmt = $connexion->prepare("SELECT noauteur, nom, prenom FROM auteur"); // Prépare la requête
    $stmt->execute(); // va executer le truc au dessus
    $auteurs = $stmt->fetchAll(PDO::FETCH_OBJ); // Récupère tt les résult
    foreach ($auteurs as $auteur) { // pour que mon code regarde tt les auteurs dans la base de donnees
        echo "<option value='{$auteur->noauteur}'>{$auteur->prenom} {$auteur->nom}</option>"; // je vais afficher le nom le prenom et le num de l'auteur
    }
} catch (PDOException $e) { // si ya une erreur je vais afficher la ligne en dessous
    echo "<option style='color:red;' disabled>Impossible de charger les auteurs</option>";
}
?>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mx-auto d-block">Ajouter livre</button>
            </form>
        </div>

        <div class="col-sm-3">
            <img src="librairie.png" width="300px" height="350px">
            <?php include ('authentification.php'); ?> <!-- Inclure pour la connexion -->
        </div>
    </div>
</div>
</body>
</html>
