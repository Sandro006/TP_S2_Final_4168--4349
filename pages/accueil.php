<?php
session_start();
require '../inc/fonction.php';

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

$user_email = $_SESSION['user_email'];

$bdd = connecter_bdd();
$email_esc = mysqli_real_escape_string($bdd, $user_email);
$sql = "SELECT nom FROM obj_membre WHERE email = '$email_esc' LIMIT 1";
$result = mysqli_query($bdd, $sql);
$user_name = '';
if ($result && mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $user_name = $row['nom'];
}
mysqli_close($bdd);

$categories = [
    ['name' => 'cuisine', 'image' => '../assets/images/cuisine.png'],
    ['name' => 'bricolage', 'image' => '../assets/images/bricolage.png'],
    ['name' => 'mecanique', 'image' => '../assets/images/mecanique.png'],
    ['name' => 'esthetique', 'image' => '../assets/images/esthetique.png'],
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Accueil-<?= htmlspecialchars($user_name) ?></title>
    <link rel="stylesheet" href="../assets/bootstrap_css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/custom.css" />
</head>
<body>
    <header>
        <nav class="container d-flex justify-content-between align-items-center">
            <a href="accueil.php" class="navbar-brand">SS_emprunt</a>
            <ul class="nav">
                <li class="nav-item"><a href="accueil.php" class="nav-link">Accueil</a></li>
                <li class="nav-item"><a href="formulaire.php" class="nav-link">Inscription</a></li>
                <li class="nav-item"><a href="login.php" class="nav-link">Connexion</a></li>
                <li class="nav-item"><a href="../inc/Deconnexion.php" class="nav-link">Deconnexion</a></li>
            </ul>
            <a href="ajouter_objet.php" class="btn btn-danger mb-3 float-end">Ajouter un objet</a>
        </nav>
    </header>
    <main class="container mt-5">
        <div class="d-flex align-items-center mb-4">
            <?php
            $bdd = connecter_bdd();
            $email_esc = mysqli_real_escape_string($bdd, $user_email);
            $sql = "SELECT nom, email, image_profil FROM obj_membre WHERE email = '$email_esc' LIMIT 1";
            $result = mysqli_query($bdd, $sql);
            $user_name = '';
            $user_email_display = '';
            $user_image = '../assets/images/default_profile.png';
            if ($result && mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $user_name = $row['nom'];
                $user_email_display = $row['email'];
                if (!empty($row['image_profil']) && file_exists($row['image_profil'])) {
                    $user_image = $row['image_profil'];
                }
            }
            mysqli_close($bdd);
            ?>
            <img src="<?= $user_image?>" alt="Photo de profil" class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
            <div>
                <a href="fiche.php">
                <h1 class="mb-0">@<?= $user_name  ?></h1>
                <p class="mb-0 "><?= $user_email_display ?></p>
            </a>
            </div>
            <div>
                
            </div>
        </div>

        <h2 class="mb-4 mt-4">Catégories</h2>
        <div class="row mb-5">
            <?php foreach ($categories as $cat) { ?>
                <div class="col-md-3 mb-4">
                    <a href="main.php?categorie=<?= $cat['name'] ?>" class="text-decoration-none text-dark">
                        <div class="card category-card text-center shadow-sm h-100">
                            <img src="<?= $cat['image'] ?>" class="card-img-top category-img" alt="<?= htmlspecialchars($cat['name']) ?>" style="height: 150px; object-fit: cover;">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <h5 class="card-title"><?= htmlspecialchars($cat['name']) ?></h5>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
        <?php
        $bdd = connecter_bdd();

        //objet et Statut avec date de disponibilité
        // date d'emprunt + nbr de jour d'emprunt
        $sql_all_objets = "SELECT o.*, 
            CASE WHEN EXISTS (
                SELECT 1 FROM obj_emprunt e 
                WHERE e.id_objet = o.id_objet AND (e.date_retour IS NULL OR e.date_retour > CURDATE())
            ) THEN 0 ELSE 1 END AS disponible, 
            (SELECT MIN(e2.date_retour) FROM obj_emprunt e2 WHERE e2.id_objet = o.id_objet AND e2.date_retour > CURDATE()) AS date_disponible,
            m.nom AS nom_membre, c.nom_categorie AS nom_categorie, o.id_objet AS id_objet
            FROM obj_objet o
            JOIN obj_categorie_objet c ON o.id_categorie = c.id_categorie
            JOIN obj_membre m ON o.id_membre = m.id_membre
            LEFT JOIN obj_images_objet i ON o.id_objet = i.id_objet";
        $result_all_objets = mysqli_query($bdd, $sql_all_objets);
        $all_objets = [];
        if ($result_all_objets) {
            while ($row = mysqli_fetch_assoc($result_all_objets)) {
                $all_objets[] = $row;
            }
        }
        mysqli_close($bdd);
        ?>

        <h2 class="mb-4 mt-4">Tous les objets</h2>
        <form id="filterForm" class="mb-3" method="GET" action="accueil.php">
            <div class="mb-3">
                <label for="filterCategory" class="form-label">Filtrer par catégorie:</label>
                <select id="filterCategory" name="filterCategory" class="form-select" aria-label="Filtrer par catégorie">
                    <option value="all" <?= (isset($_GET['filterCategory']) && $_GET['filterCategory'] === 'all') ? 'selected' : '' ?>>Tous</option>
                    <?php foreach ($categories as $cat) {
                        $cat_name_filter = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $cat['name']));
                        $cat_name_filter = preg_replace('/[^a-z]/', '', $cat_name_filter);
                        $selected = (isset($_GET['filterCategory']) && $_GET['filterCategory'] === $cat_name_filter) ? 'selected' : '';
                    ?>
                        <option value="<?= htmlspecialchars($cat_name_filter) ?>" <?= $selected ?>><?= htmlspecialchars($cat['name']) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="filterName" class="form-label">Trier par nom:</label>
                <select id="filterName" name="filterName" class="form-select" aria-label="Trier par nom">
                    <option value="none" <?= (!isset($_GET['filterName']) || $_GET['filterName'] === 'none') ? 'selected' : '' ?>>Aucun</option>
                    <option value="asc" <?= (isset($_GET['filterName']) && $_GET['filterName'] === 'asc') ? 'selected' : '' ?>>A à Z</option>
                    <option value="desc" <?= (isset($_GET['filterName']) && $_GET['filterName'] === 'desc') ? 'selected' : '' ?>>Z à A</option>
                </select>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="filterAvailable" name="filterAvailable" <?= (isset($_GET['filterAvailable']) && $_GET['filterAvailable'] == '1') ? 'checked' : '' ?> />
                <label class="form-check-label" for="filterAvailable">
                    Afficher uniquement les objets disponibles
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Appliquer le filtre</button>
        </form>
        <div class="d-flex flex-wrap" id="objectsContainer">
            <?php
            $filtered_objets = $all_objets;
            if (isset($_GET['filterCategory']) && $_GET['filterCategory'] !== 'all') {
                $filtered_objets = array_filter($filtered_objets, function($obj) {
                    $cat_name_filter = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $obj['nom_categorie']));
                    $cat_name_filter = preg_replace('/[^a-z]/', '', $cat_name_filter);
                    return $cat_name_filter === $_GET['filterCategory'];
                });
            }
            if (isset($_GET['filterAvailable']) && $_GET['filterAvailable'] == '1') {
                $filtered_objets = array_filter($filtered_objets, function($obj) {
                    return ($obj['disponible'] ?? 1) == 1;
                });
            }
            if (isset($_GET['filterName']) && in_array($_GET['filterName'], ['asc', 'desc'])) {
                usort($filtered_objets, function($a, $b) {
                    $nameA = strtolower($a['nom_objet']);
                    $nameB = strtolower($b['nom_objet']);
                    if ($nameA == $nameB) return 0;
                    if ($_GET['filterName'] === 'asc') {
                        return ($nameA < $nameB) ? -1 : 1;
                    } else {
                        return ($nameA > $nameB) ? -1 : 1;
                    }
                });
            }
            foreach ($filtered_objets as $objet) {
                $image_path = '../assets/images/default.png';
                if (!empty($objet['nom_image'])) {
                    $image_path = $objet['nom_image'];
                }
                $cat_name = $objet['nom_categorie'];
                $cat_name_filter = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $cat_name));
                $cat_name_filter = preg_replace('/[^a-z]/', '', $cat_name_filter);
                $disponible = $objet['disponible'] ?? 1;
            ?>
                <div class="card object-card me-3" data-category="<?= htmlspecialchars($cat_name_filter) ?>" data-name="<?= htmlspecialchars(strtolower($objet['nom_objet'])) ?>" data-available="<?= $disponible ?>" style="width: 18rem; margin-bottom: 1rem;">
                    <a href="objet_detail.php?id=<?= urlencode($objet['id_objet']) ?>" class="text-decoration-none text-dark">
                        <img src="<?= htmlspecialchars($image_path) ?>" alt="<?= htmlspecialchars($objet['nom_objet']) ?>" class="card-img-top" style="height: 180px; object-fit: cover;" />
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($objet['nom_objet']) ?></h5>
                            <p class="card-text">Propriétaire: <?= htmlspecialchars($objet['nom_membre']) ?></p>
                            <p class="card-text"><small class="text-muted"><?= htmlspecialchars($cat_name) ?></small></p>
                            <p class="card-text">
                                <strong>Status: </strong>
                                <?php if (($objet['disponible'] ?? 1) == 1) { ?>
                                    <span class="text-success">Disponible</span>
                                <?php } else { 
                                    $date_dispo = $objet['date_disponible'];
                                    echo $date_dispo;
                                    if ($date_dispo) {
                                        $date_formatted = date('d-m-Y', strtotime($date_dispo));
                                        echo "<span class='text-danger'>Emprunté - Disponible le $date_formatted</span>";
                                    } else {
                                        ?>
                                        <span class='text-danger'>Emprunté <?= $date_dispo ?></span>
                                    <?php
                                    }
                                } ?>
                            </p>
                            <p class="card-text"><a href="emprunt.php?id=<?= $objet['id_objet'] ?>" class="btn btn-secondary mb-4">Emprunter cette objet ?</a>
                            </p>
                            <?php if (($objet['disponible'] ?? 1) == 0 && !empty($objet['date_disponible'])) {
                                $date_retour_formatted = date('d-m-Y', strtotime($objet['date_disponible']));
                            ?>
                                <p class="card-text"><strong>Date de retour:</strong> <?= htmlspecialchars($date_retour_formatted) ?></p>
                            <?php } ?>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>

    </main>
    <footer>
        <div class="container">
            &copy; <?= date('Y') ?> SS_emprunt.
        </div>
    </footer>
</body>
</html>
