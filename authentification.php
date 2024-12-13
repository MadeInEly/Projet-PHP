
<h2> Se connecter </h2>
<form action="connexion.php" method = "post">

        Identifiant: <input name="nom" type="text" size ="30">

        Mot de passe : <input name="code" type="text" size ="30">

        <input type="submit" name="btnSeConnecter"  value="Se connecter">

    </form>
<?php
    if (!isset($_POST['btnSeConnecter'])) { /* L'entrée btnSeConnecter est vide = le formulaire n'a pas été submit=posté, on affiche le formulaire */

echo '

<form action="'.$_SERVER['PHP_SELF']'" method = "post" ">

    Identifiant: <input name="mel" type="text" size ="30"">

    Mot de passe: <input name="mot_de_passe" type="text" size ="30"">

    <input type="submit" name="btnSeConnecter"  value="Se connecter">

</form>';

} else

/* L'utilisateur a cliqué sur Se connecter, l'entrée btnSeConnecter <> vide, on traite le formulaire */

{

// On se connecte

require_once 'connexion.php';

$mel = $_POST['mel'];

$mot_de_passe = $_POST['mot_de_passe'];



$stmt = $connexion->prepare("SELECT * FROM utilisateur where mel=:mel AND mot_de_passe=:mot_de_passe");



$stmt->bindValue(":mel", $mel); // pas de troisième paramètre STR par défaut

$stmt->bindValue(":mot_de_passe", $mot_de_passe); // idem

$stmt->setFetchMode(PDO::FETCH_OBJ);

// Les résultats retournés par la requête seront traités en 'mode' objet

$stmt->execute();

$enregistrement = $stmt->fetch(); // boucle while inutile

if ($enregistrement) { // si $enregistrement n'est pas vide = on a trouvé quelque chose -> on est connecté

    echo '<h1>Connexion réussie !</h1>';

} else { // La requête n'a pas retournée de résultat, on a pas trouvé de ligne correspondant au mel et mot de passe

    echo "Echec à la connexion.";

}

}

?>