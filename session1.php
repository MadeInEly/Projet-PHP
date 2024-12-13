<?php

// fichier : session1.php

// ! ! ! démarrage de la session, instruction a placer en tête de script ! ! ! 

session_start();

?>

<!DOCTYPE html>

<html>

<body>

<?php

 

echo 'On affecte 10 à la variable x<BR>';

$x = 10; 

 

echo 'On ajoute une entree dans le tableau $_SESSION de visibilité super globale';

$_SESSION["x"] = 10;

 

?>

</body>

</html>