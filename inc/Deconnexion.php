<?php
    session_start();
    session_destroy();
    session_unset();
    header('Location: ../pages/login.php');
    exit();
?>
