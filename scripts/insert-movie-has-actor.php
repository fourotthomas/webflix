<?php


// J'inclue la connexion à la base de données
require __DIR__.'/../config/database.php';

//On va vider la table avant de la remplir et remettre les id à 0
$db->query('SET FOREIGN_KEY_CHECKS = 0'); //on desactive temporairement la vérification des clé étrangére pour éviter les erreurs
$db->query('TRUNCATE movies_has_actor');
$db->query('SET FOREIGN_KEY_CHECKS = 1'); //on réactive la vérification des clé étrangére pour éviter les erreurs

$db->query('INSERT INTO webflix.movies_has_actor (movie_id, actor_id) VALUES
(1, 1), (1, 2),
(2, 1),
(3, 3), (3, 5),
(4, 1), (4, 3), (4, 10),
(5, 4),
(6, 6), (6, 7),
(9, 7),
(19, 4),
(20, 9),
(21, 8)'); //on utilise plusieurs fois la requete
            //(1,2) lie le film 1 et l'acteur 2

echo 'INSERT INTO movie_has_actor...';