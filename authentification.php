<h2>Se connecter</h2>
<?php
session_start();

// Se déconnecteré
if (isset($_POST['btnSeDeconnecter'])) {
    session_unset(); 
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit;
}

if (isset($_SESSION['connecte']) && $_SESSION['connecte'] === true) {
    echo '<h1>Bienvenue, vous êtes déjà connecté !</h1>';
    echo '
    <form action="' . $_SERVER['PHP_SELF'] . '" method="post">
        <input type="submit" name="btnSeDeconnecter" value="Se déconnecter">
    </form>';
}

// Si le formulaire de connexion est soumis
if (!isset($_POST['btnSeConnecter'])) { 
    // Afficher le formulaire
    echo '
    <form action="' . $_SERVER['PHP_SELF'] . '" method="post">
        Identifiant : <input name="mel" type="text" size="30" required>
        Mot de passe : <input name="mot_de_passe" type="password" size="30" required>
        <input type="submit" name="btnSeConnecter" value="Se connecter">
    </form>';
} else {
    // Connexion à la base de données
    require_once 'connexion.php';

    // Récupération des données du formulaire
    $mel = $_POST['mel'];
    $mot_de_passe = $_POST['mot_de_passe'];

    try {
        // Requête SQL corrigée
        $stmt = $connexion->prepare("SELECT * FROM utilisateur WHERE mel = :mel AND motdepasse = :motdepasse");
        $stmt->bindValue(":mel", $mel); 
        $stmt->bindValue(":motdepasse", $mot_de_passe); 
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();

        // Vérification du résultat
        $enregistrement = $stmt->fetch();
        if ($enregistrement) {
            $_SESSION['connecte'] = true; // Marquer l'utilisateur comme connecté
            echo '<h1>Connexion réussie !</h1>';
            echo '
            <form action="' . $_SERVER['PHP_SELF'] . '" method="post">
                <input type="submit" name="btnSeDeconnecter" value="Se déconnecter">
            </form>';
        } else {
            echo '<div style="color: red;">Échec à la connexion. Identifiant ou mot de passe incorrect.</div>';
            echo '
            <form action="' . $_SERVER['PHP_SELF'] . '" method="post">
                Identifiant : <input name="mel" type="text" size="30" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                Mot de passe : <input name="mot_de_passe" type="password" size="30" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                <input type="submit" name="btnSeConnecter" value="Se connecter">
            </form>';
        }

    } catch (PDOException $e) {
        echo '<div style="color: red;">Erreur : ' . $e->getMessage() . '</div>';
    }
}
?>
