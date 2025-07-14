<?php
function connecter_bdd(){
    $bdd = mysqli_connect('localhost', 'root', '', 'Obj_emp');
    if (!$bdd) {
        die("Erreur de connexion à la base de données : " . mysqli_connect_error());
    }
    return $bdd;
}


















?>