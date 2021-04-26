<?php

$id = $_GET['id'] ?? 0;

$title = 'Catégorie';

require './partials/header.php';

global $db;

/* $query = $db->prepare('SELECT * FROM movie WHERE category_id = :id;');
$query->bindValue(':id', 3);
$query->execute();
$movie = $query->fetch(); */

$query = $db->query('SELECT * FROM movie WHERE category_id=' . $id);
$movie = $query->fetchAll();

$db2 = new PDO('mysql:host=localhost;dbname=webflix','root','',[
    //activer les erreurs SQL ( optionnel)
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        //On récupére les résultat au format associatif
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);


$query2 = $db2->query('SELECT * FROM category WHERE id=' . $id);
$category = $query2->fetchAll();

if (!$movie) {
    require 'partials/404.php';
}

/* var_dump($movie) */
?>



<div class="container">
<?php foreach($category as $cat){ ?>
    <h1><?= $cat['name']; ?></h1>
<?php } ?>

    <div class="row">
        <?php foreach($movie as $film){ ?>
            <div class="col-3">
                <div class="card mb-4">
                    <div class="card-body ">
                        <img src=<?="./uploads/movies/".$film['cover'] ;?> class="card-img-top" alt="">
                        <h2 class="card-title text-center"><?= $film['title']; ?> </h2>
                        <p class="card-text">Sorti en <?= substr($film['released_at'], 0, 4); ?></p> <!--  substr sert à ne prendre que les 4 premier caractéres pour ici ne garder que l'année -->
                        <p class="card-text"><?= $film['description']; ?></p>
                        <div class="text-center d-grid gap-2">
                            <a href="./movie.php?id=<?= $film['id']; ?>" class="btn btn-dark btn-outline-warning"> Voir le film </a>
                        </div>
                        <div class="card-footer">
                            <?php 
                                $stars = ' ';
                                $n = rand(1,5);
                                for($i=1; $i<=$n; $i++){
                                    $stars = $stars.'⭐️';
                                }
                                echo $stars;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>    
    </div>


</div>











<?php

require './partials/footer.php'

?>