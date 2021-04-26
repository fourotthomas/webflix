<?php require 'partials/header.php';  ?>

<?php 
//Ici on récupére la catégorie qu'on modifie dans la bdd
$id = $_GET['id'] ?? 0;

global $db;
$query=$db->prepare('SELECT * FROM category WHERE id = :id');
$query->bindValue(':id', $id);
$query-> execute();
$category = $query ->fetch();

//Si la catégorie n'existe pas, on renvoie une 404
if(!$category){
    require'partials/404.php';
}

//tips : $_REQUEST regroupe $_POST et $_GET
$name = $_POST['name'] ?? $category['name'];
$errors = [];

if (!empty($_POST)){
    //On vérifie que le nom de la catégorie fasse au moins 2 caractéres
    if (strlen($name) <2 ){
        $errors['name'] = 'Le nom est trop court';
    }

    
    if(empty($errors)){
        //Ici on fait le insert
        /** @var PDO $db */   // le @var permet l'autocompletion, A ECRIRE TEL QUEL ATTENTION
        $query = $db->prepare('UPDATE category SET name = :name WHERE id = :id');
        $query->bindValue(':name', $name);
        $query->execute();

        //Idéalement, on peut faire une redirection après avoir modifié la catégorie
        //Evite que l'utilisateur n'envoie le formulaire avec F5 (ce con)
        header('Location: categorie-liste.php?success');

    }
}


?>


<h1>Modifier la catégorie <?= $category['name']; ?> </h1>

<form method="POST">
    <div class="mb-3">
        <label for="name">Nom</label>
        <input type="text" name="name" id="name" class="form-control <?= isset($errors['name']) ? 'is-invalid' : ''; ?> ">
<?php if (isset($errors['name'])){
    echo '<span class="text-danger">'.$errors['name'].'</span>' ;
} ?>

    </div>
    <button class="btn btn-info btn-outline-dark">Modifier</button>
</form>


<?php require 'partials/footer.php';  ?>