<?php require 'partials/header.php';  ?>

<?php 
$name = $_POST['name'] ?? '';
$errors = [];

if (!empty($_POST)){
    //On vérifie que le nom de la catégorie fasse au moins 2 caractéres
    if (strlen($name) <2 ){
        $errors['name'] = 'Le nom est trop court';
    }

    //Après avoir vérifié les erreurs, s'il n'y en a pas on ajoute la catégorie dans la BDD
    if(empty($errors)){
        //Ici on fait le insert
        /** @var PDO $db */   // le @var permet l'autocompletion, A ECRIRE TEL QUEL ATTENTION
        $query = $db->prepare('INSERT INTO category (name) VALUES (:name)');
        $query->bindValue(':name', $name);
        $query->execute();

        //Idéalement, on peut faire une redirection après avoir inséré la catégorie
        //Evite que l'utilisateur n'envoie le formulaire avec F5 (ce con)
        header('Location: categorie-ajout.php?success');

    }
}
//On vérifie si l'utilisateur vient d'ajouter une catégorie (paramétre success présent )
if (isset($_GET['success'])){
    echo '<div class="alert alert-success dissmissable fade show ">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
             Votre catégorie à bien été ajoutée dans la BDD 
    </div>';
}

?>


<h1>Ajouter une catégorie</h1>

<form method="POST">
    <div class="mb-3">
        <label for="name">Nom</label>
        <input type="text" name="name" id="name" class="form-control <?= isset($errors['name']) ? 'is-invalid' : ''; ?> ">
<?php if (isset($errors['name'])){
    echo '<span class="text-danger">'.$errors['name'].'</span>' ;
} ?>

    </div>
    <button class="btn btn-info btn-outline-dark">Ajouter</button>
</form>


<?php require 'partials/footer.php';  ?>