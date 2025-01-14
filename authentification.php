<?php
// Démarrage de la session
//session_start(); //

// Déconnexion
if (isset($_POST['btnSeDeconnecter'])) {
    session_unset(); // Supprime toutes les variables de session
    session_destroy(); // Détruit la session
    header("Location: " . $_SERVER['PHP_SELF']); // Redirige vers la page actuelle
    exit;
}

if (isset($_SESSION['profil']) && $_SESSION['profil'] == 'admin') {
    echo '<p><strong>Administrateur :</strong></p>';
}


// Si l'utilisateur est connecté
if (isset($_SESSION['connecte']) && $_SESSION['connecte'] === true) {
    echo '<h2><strong>' . htmlspecialchars($_SESSION['prenom']) . ' ' . htmlspecialchars($_SESSION['nom']) . '</strong></h2>';
    echo '<ul>';
    echo '<li>Adresse email : ' . htmlspecialchars($_SESSION['mel']) . '</li>';
    echo '<li>Adresse : ' . htmlspecialchars($_SESSION['adresse']) . '</li>';
    echo '<li>Ville : ' . htmlspecialchars($_SESSION['ville']) . '</li>';
    echo '<li>Code postal : ' . htmlspecialchars($_SESSION['codepostal']) . '</li>';
    echo '</ul>';
    echo '<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">
            <input type="submit" name="btnSeDeconnecter" value="Se déconnecter">
          </form>';
} else {
    echo '<h2>Se connecter</h2>';

    if (isset($_POST['btnSeConnecter'])) {
        require_once 'connexion.php'; // Inclut le fichier de connexion à la base de données

        // Récupération et validation des données envoyées par le formulaire
        $mel = $_POST['mel']; // Supprime les espaces inutiles
        $mot_de_passe = $_POST['mot_de_passe'];

        if (!empty($mel) && !empty($mot_de_passe)) {
            try {
                // Requête préparée pour éviter les injections SQL
                $stmt = $connexion->prepare("SELECT * FROM utilisateur WHERE mel = :mel AND motdepasse = :motdepasse");
                $stmt->bindValue(':mel', $mel);
                $stmt->bindValue(':motdepasse', $mot_de_passe);
                $stmt->execute();

                $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($utilisateur) {
                    // Stockage des informations utilisateur dans la session
                    $_SESSION['connecte'] = true;
                    $_SESSION['nom'] = $utilisateur['nom'];
                    $_SESSION['prenom'] = $utilisateur['prenom'];
                    $_SESSION['mel'] = $utilisateur['mel'];
                    $_SESSION['adresse'] = $utilisateur['adresse'];
                    $_SESSION['ville'] = $utilisateur['ville'];
                    $_SESSION['codepostal'] = $utilisateur['codepostal'];
                    $_SESSION['profil'] = $utilisateur['profil'];

                    // Redirection pour éviter le repost du formulaire
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                } else {
                    echo '<div style="color: red;">Identifiant ou mot de passe incorrect.</div>';
                }
            } catch (PDOException $e) {
                echo '<div style="color: red;">Erreur : ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
        } else {
            echo '<div style="color: red;">Veuillez remplir tous les champs.</div>';
        }
    }

    // Affichage du formulaire de connexion
    echo '
    <form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">
        <label for="mel" Identifiant :</label>
        <input name="mel" id="mel" type="text" size="30"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"required>  *  <br>
        <label for="mot_de_passe">Mot de passe :</label>
        <input name="mot_de_passe" id="mot_de_passe" type="password" size="30"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>  *<br>
        <input type="submit" name="btnSeConnecter" value="Se connecter">
    </form>';
}
?>