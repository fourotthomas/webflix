<?php
// $title = 'Les acteurs';

$title= 'Les acteurs'; //Variable pour changer le titre ( à mettre avant le header )

require 'partials/header.php'; 

//J'ai besoin de récupérer les acteurs avec la bonne requête
global $db; // pour avoir l'autocompletion
$query = $db->query('SELECT * FROM actor');
$actors = $query->fetchAll();


?>

<div class="container">
    <h1>Les acteurs</h1>

    <div class="row">
        <?php foreach($actors as $actor){ ?>
            <div class="col-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title text-center"><?= $actor['firstname'].' '.$actor['name']; ?> </h2>

                        <div class="text-center">
                            <a href="./acteur.php?id=<?= $actor['id']; ?>" class="btn btn-dark btn-outline-warning"> Voir l'acteur </a>
                        </div>
                    
                    </div>
                </div>
            </div>
        <?php } ?>    
    </div>


</div>

<?php require 'partials/footer.php'; ?>