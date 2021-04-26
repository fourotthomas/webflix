<!-- - Créer une nouvelle page movies.php
- Insèrer un lien dans le menu
- Récupèrer les films de la BDD sur cette page
- Intégrer la maquette jointe (sans le header ni footer)
- Les images seront dans un dossier uploads/movies/, normalement le nom de chaque image correspond à ce qu'on a dans la BDD au niveau du champ cover
- Le nombre de l'étoile sera aléatoire (boucle for ? fonction rand() ?) pour le moment ☆★ -->

<?php

$title= 'Les films'; //Variable pour changer le titre ( à mettre avant le header )
$stylsheet = 'assets/css/films.css' ; //Variable pour ajouter un fichier css relatif à cette page

require 'partials/header.php'; 

//J'ai besoin de récupérer les movie avec la bonne requête
global $db; // pour avoir l'autocompletion
$query = $db->query('SELECT * FROM movie');
$movies = $query->fetchAll();

?>

<div class="container">
    <h1>Les films</h1>

    <div class="row">
        <?php foreach($movies as $movie){ ?>
            <div class="col-3">
                <div class="card mb-4">
                    <div class="card-body ">
                        <img src=<?="./uploads/movies/".$movie['cover'] ;?> class="card-img-top" alt="">
                        <h2 class="card-title text-center"><?= $movie['title']; ?> </h2>
                        <p class="card-text">Sorti en <?= substr($movie['released_at'], 0, 4); ?></p> <!--  substr sert à ne prendre que les 4 premier caractéres pour ici ne garder que l'année -->
                        <p class="card-text"><?= substr($movie['description'], 0, 150); ?>...</p>
                        <!-- <div class="d-grid gap-2"> <a type="button" class=" btn btn-dark btn-outline-info">Voir le film</a> </div> -->
                        <div class="text-center d-grid gap-2">
                            <a href="./movie.php?id=<?= $movie['id']; ?>" class="btn btn-dark btn-outline-info"> Voir le film </a>
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

<?php require 'partials/footer.php'; ?>