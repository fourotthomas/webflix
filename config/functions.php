<?php
//Ici on va déclarer toutes les fonctions utiles au site

/**
 * Permet de convertir des minutes en heures
 * Exemple: 145 devient 2h25
 */
function convertToHours($duration) {
    $hours = floor($duration / 60); // 2.40 devient 2
    $minutes = $duration % 60; // 25
    $minutes = str_pad($minutes, 2, 0, STR_PAD_LEFT); // 2 devient 02
    // Méthode alternative
    // if ($minutes < 10) {
    //    $minutes = '0'.$minutes;
    // }

    // Méthode alternative 2
    // date('i\hs', $duration);

    return $hours.'h'.$minutes;
}

/**
 * Formate une date au format US en FR
 * 1985-10-15 -> 1574124485 -> 15 octobre 1985 ou octobre 1985
 */
function formatDate($date, $format = '%d %B %Y') {
    setlocale(LC_ALL, 'fr.utf-8');

    return strftime($format, strtotime($date));
}


/**
 * permet de savoir si je suis un admin ou pas
 */
function isAdmin(){
    global $db;

    $admins = ['M1593201513@hotmail.fr', 'client@client.com']; //Tableau des emails des admins
    $user = $_SESSION['user'] ?? false; 

    //On va rafraichir la session avec la BDD au cas ou on changerai le role d'un utilisateur alors qu'il est connecté
    if ($user){
        $_SESSION['user'] = $db->query('SELECT * FROM user WHERE id = '.$user['id'])->fetch();
        $user = $_SESSION['user'];
    }


    if ($user && in_array($user['email'], $admins)){
        return true; //La fonction s'arréte et retourne true si l'utilisateur est un admin
    }

    //Pour rendre cette partie plus dynamique, on peut ajouter une colonne rôle sur la table user
    //Par défaut, un inscrit aura la rôle "user"
    //Sur le dashboard, on pourrait ajouter une page listant les utilisateurs et permettant de changer son rôle
    //On aura donc une action "promouvoir en admin" où il faudra faire un UPDATE sur le user dans la table pour changer son rôle en "admin"
    //On pourra ensuite ajouter un if dans cette fonction pour vérifier si le rôle du user est bien admin
    if ($user && $user['role']=== 'admin'){
        return true;
    }


    return false; //Le user n'est pas admin
}