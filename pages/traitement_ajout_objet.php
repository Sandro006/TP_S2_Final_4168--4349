<?php
session_start();
require_once '../inc/fonction.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Méthode non autorisée.");
}

$id_membre = $_POST['id_membre'] ?? null;
$nom_objet = $_POST['nom_objet'] ?? '';
$id_categorie = $_POST['categorie'] ?? '';

if (!$id_membre || !$nom_objet || !$id_categorie) {
    die("Données manquantes.");
}

$bdd = connecter_bdd();

$id_membre = intval($id_membre);
$nom_objet = mysqli_real_escape_string($bdd, $nom_objet);
$id_categorie = intval($id_categorie);

// Insert new object
$sql_insert_objet = "INSERT INTO obj_objet (nom_objet, id_categorie, id_membre) VALUES ('$nom_objet', $id_categorie, $id_membre)";
if (!mysqli_query($bdd, $sql_insert_objet)) {
    mysqli_close($bdd);
    die("Erreur lors de l'insertion de l'objet: " . mysqli_error($bdd));
}

$id_objet = mysqli_insert_id($bdd);

// Handle image uploads
$default_image = '../assets/images/inconnu.png';
$uploaded_images = [];

if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
    $upload_dir = '../assets/images/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $files = $_FILES['images'];
    $num_files = count($files['name']);

    for ($i = 0; $i < $num_files; $i++) {
        if ($files['error'][$i] === UPLOAD_ERR_OK) {
            $tmp_name = $files['tmp_name'][$i];
            $original_name = basename($files['name'][$i]);
            $extension = pathinfo($original_name, PATHINFO_EXTENSION);
            $safe_name = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($original_name, PATHINFO_FILENAME));
            $new_name = $safe_name . '_' . time() . '_' . $i . '.' . $extension;
            $target_file = $upload_dir . $new_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                $uploaded_images[] = $target_file;
            }
        }
    }
}

// If no images uploaded, insert default image
if (empty($uploaded_images)) {
    $uploaded_images[] = $default_image;
}

// Insert images into obj_images_objet table
foreach ($uploaded_images as $index => $image_path) {
    $image_path_esc = mysqli_real_escape_string($bdd, $image_path);
    $sql_insert_image = "INSERT INTO obj_images_objet (id_objet, nom_image) VALUES ($id_objet, '$image_path_esc')";
    if (!mysqli_query($bdd, $sql_insert_image)) {
        mysqli_close($bdd);
        die("Erreur lors de l'insertion de l'image: " . mysqli_error($bdd));
    }
}

mysqli_close($bdd);

header('Location: accueil.php?success=1');
exit;
?>
