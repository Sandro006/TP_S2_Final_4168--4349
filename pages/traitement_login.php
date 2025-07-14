<?php
session_start();
require_once '../inc/fonction.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $mdp = $_POST['mdp'] ?? '';

    if (verifier_login($email, $mdp)) {
        $_SESSION['user_email'] = $email;

        header('Location: accueil.php');
        exit;
    } else {
        header('Location: login.php?error=1');
        exit;
    }
} else {
    die("Méthode non autorisée.");
}
?>
