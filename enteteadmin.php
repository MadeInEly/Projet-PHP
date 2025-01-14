<!DOCTYPE html>
<html lang="en">
<head>
  <title>Biblioteque</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
      <div class="col-sm-9">
      <h2>Biblio-Drive</h2>
  <h5>La bibliotèque de Monlinsart est fermée au public jusq'à nouvel ordre. Mais il vous est possible de réserver et retirer vos livres via notre service Biblio Drive !</h5> 
  <form action="lister_livres.php" method="GET">

  <?php
$auteur = isset($_GET['nmbr']) ? $_GET['nmbr'] : '';

?>
<form method="get" action="lister_livres.php">
    <div class="mb-3">
        
        <?php 
          echo htmlspecialchars($auteur); 
        ?>
    </div>
    <a href="ajouterunlivre.php" class="btn btn-primary">Ajouter un livre</a>
    <a href="creerunmembre.php" class="btn btn-primary">Créer un membre</a>
    <a href="panier.php" class="btn btn-primary">Panier</a>
</form>

</form>
</body>
</html>
