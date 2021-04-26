<?php 
/* require 'partials/header.php';


$query = $db->query('SELECT * FROM category');
$category = $query->fetchAll();

$titre = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$image = $_POST['cover'] ?? '';
$duration = $_POST['duration'] ?? '';
$date = $_POST['released_at'] ?? 00 - 00 - 0000;
$an = substr($date, 6, 4);
$mois = substr($date, 3, 2);
$jour = substr($date, 0, 2);
$category_select = $_POST['category'] ?? '';
$errors = [];

if (!empty($_POST)) {
    if (strlen($titre) < 2) {
        $errors['title'] = 'Le titre est trop court';
    }

    if (strlen($description) < 15) {
        $errors['description'] = 'La description est trop courte, elle doit faire 15 caractéres minimum';
    }

    if ($duration <1 || $duration > 999) {
        $errors['duration'] = 'La durée n\'est pas valide';
    }

    if (!checkdate($an, $mois, $jour)) {
        $errors['released_at'] = 'Entrez une date valide';
    }

    if (empty($category_select)) {
        $errors['category'] = 'Choisissez une catégorie';
    }



    if (empty($errors)) {
        
        /** @var PDO $db */   // le @var permet l'autocompletion, A ECRIRE TEL QUEL ATTENTION
        /*$query = $db->prepare('INSERT INTO movie (title, released_at, description, duration, ) VALUES (:title, :released_at, :description, :duration, :cover)');
        $query->bindValue(':title', $titre);
        $query->execute();


        header('Location: movies.php?success');
    }
}

if (isset($_GET['success'])) {
    echo '<div class="alert alert-success dissmissable fade show ">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
         Votre catégorie à bien été ajoutée dans la BDD 
</div>';
}
 */
/* var_dump($an);
var_dump($mois);
var_dump($jour); */
/* ?>

<?php $title = 'Ajouter un film'; ?>

<h1>Ajouter un film</h1>

<form action="" method="POST">
    <div class="mb-4">
        <label for="title" class="mt-3">Titre</label>
        <input type="text" name="title" id="title" class='form-control <?= isset($errors['title']) ? 'is-invalid' : ''; ?>' value="<?= $titre ?>">
        <?php if (isset($errors['title'])) {
            echo '<span class="text-danger">' . $errors['title'] . '</span><br>';
        } ?>

        <label for="description" class="mt-3">Description</label>
        <textarea name="description" id="description" cols="30" rows="5" class='form-control <?= isset($errors['description']) ? 'is-invalid' : ''; ?>' value="<?= $description ?>"></textarea>
        <?php if (isset($errors['description'])) {
            echo '<span class="text-danger">' . $errors['description'] . '</span><br>';
        } ?>

        <label for="cover" class="mt-3" value="<?= $image ?>">Image</label>
        <input type="text" name="cover" id="cover" class='form-control'>


        <label for="duration" class="mt-3">Durée</label>
        <input type="text" name="duration" id="duration" class='form-control <?= isset($errors['duration']) ? 'is-invalid' : ''; ?>' placeholder="Mettre la durée en minutes, ex : 120" value="<?= $duration ?>">
        <?php if (isset($errors['duration'])) {
            echo '<span class="text-danger">' . $errors['duration'] . '</span><br>';
        } ?>

        <label for="released_at" class="mt-3">Date de réalisation</label>
        <input type="text" name="released_at" id="released_at" class='form-control <?= isset($errors['released_at']) ? 'is-invalid' : ''; ?>' placeholder="JJ-MM-AAAA" value="<?= $date ?>">
        <?php if (isset($errors['released_at'])) {
            echo '<span class="text-danger">' . $errors['released_at'] . '</span><br>';
        } ?>

        <label for="category" class="mt-3">Catégorie</label>
        <select name="category" id="category" class="form-select <?= isset($errors['category']) ? 'is-invalid' : ''; ?>">
            <option value=""></option>
            <?php foreach ($category as $cat) { ?>
                <option value=<?= $cat['name'] ?> <?= $category_select === $cat['name'] ? 'selected' : ''; ?>> <?= $cat['name'] ?> </option>
            <?php } ?>
        </select>
        <?php if (isset($errors['category'])) {
            echo '<span class="text-danger">' . $errors['category'] . '</span><br>';
        } ?>

        <div class="mx-auto row mt-3">
            <button class="btn btn-info btn-outline-dark">
                <h3>Ajouter</h3>
            </button>
        </div>


    </div>
</form>
?>


<?php require 'partials/footer.php';  ?> */


?>

<?php require 'partials/header.php'; ?>

<?php
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$cover = $_POST['cover'] ?? '';
$duration = $_POST['duration'] ?? '';
$released_at = $_POST['released_at'] ?? '';
$category_id = $_POST['category'] ?? '';
$errors = [];

