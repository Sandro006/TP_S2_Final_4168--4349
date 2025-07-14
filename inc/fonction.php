<?php
function connecter_bdd(){
    $bdd = mysqli_connect('localhost', 'ETU004168', 'wylJNwr4', 'db_s2_ETU004168');
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

function upload_fichier($file, $dossier_destination) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Aucun fichier téléchargé ou erreur lors du téléchargement.'];
    }

    if (!is_dir($dossier_destination)) {
        if (!mkdir($dossier_destination, 0755, true)) {
            return ['success' => false, 'error' => 'Impossible de créer le dossier de destination.'];
        }
    }

    $nom_original = $file['name'];
    $extension = pathinfo($nom_original, PATHINFO_EXTENSION);
    $nom_sans_extension = pathinfo($nom_original, PATHINFO_FILENAME);

    $nom_sans_extension = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nom_sans_extension);

    $nouveau_nom = $nom_sans_extension . '_' . time() . '.' . $extension;

    $chemin_destination = rtrim($dossier_destination, '/') . '/' . $nouveau_nom;

    if (move_uploaded_file($file['tmp_name'], $chemin_destination)) {
        return ['success' => true, 'path' => $chemin_destination];
    } else {
        return ['success' => false, 'error' => 'Erreur lors du déplacement du fichier téléchargé.'];
    }
}

function upload_avec_id($file, $dossier_destination, $id) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Aucun fichier téléchargé ou erreur lors du téléchargement.'];
    }

    if (!is_dir($dossier_destination)) {
        if (!mkdir($dossier_destination, 0755, true)) {
            return ['success' => false, 'error' => 'Impossible de créer le dossier de destination.'];
        }
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $nouveau_nom = $id . '.' . $extension;
    $chemin_destination = rtrim($dossier_destination, '/') . '/' . $nouveau_nom;

    if (move_uploaded_file($file['tmp_name'], $chemin_destination)) {
        $bdd = connecter_bdd();
        $chemin_bdd = mysqli_real_escape_string($bdd, $chemin_destination);
        $id_esc = intval($id);

        $sql = "UPDATE obj_membre SET image_profil = '$chemin_bdd' WHERE id_membre = $id_esc";
        $result = mysqli_query($bdd, $sql);
        mysqli_close($bdd);

        if ($result) {
            return ['success' => true, 'path' => $chemin_destination];
        } else {
            return ['success' => false, 'error' => 'Erreur lors de la mise à jour du chemin dans la base de données.'];
        }
    } else {
        return ['success' => false, 'error' => 'Erreur lors du déplacement du fichier téléchargé.'];
    }
}

function lister_objets_par_categorie($categorie) {
    $bdd = connecter_bdd();
    $categorie_esc = mysqli_real_escape_string($bdd, $categorie);

    $sql = "SELECT * FROM  view_objet_detail
            WHERE nom_categorie = '$categorie_esc'";

    $result = mysqli_query($bdd, $sql);
    $objets = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $objets[] = $row;
        }
    }
    mysqli_close($bdd);
    return $objets;
}
