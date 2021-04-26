<?php require 'partials/header.php';  ?>

<?php
global $db;
$categories = $db->query('SELECT * FROM category')->fetchAll();

?>

<?php if(isset($_GET['delete'])){ ?>
    <div class='alert alert-info dissmissable fade show'>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        La catégorie a bien été supprimée.
    </div>
<?php } ?>

<!-- On vérifie si l'utilisateur vient de modifier une catégorie (paramétre success présent ) -->
<?php if (isset($_GET['success'])){
    echo '<div class="alert alert-success dissmissable fade show ">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
             Votre catégorie à bien été modifiée dans la BDD 
    </div>';
} ?>



<table class='table'>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category) { ?>
            <tr>
                <td><?= $category['id']; ?> </td>
                <td><?= $category['name']; ?> </td>
                <td>
                    <a href="./categorie-modifier.php?id=<?=$category['id']; ?> " class='btn btn-warning'>
                        Modifier
                    </a>
                    <a href="./categorie-supprimer.php?id=<?=$category['id']; ?>" class='btn btn-danger'>
                        Supprimer
                    </a>

                </td>

            </tr>
        <?php } ?>

    </tbody>


</table>

<?php require 'partials/footer.php';  ?>