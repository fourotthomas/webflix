<?php
//On inclut la database qui est incluse dans le header
require 'partials/header.php';

//On récupére l'id
$id = $_GET['id'] ?? 0;


//On fait la suppression
global $db;
$query = $db->prepare('DELETE FROM category WHERE id = :id');
$query->bindValue(':id',$id);
$query->execute();


//On redirige vers la liste
header('Location: categorie-liste.php?delete');