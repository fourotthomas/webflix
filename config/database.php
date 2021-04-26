<?php

/**
 * Ici, on fait la connexion avec la base de données.
 */

$db = new PDO('mysql:host=localhost;dbname=webflix;charset=UTF8','root','',[
//activer les erreurs SQL ( optionnel)
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    //On récupére les résultat au format associatif
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

// on peut faire          var_dump($db);   pour vérifier qu'il n'y a pas d'erreur
//Ne pas oublier de lancer le serveur php

// $db est un objet PDO
