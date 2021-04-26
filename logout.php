<?php 

session_start(); 

//On deconnecte l'utilisateur
unset($_SESSION['user']);


//On redirige vers la page d'accueil
header('Location: index.php');