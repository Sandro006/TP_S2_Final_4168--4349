<?php
session_start();
require_once '../inc/fonction.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $mdp = $_POST['mdp'] ?? '';

    if (verifier_login($email, $mdp)) {
        // Set session or cookie as needed
        $_SESSION['user_email'] = $email;
        
        header('Location: accueil.php');
        exit;
    } else {
        // Redirect back to login with error
        header('Location: login.php?error=1');
        exit;
    }
} else {
    die("Méthode non autorisée.");
}
?>
