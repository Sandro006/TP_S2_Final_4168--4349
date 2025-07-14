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
    <title>Accueil<?= htmlspecialchars($user_name) ?></title>
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
                <h1 class="mb-0">@<?= $user_name  ?></h1>
                <p class="mb-0 "><?= $user_email_display ?></p>
            </div>
            <div>
                
            </div>
        </div>

        <h2 class="mb-4 mt-4">Catégories</h2>
        <div class="row mb-5">
            <?php foreach ($categories as $cat) { ?>
                <div class="col-md-3 mb-4">
                    <a href="main.php?categorie=<?= urlencode($cat['name']) ?>" class="text-decoration-none text-dark">
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
    </main>
    <footer>
        <div class="container">
            &copy; <?= date('Y') ?> SS_emprunt.
        </div>
    </footer>
</body>
</html>
