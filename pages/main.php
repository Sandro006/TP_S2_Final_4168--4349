<?php
require_once '../inc/fonction.php';

$categorie = $_GET['categorie'] ?? '';

if (!$categorie) {
    header('Location: accueil.php');
    exit();
}

$objets = lister_objets_par_categorie($categorie);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Objets - <?= htmlspecialchars($categorie) ?></title>
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
    <main class="container mt-5">
        <h2 class="mb-4">Objets de la catégorie: <?= htmlspecialchars($categorie) ?></h2>
        <div class="object-card">
            <?php
            if (empty($objets)) {
                echo '<p>Aucun objet trouvé dans cette catégorie.</p>';
            } else {
                foreach ($objets as $objet) {
                    $image_path = '../assets/images/default.png';
                    if (!empty($objet['nom_image'])) {
                        $image_path = $objet['nom_image'];
                    }
                    echo '<div class="card">';
                    echo '<img src="' . htmlspecialchars($image_path) . '" alt="' . htmlspecialchars($objet['nom_objet']) . '" class="card-img-top" />';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($objet['nom_objet']) . '</h5>';
                    echo '<p class="card-text">Propriétaire: ' . htmlspecialchars($objet['nom_membre']) . '</p>';
                    
                    echo '</div></div>';
                }
            }
            ?>
        </div>
        <a href="accueil.php" class="btn btn-secondary mt-3">Retour aux catégories</a>
    </main>
    <footer>
        <div class="container">
            &copy; <?= date('Y') ?> SS_emprunt.
        </div>
    </footer>
</body>
</html>
wylJNwr4