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

<div class="container mt-4">
    
    <div class="row">
        <?php
if (isset($_SESSION['profil']) && $_SESSION['profil'] === 'admin') {
    include('enteteadmin.php'); // Inclure l'en-tête pour l'administrateur
} else {
    include('entete.php'); // Inclure l'en-tête normal
}
?>
<h1 class="mb-4">Votre Panier</h1>
        <!-- Colonne de gauche (col-sm-9) -->
        <div class="col-sm-9 order-sm-1">
            <?php
            // Vérifier si le panier existe et contient des livres
            if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
                // Préparer une requête pour récupérer les détails des livres dans le panier
                $placeholders = implode(',', array_fill(0, count($_SESSION['panier']), '?'));

                // Exécuter la requête uniquement si le panier contient des livres
                $stmt = $connexion->prepare("SELECT nolivre, titre, anneeparution FROM livre WHERE nolivre IN ($placeholders)");
                $stmt->execute($_SESSION['panier']); // Utiliser les ID du panier comme paramètres

                $livres = $stmt->fetchAll(PDO::FETCH_OBJ);

                if ($livres): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Année de Parution</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($livres as $livre): ?>
                            <tr>
                                <td><?= htmlspecialchars($livre->titre) ?></td>
                                <td><?= htmlspecialchars($livre->anneeparution) ?></td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="article_id" value="<?= $livre->nolivre ?>">
                                        <button type="submit" name="supprimer_du_panier" class="btn btn-danger btn-sm">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php
                else:
                    echo '<div class="alert alert-warning">Aucun livre trouvé dans la base de données.</div>';
                endif;
            } else {
                echo '<div class="alert alert-info">Votre panier est vide.</div>';
            }

            // Suppression d'un livre du panier
            if (isset($_POST['supprimer_du_panier'])) {
                $article_id = $_POST['article_id'];
                if (($key = array_search($article_id, $_SESSION['panier'])) !== false) {
                    unset($_SESSION['panier'][$key]);
                    $_SESSION['panier'] = array_values($_SESSION['panier']); // Réindexer le tableau
                    echo '<div class="alert alert-success mt-3">Livre supprimé du panier.</div>';
                }
                header('Location: panier.php');
    exit;
            }
            ?>
        </div>
    </div>
    <!-- Colonne de droite (col-sm-3) -->
    <div class="col-sm-3 order-sm-2">
            <img src="librairie.png" width="300px" height="350px" class="mb-3">
            <?php include('authentification.php'); ?> <!-- Inclure pour la connexion -->
        </div>
</div>
</body>
</html>
