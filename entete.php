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
if (!isset($_GET["nmbr"]) || empty($_GET["nmbr"])) {
  echo '
  <form method="get" action="' . $_SERVER['PHP_SELF'] . '">
      <div class="mb-3">
          <input type="text" class="form-control" id="nmbr" name="nmbr" placeholder="Rechercher dans le catalogue (saisie nom de l\'auteur)">
      </div>
      <button type="submit" class="btn btn-primary">Rechercher</button>
      <button type="submit" class="btn btn-primary">Panier</button>
  </form>';
}
$auteur = $_GET["nmbr"];
?>

</form>
</body>
</html>


