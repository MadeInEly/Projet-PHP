<?php

require_once('connexion.php');

 

$stmt = $connexion->prepare("INSERT INTO utilisateur (nom, prenom, mel, mot_de_passe) VALUES (:nom, :prenom, :mel, :mot_de_passe)");

 

// insertion d'une ligne

$nom = 'Dupont';

$prenom = 'Paul';

$mel = 'p.dupont@yahoo.fr';

$mot_de_passe = 'secretdupont';

 

$stmt->bindValue(':nom', $nom, PDO::PARAM_STR);

$stmt->bindValue(':prenom', $prenom, PDO::PARAM_STR);

$stmt->bindValue(':mel', $mel, PDO::PARAM_STR);

$stmt->bindValue(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);

/* Nota Bene : PDO::PARAM_STR est le type de la valeur a insérer

Dans le cas d'un entier le type sera PDO::PARAM_INT et on ne mettra pas sa valeur entre 'quote'

Pour les types réels, date... on associe le type PDO::PARAM_STR ... PDO::PARAM_STR est le type par défaut : 

on aurait pu ommettre le troisième paramètre ici.

Le PDO::PARAM_INT est indispensable pour la valeur d'un LIMIT d'un SELECT.

Exemple : $numero = 88; $stmt->bindValue(':numero', $mot_de_passe, PDO::PARAM_INT);

Pour la liste des types : https://www.php.net/manual/en/pdo.constants.php

*/

 

$stmt->execute();

$nb_ligne_affectees = $stmt->rowCount();

echo $nb_ligne_affectees." ligne() insérée(s).<BR>";

 

$dernier_numero = $connexion->lastInsertId();

// Optionnel, Nota Bene : sur récup. sur l'objet PDO, connexion

echo "Dernier numéro utilisateur généré : ".$dernier_numero."<BR>";

 

// insertion d'une autre ligne avec des valeurs différentes

$nom = 'Tremblay';

$prenom = 'Robert';

$mel = 'r.tremblay@gmail.fr';

$mot_de_passe = 'secrettremblay';

$stmt->bindValue(':nom', $nom, PDO::PARAM_STR);

$stmt->bindValue(':prenom', $prenom, PDO::PARAM_STR);

$stmt->bindValue(':mel', $mel, PDO::PARAM_STR);

$stmt->bindValue(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);

$stmt->execute();

$nb_ligne_affectees = $stmt->rowCount();

echo $nb_ligne_affectees." ligne() insérée(s).<BR>";

 

$dernier_numero = $connexion->lastInsertId(); // Optionnel, Nota Bene : sur récup. sur l'objet PDO, connexion

echo "Dernier numéro utilisateur généré : ".$dernier_numero."<BR>";

 

?>