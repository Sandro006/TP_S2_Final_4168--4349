<?php
require_once '../inc/fonction.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $email = $_POST['email'] ?? '';
    $ville = $_POST['ville'] ?? '';
    $mdp = $_POST['mdp'] ?? '';

    $image_profil_path = '';
    if (isset($_FILES['image_profil']) && $_FILES['image_profil']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../assets/images/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $tmp_name = $_FILES['image_profil']['tmp_name'];
        $filename = basename($_FILES['image_profil']['name']);
        $target_file = $upload_dir . $filename;

        if (move_uploaded_file($tmp_name, $target_file)) {
            $image_profil_path = 'assets/images/' . $filename;
        } else {
            die("Erreur lors du téléchargement de l'image.");
        }
    }

    $result = inserer_membre($nom, $date_naissance, $genre, $email, $ville, $mdp, $image_profil_path);

    if ($result['success']) {
        header('Location: formulaire.php?success=1');
        exit;
    } else {
        die("Erreur lors de l'insertion du membre : " . $result['error']);
    }
} else {
    die("Méthode non autorisée.");
}
?>
