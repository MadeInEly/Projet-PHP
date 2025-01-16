<?php session_start();
require_once 'connexion.php';
?>
<?php
if (!isset($_SESSION['profil']) && $_SESSION['profil'] === 'admin') {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<title>Bibliotheque</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
            <div class="col-sm-9 order-sm-1">
<?php
if (isset($_SESSION['profil']) && $_SESSION['profil'] === 'admin') {
    include('enteteadmin.php'); // Inclure entête pour les admin
} else {
    include('entete.php'); // Inclure l'entête normal pour le reste
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <h2 class="text-center">Créer un utilisateur</h2>

            <form action="creerunmembre.php" method="POST" class="p-3 border border-2">
                <div class="mb-3 row">
                    <label for="mel" class="form-label col-sm-2 col-form-label">Mail</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="mel" name="mel" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="motdepasse" class="form-label col-sm-2 col-form-label">Mot de Passe</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="motdepasse" name="motdepasse" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="nom" class="form-label col-sm-2 col-form-label">Nom</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="prenom" class="form-label col-sm-2 col-form-label">Prénom</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="adresse" class="form-label col-sm-2 col-form-label">Adresse</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="adresse" name="adresse" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="ville" class="form-label col-sm-2 col-form-label">Ville</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ville" name="ville" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="codepostal" class="form-label col-sm-2 col-form-label">Code Postal</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="codepostal" name="codepostal" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mx-auto d-block">Créer l'utilisateur</button>
            </form>

            <?php
            require_once 'connexion.php';
                if (isset($_POST['mel'], $_POST['motdepasse'], $_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['ville'], $_POST['codepostal'])) {
                    $mel = $_POST['mel'];
                    $motdepasse = md5($_POST['motdepasse']); // Cryptage du mot de passe
                    $nom = $_POST['nom'];
                    $prenom = $_POST['prenom'];
                    $adresse = $_POST['adresse'];
                    $ville = $_POST['ville'];
                    $codepostal = $_POST['codepostal'];
                    $profil = 'client';

                    try {
                        // Requête pour insérer les données dans la table utilisateur
                        $sql = "INSERT INTO utilisateur (mel, motdepasse, nom, prenom, adresse, ville, codepostal) 
                                VALUES (:mel, :motdepasse, :nom, :prenom, :adresse, :ville, :codepostal)";
                        $stmt = $connexion->prepare($sql);
                        $stmt->bindParam(':mel', $mel, PDO::PARAM_STR);
                        $stmt->bindParam(':motdepasse', $motdepasse, PDO::PARAM_STR);
                        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
                        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                        $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
                        $stmt->bindParam(':ville', $ville, PDO::PARAM_STR);
                        $stmt->bindParam(':codepostal', $codepostal, PDO::PARAM_STR);
                        $stmt->bindParam(':profil', $profil, PDO::PARAM_STR);
                        $stmt->execute();

                        echo "<div class='alert alert-success text-center mt-3'>L'utilisateur a bien été créé !</div>";
                    } catch (PDOException $e) {
                        //erreur sans msg
                    }
                }
            ?>
        </div>

        <div class="col-sm-3">
        <img src="librairie.png" width="300px" height="350px">
        <?php include ('authentification.php');?>   <!-- Inclure pour la connexion -->
      </div>
    </div>
</div>
<?php
} else { 
    echo "<h2>Accès non autorisé !!!</h2>";
 } ?>
</body>
</html>