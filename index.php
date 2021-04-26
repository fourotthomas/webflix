<?php
// On va inclure le header (le doctype et le menu) sur chaque page
// $title = 'Mon super site';
require 'partials/header.php'; ?>

<!-- Ici, entre les 2 require, on peut intégrer notre page HTML -->
<div class="container">
    <h1 class="text-center mb-5">Ma page d'accueil</h1>
   
    <?php
    //On va essayer de récuperer les catégories de la base de données
    global $db; //Cette ligne sert à activer l'autocomplétion
    //Je fais une requéte SQL pour récupérer mes catégories
    $query = $db->query('SELECT * FROM category');
    //Je récupère les résultats de la requéte sous forme de tableau
    $categories = $query->fetchAll();


    $query = $db->query('SELECT * FROM movie ORDER BY RAND() LIMIT 4;');
    $randMovies = $query->fetchAll();

    $query = $db->query('SELECT * FROM movie ORDER BY released_at DESC LIMIT 9;');
    $carrousel = $query->fetchAll();


    ?>
    <!-- /**
    * 1. On va poser le carousel des films
    * 2. Par défaut, on utilise Bootstrap et on va afficher 3 jaquettes de films par slide
    * 3. On aura 3 slides donc 9 films ce qui veut dire qu'on doit écrire une requête SQL qui récupère
    * les 9 derniers films par date de sortie.
    * 4. Pour la boucle, on part d'un tableau de 9 éléments et on doit l'afficher dans le code HTML du carousel
    * 5. Pour la selection de films aléatoires, il faudra récupérer 4 films aléatoires (RAND())
    */ -->

    <div id="carouselExampleControls" class="carousel slide mb-5 " data-bs-ride="carousel">
        <div class="carousel-inner ">
            <div class="carousel-item active">
                <div class="d-flex ">
                <?php for ($i = 0; $i <= 2; $i++) { ?>
                    <img src="./uploads/movies/<?= $carrousel[$i]['cover'] ?>" class="w-33 d-block" alt="...">

                <?php } ?>
                </div>
            </div>

            <div class="carousel-item ">
                <div class="d-flex ">
                <?php for ($i = 3; $i <= 5; $i++) { ?>
                    <img src="./uploads/movies/<?= $carrousel[$i]['cover'] ?>" class="w-33 d-block" alt="...">

                <?php } ?>
                </div>
            </div>
            <div class="carousel-item ">
                <div class="d-flex">
                <?php for ($i = 6; $i <= 8; $i++) { ?>
                    <img src="./uploads/movies/<?= $carrousel[$i]['cover'] ?>" class="w-33 d-block" alt="...">

                <?php } ?>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev " type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container">
        <h2 class="text-center mb-3">Sélection de films aléatoires</h2>

        <div class="row">
            <?php foreach ($randMovies as $randMovie) { ?>
                <div class="col-3">
                    <div class="card mb-4">
                        <div class="card-body ">
                            <img src=<?= "./uploads/movies/" . $randMovie['cover']; ?> class="card-img-top" alt="">
                            <h2 class="card-title text-center"><?= $randMovie['title']; ?> </h2>
                            <p class="card-text">Sorti en <?= substr($randMovie['released_at'], 0, 4); ?></p> <!--  substr sert à ne prendre que les 4 premier caractéres pour ici ne garder que l'année -->
                            <p class="card-text"><?= $randMovie['description']; ?></p>
                            <div class="text-center d-grid gap-2">
                                <a href="./movie.php?id=<?= $randMovie['id']; ?>" class="btn btn-dark btn-outline-info"> Voir le film </a>
                            </div>
                            <div class="card-footer">
                                <?php
                                $stars = ' ';
                                $n = rand(1, 5);
                                for ($i = 1; $i <= $n; $i++) {
                                    $stars = $stars . '⭐️';
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