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
    <title>Accueil - Bienvenue <?= htmlspecialchars($user_name) ?></title>
    <link rel="stylesheet" href="../assets/bootstrap_css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/bootstrap_css/bootstrap_dark.min.css" />
   
</head>
<body>
    <div class="container mt-5">
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
            <img src="<?= htmlspecialchars($user_image)?>" alt="Photo de profil" class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
            <div>
                <h1 class="mb-0"><?= htmlspecialchars($user_name) ?>!</h1>
                <p class="mb-0 text-muted"><?= htmlspecialchars($user_email_display) ?></p>
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
    </div>
</body>
</html>
