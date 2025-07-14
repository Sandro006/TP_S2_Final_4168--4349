<?php
session_start();
require '../inc/fonction.php';

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

$objet_id = $_GET['id'] ?? null;
if (!$objet_id) {
    header('Location: accueil.php');
    exit;
}

$bdd = connecter_bdd();

$sql = "SELECT * FROM view_objet_prop_detail
            WHERE id_objet = $objet_id ";

$result = mysqli_query($bdd, $sql);
if (!$result || mysqli_num_rows($result) === 0) {
    mysqli_close($bdd);
    die("Objet non trouvé.");
}

$objet = mysqli_fetch_assoc($result);
mysqli_close($bdd);

$objet_image = $objet['objet_image'] ?? '../assets/images/default.png';
$membre_image = $objet['membre_image'] ?? '../assets/images/default_profile.png';

// Connect to DB again to fetch borrowing history
$bdd = connecter_bdd();

$sql_emprunts = "SELECT e.date_emprunt, e.date_retour, m.nom AS emprunteur_nom
                 FROM obj_emprunt e
                 JOIN obj_membre m ON e.id_membre = m.id_membre
                 WHERE e.id_objet = $objet_id
                 ORDER BY e.date_emprunt DESC";

$result_emprunts = mysqli_query($bdd, $sql_emprunts);
$emprunts = [];
if ($result_emprunts && mysqli_num_rows($result_emprunts) > 0) {
    while ($row = mysqli_fetch_assoc($result_emprunts)) {
        $emprunts[] = $row;
    }
}
mysqli_close($bdd);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Détail de l'objet - <?= htmlspecialchars($objet['nom_objet']) ?></title>
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
        <a href="accueil.php" class="btn btn-secondary mb-4">Retour à l'accueil</a>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <img src="<?= htmlspecialchars($objet_image) ?>" class="card-img-top" alt="<?= htmlspecialchars($objet['nom_objet']) ?>" style="height: 300px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title"><?= htmlspecialchars($objet['nom_objet']) ?></h3>
                        <p class="card-text"><strong>Catégorie:</strong> <?= htmlspecialchars($objet['nom_categorie']) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Propriétaire</h4>
                    </div>
                    <div class="card-body d-flex align-items-center">
                        <img src="<?= htmlspecialchars($membre_image) ?>" alt="Photo de profil" class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
                        <div>
                            <h5 class="card-title mb-1"><?= htmlspecialchars($objet['membre_nom']) ?></h5>
                            <p class="card-text mb-0"><?= htmlspecialchars($objet['membre_email']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h4>Historique des emprunts</h4>
        <?php if (count($emprunts) > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Emprunteur</th>
                        <th>Date d'emprunt</th>
                        <th>Date de retour</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($emprunts as $emprunt): ?>
                        <tr>
                            <td><?= htmlspecialchars($emprunt['emprunteur_nom']) ?></td>
                            <td><?= htmlspecialchars($emprunt['date_emprunt']) ?></td>
                            <td><?= htmlspecialchars($emprunt['date_retour'] ?? 'Non retourné') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun emprunt pour cet objet.</p>
        <?php endif; ?>
    </div>
</main>
<footer>
        <div class="container">
            &copy; <?= date('Y') ?> SS_emprunt.
        </div>
</footer>
</body>
</html>
