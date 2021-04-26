<?php

//on va d'abord récupérer l'id dans l'url
$id = $_GET['id'] ?? 0;  //s'il n'existe pas on le met à 0


$title = "Acteur";

require 'partials/header.php';

//On va récupérer l'acteur dont l'ID est dans l'URL
global $db;
//On prépare la requéte pour eviter des problémes de sécurité (injection sql)
$query = $db->prepare('SELECT * FROM actor WHERE id = :id');
$query->bindValue(':id',$id);
$query->execute(); //necessaire pour preparer la requéte
$actor = $query->fetch(); //On a une seule ligne de résultat

//On vérifie ici si l'acteur existe dans la base
if (!$actor){
    require 'partials/404.php';
}

?>

<div class="container">
    <h1>L'acteur <?= $actor['firstname'].' '.$actor['name']; ?></h1>
    <!-- Dans la BDD, la date est au format YYYY-MM-JJ -->


    <!-- <p>Né le <?= date('d F Y', strtotime( $actor['birthday'])); ?></p> -->

    <!-- <p>Pour formater la date en français</p> -->

    <?php setlocale(LC_ALL, 'fr.utf-8'); ?> <!-- On passe le truc en français et en utf-8 pour les accents -->
    <p>Né le <?= strftime('%d %B %Y', strtotime( $actor['birthday'])); ?></p> <!-- on utilse la date en français -->
    <div class="mt-5">
        <?php
            $query = $db->prepare(
                'SELECT * FROM movie
                INNER JOIN movies_has_actor ON movie.id = movies_has_actor.movie_id
                WHERE movies_has_actor.actor_id = :id'
            );
            $query->execute([':id' => $id]);
            $movies = $query->fetchAll()
        ?>
        <h5>A joué dans : </h5>
        <ul class="list-unstyled">
            <?php foreach ($movies as $movie){ ?>
                <li><a href="./movie.php?id=<?=$movie['id']; ?>">
                <?= $movie['title']; ?>   
            </a> </li>
            <?php } ?>
        </ul>
    </div>
</div>

<?php require 'partials/footer.php' ; ?>