<?php
// Démarrage de la session
session_start();

// Inclure le fichier de connexion à la base de données
require_once 'connexion.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Votre Panier</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="col-sm-9">
    
    <div class="row">
        <?php
if (isset($_SESSION['profil']) && $_SESSION['profil'] === 'admin') {
    include('enteteadmin.php'); // Inclure l'en-tête pour l'administrateur
} else {
    include('entete.php'); // Inclure l'en-tête normal
}
if (isset($_SESSION['profil'])) {
    // Vérification des emprunt en cours et du nombre de livres restant a emprunter
    $sqlEmpruntsEnCours = "SELECT COUNT(*) FROM emprunter WHERE mel = :email AND dateretour IS NULL";
    $stmtEmpruntsEnCours = $connexion->prepare($sqlEmpruntsEnCours);
    $stmtEmpruntsEnCours->bindParam(':email', $_SESSION['mail'], PDO::PARAM_STR);
    $stmtEmpruntsEnCours->execute();
    $resultatEmpruntsEnCours = $stmtEmpruntsEnCours->fetch(PDO::FETCH_ASSOC);


    echo "<p>Vous pouvez encore emprunter " . (5 - $empruntsEnCours) . " livre(s).</p>";

    //  si le panier contient des livres
    if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
        echo "<ul class='list-group'>";
        foreach ($_SESSION['panier'] as $nolivre) {
            // Récupération des informations sur le livre et de l'auteur 
            $sqlLivre = "
                SELECT livre.titre, auteur.nom, auteur.prenom 
                FROM livre
                JOIN auteur ON livre.noauteur = auteur.noauteur
                WHERE livre.nolivre = :nolivre
            ";
            $stmtLivre = $connexion->prepare($sqlLivre);
            $stmtLivre->bindParam(':nolivre', $nolivre, PDO::PARAM_STR);
            $stmtLivre->execute();
            $livre = $stmtLivre->fetch(PDO::FETCH_ASSOC);

            if ($livre) {
                // Affichage des informations de l'auteur et du titre du livre
                $auteur = ($livre['prenom']) . " " . ($livre['nom']);
            
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                echo $auteur . " - " . ($livre['titre']);
                echo "<a href='panier.php?annuler=" . ($nolivre) . "' class='btn btn-danger btn-sm'>Annuler</a>";
                echo "</li>";
            }
            
        }
        echo "</ul>";
    } else {
        echo "<p>Votre panier est vide.</p>";
    }

    //valider panier
    echo "<div class='mt-3'>";
    echo "<a href='panier.php?valider=true' class='btn btn-success'>Valider le panier</a>";
    echo "</div>";
} else {
    echo "<p class='text-danger'>Connecter vous pour voir votre panier.</p>";
}   ?>
</div>

    <!-- Colonne de droite -->
    <div class="col-sm-3">
            <img src="librairie.png" width="300px" height="350px" class="mb-3">
            <?php include('authentification.php'); ?> <!-- Inclure pour la connexion -->
        </div>

</body>
</html>
