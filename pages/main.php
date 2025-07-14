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
    <style>
        .object-card {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .card {
            width: 18rem;
        }
        .card-img-top {
            height: 180px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Objets de la catégorie: <?= htmlspecialchars($categorie) ?></h2>
        <div class="object-card">
            <?php
            if (empty($objets)) {
                echo '<p>Aucun objet trouvé dans cette catégorie.</p>';
            } else {
                foreach ($objets as $objet) {
                    $image_path = '../assets/images/default.png';
                    if (!empty($objet['nom_image'])) {
                        // Ensure the image path is relative to the web root
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
    </div>
</body>
</html>
