<?php
session_start();
require '../inc/fonction.php';

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

$bdd = connecter_bdd();

// Récupérer les informations de l'utilisateur
$email_utilisateur = $_SESSION['user_email'];
$sql_utilisateur = "SELECT * FROM obj_membre WHERE email = '$email_utilisateur'";
$resultat_utilisateur = mysqli_query($bdd, $sql_utilisateur);
if (!$resultat_utilisateur || mysqli_num_rows($resultat_utilisateur) === 0) {
    mysqli_close($bdd);
    die("Utilisateur non trouvé.");
}
$utilisateur = mysqli_fetch_assoc($resultat_utilisateur);
$id_utilisateur = $utilisateur['id_membre'];

// Récupérer les objets empruntés par l'utilisateur
$sql_objets_empruntes = "SELECT o.id_objet, o.nom_objet, c.nom_categorie, m.nom AS nom_proprietaire
                         FROM obj_emprunt e
                         JOIN obj_objet o ON e.id_objet = o.id_objet
                         JOIN obj_categorie_objet c ON o.id_categorie = c.id_categorie
                         JOIN obj_membre m ON o.id_membre = m.id_membre
                         WHERE e.id_membre = $id_utilisateur
                         ORDER BY e.date_emprunt DESC";
$resultat_objets_empruntes = mysqli_query($bdd, $sql_objets_empruntes);
$objets_empruntes = [];
if ($resultat_objets_empruntes) {
    while ($ligne = mysqli_fetch_assoc($resultat_objets_empruntes)) {
        $objets_empruntes[] = $ligne;
    }
}

// Récupérer les objets possédés par l'utilisateur
$sql_objets_possedes = "SELECT o.id_objet, o.nom_objet, c.nom_categorie
                        FROM obj_objet o
                        JOIN obj_categorie_objet c ON o.id_categorie = c.id_categorie
                        WHERE o.id_membre = $id_utilisateur";
$resultat_objets_possedes = mysqli_query($bdd, $sql_objets_possedes);
$objets_possedes = [];
if ($resultat_objets_possedes) {
    while ($ligne = mysqli_fetch_assoc($resultat_objets_possedes)) {
        $objets_possedes[] = $ligne;
    }
}

// Récupérer les objets prêtés actuellement
$sql_objets_pretes = "SELECT o.id_objet, o.nom_objet, c.nom_categorie, m.nom AS nom_emprunteur, e.date_emprunt, e.date_retour
                      FROM obj_objet o
                      JOIN obj_categorie_objet c ON o.id_categorie = c.id_categorie
                      JOIN obj_emprunt e ON o.id_objet = e.id_objet
                      JOIN obj_membre m ON e.id_membre = m.id_membre
                      WHERE o.id_membre = $id_utilisateur AND (e.date_retour IS NULL OR e.date_retour > CURDATE())
                      ORDER BY e.date_emprunt DESC";
$resultat_objets_pretes = mysqli_query($bdd, $sql_objets_pretes);
$objets_pretes = [];
if ($resultat_objets_pretes) {
    while ($ligne = mysqli_fetch_assoc($resultat_objets_pretes)) {
        $objets_pretes[] = $ligne;
    }
}

mysqli_close($bdd);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Fiche utilisateur - <?= htmlspecialchars($utilisateur['nom']) ?></title>
    <link rel="stylesheet" href="../assets/bootstrap_css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/custom.css" />
</head>
<body>
<header>
    <nav class="container d-flex justify-content-between align-items-center">
        <a href="accueil.php" class="navbar-brand">MonSite</a>
        <ul class="nav">
            <li class="nav-item"><a href="accueil.php" class="nav-link">Accueil</a></li>
            <li class="nav-item"><a href="formulaire.php" class="nav-link">Inscription</a></li>
            <li class="nav-item"><a href="login.php" class="nav-link">Connexion</a></li>
            <li class="nav-item"><a href="../inc/Deconnexion.php" class="nav-link">Deconnexion</a></li>
        </ul>
    </nav>
</header>
<main>
    <div class="container mt-5">
        <h2>Fiche utilisateur</h2>
        <div class="card mb-4">
            <div class="card-header">
                Informations personnelles
            </div>
            <div class="card-body">
                <p><strong>Nom:</strong> <?= htmlspecialchars($utilisateur['nom']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($utilisateur['email']) ?></p>
                <p><strong>Date de naissance:</strong> <?= htmlspecialchars($utilisateur['date_naissance']) ?></p>
                <p><strong>Genre:</strong> <?= htmlspecialchars($utilisateur['genre']) ?></p>
                <p><strong>Ville:</strong> <?= htmlspecialchars($utilisateur['ville']) ?></p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                Objets empruntés
            </div>
            <div class="card-body">
                <?php if (count($objets_empruntes) > 0) { ?>
                    <ul>
                        <?php foreach ($objets_empruntes as $objet) { ?>
                            <li>
                                <?= htmlspecialchars($objet['nom_objet']) ?> (<?= htmlspecialchars($objet['nom_categorie']) ?>) - Propriétaire: <?= htmlspecialchars($objet['nom_proprietaire']) ?>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>Aucun objet emprunté.</p>
                <?php } ?>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                Objets possédés
            </div>
            <div class="card-body">
                <?php if (count($objets_possedes) > 0) { ?>
                    <ul>
                        <?php foreach ($objets_possedes as $objet) { ?>
                            <li>
                                <?= htmlspecialchars($objet['nom_objet']) ?> (<?= htmlspecialchars($objet['nom_categorie']) ?>)
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>Aucun objet possédé.</p>
                <?php } ?>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                Objets prêtés actuellement
            </div>
            <div class="card-body">
                <?php if (count($objets_pretes) > 0) { ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom de l'objet</th>
                                <th>Catégorie</th>
                                <th>Emprunteur</th>
                                <th>Date d'emprunt</th>
                                <th>Date de retour</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($objets_pretes as $objet) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($objet['nom_objet']) ?></td>
                                    <td><?= htmlspecialchars($objet['nom_categorie']) ?></td>
                                    <td><?= htmlspecialchars($objet['nom_emprunteur']) ?></td>
                                    <td><?= htmlspecialchars($objet['date_emprunt']) ?></td>
                                    <td><?= htmlspecialchars($objet['date_retour'] ?? 'Non retourné') ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>Aucun objet prêté actuellement.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<footer>
    <div class="container">
        &copy; <?= date('Y') ?> SS_emprunt.
    </div>
</footer>
</body>
</html>