//Protection contre les attaques XSS
$title = htmlspecialchars($title);
$description = htmlspecialchars($description);



// On récupère les catégories pour le select
global $db;
$categories = $db->query('SELECT * FROM category')->fetchAll();

if (!empty($_POST)) {
    if (strlen($title) < 2) {
        $errors['title'] = 'Le titre est trop court';
    }

    if (strlen($description) < 15) {
        $errors['description'] = 'La description est trop courte';
    }

    // Ici, on pourra vérifier la cover


    if ($duration < 1 || $duration > 999) {
        $errors['duration'] = 'La durée n\'est pas valide';
    }

    // Vérification de la date
    $month = formatDate($released_at, '%m');
    $day = formatDate($released_at, '%d');
    $year = formatDate($released_at, '%Y');

    if ($released_at !== formatDate($released_at, '%Y-%m-%d') || !checkdate($month, $day, $year)) {
        $errors['released_at'] = 'La date n\'est pas valide';
    }

    // Vérification de la catégorie
    if (!in_array($category_id, array_column($categories, 'id'))) {
        $errors['category'] = 'La categorie n\'est pas valide';
    }

    if (empty($errors)) {

        // Ici, on peut faire l'upload

        // Ici, on fait la requête SQL
        $query = $db->prepare(
            'INSERT INTO movie (title, description, cover, duration, released_at, category_id)
             VALUES (:title, :description, :cover, :duration, :released_at, :category_id)'
        );

        $query->bindValue(':title', $title);
        $query->bindValue(':description', $description);
        $query->bindValue(':cover', $cover);
        $query->bindValue(':duration', $duration);
        $query->bindValue(':released_at', $released_at);
        $query->bindValue(':category_id', $category_id);

        $query->execute();

        header('Location: ../film-ajout.php?success');
    }
    if (isset($_GET['success'])) {
        echo '<div class="alert alert-success dissmissable fade show ">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
             Votre catégorie à bien été ajoutée dans la BDD 
    </div>';}
}
?>

<h1>Ajouter un film</h1>

<form method="POST">
    <div class="mb-3">
        <label for="title">Titre</label>
        <input type="text" name="title" id="title"
               class="form-control <?= isset($errors['title']) ? 'is-invalid' : ''; ?>"
               value="<?= $title; ?>">

        <?php if (isset($errors['title'])) {
            echo '<span class="text-danger">'.$errors['title'].'</span>';
        } ?>
    </div>

    <div class="mb-3">
        <label for="description">Description</label>
        <textarea name="description" id="description"
            class="form-control <?= isset($errors['description']) ? 'is-invalid' : ''; ?>"
            ><?= $description;?></textarea>

        <?php if (isset($errors['description'])) {
            echo '<span class="text-danger">'.$errors['description'].'</span>';
        } ?>
    </div>

    <div class="mb-3">
        <label for="cover">Jaquette</label>
        <input type="text" name="cover" id="cover"
               class="form-control <?= isset($errors['cover']) ? 'is-invalid' : ''; ?>"
               value="<?= $cover; ?>">

        <?php if (isset($errors['cover'])) {
            echo '<span class="text-danger">'.$errors['cover'].'</span>';
        } ?>
    </div>

    <div class="mb-3">
        <label for="duration">Durée</label>
        <input type="text" name="duration" id="duration"
               class="form-control <?= isset($errors['duration']) ? 'is-invalid' : ''; ?>"
               value="<?= $duration; ?>">

        <?php if (isset($errors['duration'])) {
            echo '<span class="text-danger">'.$errors['duration'].'</span>';
        } ?>
    </div>

    <div class="mb-3">
        <label for="released_at">Date</label>
        <input type="date" name="released_at" id="released_at"
               class="form-control <?= isset($errors['released_at']) ? 'is-invalid' : ''; ?>"
               value="<?= $released_at; ?>">

        <?php if (isset($errors['released_at'])) {
            echo '<span class="text-danger">'.$errors['released_at'].'</span>';
        } ?>
    </div>

    <div class="mb-3">
        <label for="category">Catégorie</label>
        <select name="category" id="category" class="form-control <?= isset($errors['category']) ? 'is-invalid' : ''; ?>">
            <option value="">Choisir une catégorie</option>
            <?php foreach ($categories as $category) { ?>
                <option <?= ($category['id'] === $category_id) ? 'selected': ''; ?>
                    value="<?= $category['id']; ?>">
                    <?= $category['name']; ?>
                </option>
            <?php } ?>
        </select>

        <?php if (isset($errors['category'])) {
            echo '<span class="text-danger">'.$errors['category'].'</span>';
        } ?>
    </div>

    <button class="btn btn-primary">Ajouter</button>
</form>

<?php require 'partials/footer.php'; ?>
