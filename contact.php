<?php


$title= 'Nous contacter'; //Variable pour changer le titre ( à mettre avant le header )


require __DIR__.'/partials/header.php'; ?>
<?php // require_once 'partials/header.php'; // Pour être sûr qu'il ne soit présent qu'une seule fois ?>
<?php // include 'partials/header.php'; ?>

<div class="container">
    <h1>Nous contacter</h1>


    <?php

    $email = $_POST['email'] ?? '';
    $sujet = $_POST['sujet'] ?? '';
    $message = $_POST['message'] ?? '';

    $email = htmlspecialchars($email);
    $sujet = htmlspecialchars($sujet);
    $message = htmlspecialchars($message);

    $errors = [];
        if (!empty($_POST) && isset($_POST['contact'])) {
            if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'L\'email n\'est pas valide';
            }

        
            if ($sujet === '') {
                $errors['sujet'] = 'Choisissez un sujet';
            }

            
            if (strlen($message) < 15) {
                $errors['message'] = 'Le message est trop court';
            }

        }

    ?>



    <form method="post" action="">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control  <?= isset($errors['email']) ? 'is-invalid' : ''; ?>" value="<?= $email; ?>">
            <?php if (isset($errors['email'])) {
                    echo '<span class="text-danger">'.$errors['email'].'</span>';
                } ?>

        </div>

        <div class="form-group">
            <label for="sujet">Sujet</label>
            <select name="sujet" id="sujet" class="form-select  <?= isset($errors['sujet']) ? 'is-invalid' : ''; ?>">
                <option value=""></option>
                <option value="proposition de stage">Proposition de stage</option>
                <option value="proposition d'emploi">Proposition d'emploi</option>
                <option value="demande de projet">Demande de projet</option>
            </select>
            <?php if (isset($errors['sujet'])) {
                    echo '<span class="text-danger">'.$errors['sujet'].'</span>';
                } ?>

        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" id="message" class="form-control  <?= isset($errors['message']) ? 'is-invalid' : ''; ?>" ><?= $message; ?></textarea>
            <?php if (isset($errors['message'])) {
                    echo '<span class="text-danger">'.$errors['message'].'</span>';
                } ?>

        </div>

        <div>
        <button class="btn btn-success" name="contact">Envoyez</button>
        
        </div>
        <div>
        <?php
            if (!empty($_POST) && empty($errors) && isset($_POST['contact'])) { 
                echo "Bonjour $email, votre requête pour une $sujet à bien été envoyée avec le message : <p> $message </p>";
            }
        ?>
        </div>

    </form>


</div>





<?php require 'partials/footer.php'; ?>
