<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Biblioteque</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
        session_start();

        
        if(!$_SESSION["adminUser"] || !isset($_SESSION["adminUser"])) {
            echo "Accès non autorisé."; // Refuse l'accès un utilisateur normal pas admin
            exit;
        }
        require("utilitaires/authentification.php");

        if(isset($_POST["noauteur"])){

            $noauteur = $_POST["noauteur"];
            $titre = $_POST["titre"];
            $ISBN13 = $_POST["ISBN13"];
            $annee_parution = $_POST["annee_parution"];
            $resume = $_POST["resume"];
            $cover = $_FILES["cover"];

           try {

                $req = $connexion->prepare("
                INSERT INTO 
                livre(noauteur, titre, isbn13, anneeparution, resume, dateajout, image) 
                VALUES(:noauteur, :titre, :ISBN13, :annee_parution, :resume, :dateajout, :cover)
                ");

                $req->bindValue(":noauteur", $noauteur, PDO::PARAM_INT);
                $req->bindValue(":titre", $titre);
                $req->bindValue(":ISBN13", $ISBN13);
                $req->bindValue(":annee_parution", $annee_parution);
                $req->bindValue(":resume", $resume);
                $req->bindValue(":dateajout", date("Y-m-d"));
                $req->bindValue(":cover", $cover['name']);

                $req->execute();
                $book_added = TRUE;

                move_uploaded_file($cover['tmp_name'], "images/covers/".$cover['name']); // Ajouter la cover dans le dossier cover de images pour l'afficher sur le site.

           } catch(Exception $e) {
                $erreur = $e;
                $book_added = FALSE;
           }
            
            
        }

    ?>
        
        <h1 class="big-title">Ajouter un livre</h1>

        <form method="post" class="form-admin" enctype="multipart/form-data">
            <label for="auteur">Auteur : </label>
            <?php
                    echo "<select name=\"noauteur\" id=\"auteur\" required>";
                    echo "<option value=\"\" disabled selected>---- Sélectionner ----</option>";
                    $req = $connexion->query("SELECT noauteur,nom FROM auteur");
                    $req->setFetchMode(PDO::FETCH_OBJ);

                    while($auteur = $req->fetch()){
                        echo "<option value=\"{$auteur->noauteur}\">{$auteur->nom}</option>";
                    }

                    echo "</select>";
                
            ?>

            <label for="titre">Titre : </label>
            <input type="text" name="titre" id="titre" autocomplete="off" required>
            
            <label for="ISBN13">ISBN13 :</label>
            <input type="text" name="ISBN13" id="ISBN13" autocomplete="off" required>
            
            <label for="annee_parution">Année de parution : </label>
            <input type="text" name="annee_parution" id="annee_parution" autocomplete="off" required>
            
            <label for="resume">Résumé : </label>
            <textarea name="resume" id="resume" autocomplete="off" rows="7" required></textarea>     

            <label for="cover">Image : </label>
            <input type="file" id="cover" name="cover" accept="image/png, image/jpeg" autocomplete="off" required/>

            <input type="submit" value="Ajouter le livre" class="button-general">
            
            <?php 
            
                if(isset($book_added)) {
                    if ($book_added) 
                        echo '<p class="ajout_succes">Livre ajouté avec succès !</p>';
                    else
                        echo '<p class="ajout_erreur">Une erreur est survenue l\'or de l\'ajout du livre : '. $erreur . '</p>';
                }
            ?>
    <div class="col-sm-3">
    <img src="librairie.png" width="300px" height="350px">
    <?php include('authentification.php'); ?> <!-- Inclure pour la connexion -->
  </div>
</body>
</html>