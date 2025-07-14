<?php
function connecter_bdd(){
    $bdd = mysqli_connect('localhost', 'root', '', 'Obj_emp');
    if (!$bdd) {
        die("Erreur de connexion à la base de données : " . mysqli_connect_error());
    }
    return $bdd;
}

function inserer_membre($nom, $date_naissance, $genre, $email, $ville, $mdp, $image_profil_path) {
    $bdd = connecter_bdd();

    $email_check = mysqli_real_escape_string($bdd, $email);
    $rqt = "SELECT id_membre FROM obj_membre WHERE email = '$email_check' LIMIT 1";
    $check_result = mysqli_query($bdd, $rqt);
    if ($check_result && mysqli_num_rows($check_result) > 0) {
        mysqli_close($bdd);
        return ['success' => false, 'error' => 'Email déjà utilisé.'];
    }

    $nom = mysqli_real_escape_string($bdd, $nom);
    $date_naissance = mysqli_real_escape_string($bdd, $date_naissance);
    $genre = mysqli_real_escape_string($bdd, $genre);
    $email = mysqli_real_escape_string($bdd, $email);
    $ville = mysqli_real_escape_string($bdd, $ville);
    $mdp = mysqli_real_escape_string($bdd, $mdp);
    $image_profil_path = mysqli_real_escape_string($bdd, $image_profil_path);

    $sql = "INSERT INTO obj_membre (nom, date_naissance, genre, email, ville, mdp, image_profil) 
            VALUES ('$nom', '$date_naissance', '$genre', '$email', '$ville', '$mdp', '$image_profil_path')";

    $result = mysqli_query($bdd, $sql);

    if (!$result) {
        mysqli_close($bdd);
        return ['success' => false, 'error' => "Erreur lors de l'insertion : " . mysqli_error($bdd)];
    }

    mysqli_close($bdd);

    return ['success' => true];
}

function verifier_login($email, $mdp) {
    $bdd = connecter_bdd();

    $email = mysqli_real_escape_string($bdd, $email);

    $sql = "SELECT id_membre, nom, mdp FROM obj_membre WHERE email = '$email' ";
    $result = mysqli_query($bdd, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['mdp'];

        if ($mdp == $hashed_password) {
            mysqli_close($bdd);
            return true;
        }
    }

    mysqli_close($bdd);
    return false;
}

?>
