<?php 

$title = 'Les catégories';

require './partials/header.php';

global $db;

$query = $db->query('SELECT * FROM category ');
$categories = $query->fetchAll();


if (!$categories) {
    require 'partials/404.php';
}
?>

<div class="container">
    <div class="row">
        <?php 
        foreach($categories as $category){ ?>

            <div class="text-center d-grid gap-2 mt-4">
                <a href="./categorie.php?id=<?= $category['id']; ?>" class="btn btn-dark btn-outline-info btn-lg"> <?= $category['name']; ?> </a>
            </div>
            
        <?php } ?>
        
        
        
        
    </div>
</div>




<?php 

require './partials/footer.php' ; 
?>