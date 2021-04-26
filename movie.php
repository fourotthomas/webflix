<?php
$id = $_GET['id'] ?? 0;

$title = 'Film';

require './partials/header.php';


global $db;

$query = $db->prepare('SELECT * FROM movie WHERE id = :id');
$query->bindValue(':id', $id);
$query->execute();
$movie = $query->fetch();


$query = $db->prepare('SELECT * FROM commentaire where movie_id = :id ORDER BY id DESC');
$query->bindValue(':id', $id);
$query->execute();
$commentaire = $query->fetch();

if (!$movie) {
    require 'partials/404.php';
};

$pseudo = $_POST['pseudo'] ?? '';
$message = $_POST['message'] ?? '';
$note = $_POST['note'] ?? '';
$created_at = date("y.m.d");
$errors = [];

$pseudo = htmlspecialchars($pseudo);
$message = htmlspecialchars($message);

if(!empty($_POST)){

    $_SESSION['card'][]= [
        'movie_id' =>  $id,
        'format' => $_POST['format'],
        'quantity' => $_POST['quantity']
    ];
}

var_dump($_SESSION);

if (!empty($_POST)) {
    if (empty($pseudo)) {
        $errors['pseudo'] = 'Entrez un pseudo';
    }

    if (strlen($message) < 4) {
        $errors['message'] = 'Entrez un message';
    }
    if ($note != 1 && $note != 2 && $note != 3 && $note != 4 && $note != 5) {
        $errors['note'] = "Choississez une note entre 1 et 5";
    }

    if (empty($errors)) {

        $query = $db->prepare(
            'INSERT INTO commentaire (pseudo, message, note, created_at, movie_id)
        VALUES (:pseudo, :message, :note, :created_at, :movie_id)'
        );

        $query->bindValue(':pseudo', $pseudo);
        $query->bindValue(':message', $message);
        $query->bindValue(':note', $note);
        $query->bindValue(':created_at', $created_at);
        $query->bindValue(':movie_id', $id);

        $query->execute();
    }
}




?>

<div class="container my-4">
    <div class="row">
        <div class="col-lg-5">
            <img class="img-fluid" src="uploads/movies/<?= $movie['cover']; ?>" />
        </div>
        <div class="col-lg-7">

            <div class="card shadow">
                <div class="card-body">
                    <h1><?= $movie['title']; ?></h1>
                    <p>Durée: <?= convertToHours($movie['duration']); ?></p>
                    <p>Sorti le <?= formatDate($movie['released_at']); ?></p>

                    <div>
                        <?= $movie['description']; ?>
                    </div>

                    <div class="mt-5">
                        <?php
                        $query = $db->prepare(
                            'SELECT * FROM actor
                                 INNER JOIN movies_has_actor ON actor.id = movies_has_actor.actor_id
                                 WHERE movies_has_actor.movie_id = :id'
                        );
                        $query->execute([':id' => $id]);
                        $actors = $query->fetchAll();
                        ?>
                        <h5>Avec :</h5>
                        <ul class="list-unstyled">
                            <?php foreach ($actors as $actor) { ?>
                                <li><a href="./acteur.php?id=<?= $actor['id']; ?>">
                                        <?= $actor['firstname'] . ' ' . $actor['name']; ?></a></li>
                            <?php } ?>
                        </ul>

                    </div>

                </div>
                <div class="card-footer text-muted">
                    <?php

                    $n = $commentaire['note'];
                    for ($i = 0; $i < 5; $i++) {
                        if ($i < $n) {
                            echo '⭐️';
                        } else {
                            echo '☆';
                        }
                    } ?>
                </div>


                <?php if (isset($_SESSION['user'])) { ?>
                    <div class="card ">
                        <div class="card-body row">

                            <div class="col-lg-2">
                                <img class="img-fluid" src="uploads/movies/<?= $movie['cover']; ?>" />
                            </div>


                            <div class="col-lg-6">
                                <p><?= $movie['title'] ?></p>

                                <form action="" method="get" class="form-control">
                                    

                                    <label for="format">Sélectionner le format</label>
                                    <select name="format" id="format" class="form-select">
                                        <option value="1080p">1080p</option>
                                        <option value="4k">4K</option>
                                        <option value="VOD">VOD</option>
                                    </select>

                                    <label for="quantity" class="mt-3">Quantité : </label>
                                    <select name="quantity" id="quantity" class="form-select">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>

                                    <!-- <button class="btn btn-info btn-outline-dark mt-3">Acheter</button> -->
                                   <a href="./card.php" class="btn btn-info btn-outline-dark mt-3">Acheter</a>

                                </form>

                            </div>
                        </div>
                        <?php } ?>

                    </div>


            </div>

            <div class="card shadow mt-5">

                <div class="card-header">
                    <?= $commentaire['pseudo'] ?>
                </div>

                <div class="card-body">
                    <?= $commentaire['message'] ?>
                </div>

                <div class="card-footer">
                    <?php

                    $n = $commentaire['note'];
                    for ($i = 0; $i < 5; $i++) {
                        if ($i < $n) {
                            echo '⭐️';
                        } else {
                            echo '☆';
                        }
                    } ?>

                </div>
            </div>








            <div class="card shadow mt-5">
                <div class="card-body">

                    <form method="POST" name="com">

                        <label for="pseudo">Pseudo</label>
                        <input type="text" name="pseudo" id="pseudo" class="form-control <?= isset($errors['pseudo']) ? 'is-invalid' : ''; ?>">
                        <?php if (isset($errors['pseudo'])) {
                            echo '<span class="text-danger">' . $errors['pseudo'] . '</span>';
                        } ?>


                        <label for="message" class="mt-3">Message</label>
                        <textarea name="message" id="message" class="form-control  <?= isset($errors['message']) ? 'is-invalid' : ''; ?>"></textarea>
                        <?php if (isset($errors['message'])) {
                            echo '<span class="text-danger">' . $errors['message'] . '</span>';
                        } ?>


                        <label for="note" class="mt-3">Note</label>
                        <select name="note" id="note" class="form-select  <?= isset($errors['note']) ? 'is-invalid' : ''; ?>">
                            <option value=""></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <?php if (isset($errors['note'])) {
                            echo '<span class="text-danger">' . $errors['note'] . '</span>';
                        } ?>

                        <button class="btn btn-danger mt-3" name="com">Commenter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php

require './partials/footer.php'

?>