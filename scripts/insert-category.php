<?php

//Le but de ce script est de remplir la BDD avec de catégories
//Le script vide la base et la re-remplit pour repartir au propre.

// J'inclue la connexion à la base de données
require  '../config/database.php';


//Les catégories à ajouter dans la BDD
$categories = ['Films de gangters','Action','Horreur','Science-Fiction','Thriller'];


//On va vider la table avant de la remplir et remettre les id à 0
$db->query('SET FOREIGN_KEY_CHECKS = 0'); //on desactive temporairement la vérification des clé étrangére pour éviter les erreurs
$db->query('TRUNCATE category');
$db->query('TRUNCATE movie');
$db->query('SET FOREIGN_KEY_CHECKS = 1'); //on réactive la vérification des clé étrangére pour éviter les erreurs


foreach ($categories as $category){
    $db->query("INSERT INTO category(name) VALUES ('$category')"); //On insert les catégories dans la base
    echo "INSERT INTO category(name) VALUES ('$category') <br>"; //L'écho n'est pas obligatoire, il permet simplement de visualiser 
};

//Pour exécuter le script il suffit d'aller sur la page, ici http://localhost/php/09-mysql/scripts/insert-category.php
// Le script s'effectue à chaque actualisation de la page

$movies=[
    ['Le Parrain', 1972, 186, 'Films de gangsters'],
    ['Scarface', 1983, 120, 'Films de gangsters'],
    ['Les Affranchis', 1990, 145, 'Films de gangsters'],
    ['Heat', 1995, 146, 'Films de gangsters'],
    ['Die Hard', 1988, 124, 'Action'],
    ['Demolition Man', 1993, 89, 'Action'],
    ['Taken', 2008, 96, 'Action'],
    ['Deadpool', 2016, 97, 'Action'],
    ['The Expandables', 2010, 132, 'Action'],
    ['Scream', 1996, 78, 'Horreur'],
    ['Vendredi 13', 1980, 97, 'Horreur'],
    ['Saw', 2005, 102, 'Horreur'],
    ['Scary Movie', 2000, 79, 'Horreur'],
    ['Star Wars IV Un nouvel espoir', 1977, 160, 'Science-fiction'],
    ['Alien', 1979, 145, 'Science-fiction'],
    ['ET', 1982, 95, 'Science-fiction'],
    ['Robocop', 1987, 98, 'Science-fiction'],
    ['The Game', 1997, 96, 'Thriller'],
    ['Sixième Sens', 1999, 120, 'Thriller'],
    ['Usual Suspects', 1995, 114, 'Thriller'],
    ['Fight Club', 1999, 108, 'Thriller'],
    ['Inception', 2010, 107, 'Thriller'],
    ['Deadpool 2', 1019, 93, 'Action']
];

foreach ($movies as $movie){

    $idCategory = 0 ;
    
    if($movie[3] == 'Films de gangsters'){
        $idCategory = 1;
    }elseif($movie[3] == 'Action'){
        $idCategory = 2;
    }elseif($movie[3] == 'Horreur'){
        $idCategory = 3;
    }elseif($movie[3] == 'Science-fiction'){
        $idCategory = 4;
    }elseif($movie[3] == 'Thriller'){
        $idCategory = 5;
    };

    $cover = str_replace(' ', '-', $movie[0]);
    $cover = str_replace('é', 'e', $cover);
    $cover = str_replace('è', 'e', $cover);
    $cover = str_replace('à', 'a', $cover);
    $cover = strtolower($cover);
    
    $db->query("INSERT INTO movie(title, released_at, description, duration, cover, category_id ) VALUES ('$movie[0]','$movie[1]-01-01','Lorem','$movie[2]','$cover.jpg','$idCategory')");
    
};