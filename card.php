<?php
require 'partials/header.php';

$title = 'Panier';

$id = $_GET['id'] ?? 0;

global $db;

$query = $db->prepare('SELECT * FROM movie WHERE id = :id');
$query->bindValue(':id', $id);
$query->execute();
$movie = $query->fetch();



var_dump($_SESSION['card'])

?>



<div class="container">

        <h1>Votre panier est vide</h1>

</div>











<?php require 'partials/footer.php'; ?>