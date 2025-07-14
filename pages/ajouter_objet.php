<?php
session_start();
require '../inc/fonction.php';

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

$bdd = connecter_bdd();
$user_email = $_SESSION['user_email'];
$email_esc = mysqli_real_escape_string($bdd, $user_email);
$sql = "SELECT id_membre, nom FROM obj_membre WHERE email = '$email_esc' LIMIT 1";
$result = mysqli_query($bdd, $sql);
if (!$result || mysqli_num_rows($result) !== 1) {
    mysqli_close($bdd);
    die("Utilisateur non trouvé.");
}
$user = mysqli_fetch_assoc($result);
$user_id = $user['id_membre'];
$user_name = $user['nom'];

$sql_cat = "SELECT id_categorie, nom_categorie FROM obj_categorie_objet";
$result_cat = mysqli_query($bdd, $sql_cat);
$categories = [];
if ($result_cat) {
    while ($row = mysqli_fetch_assoc($result_cat)) {
        $categories[] = $row;
    }
}
mysqli_close($bdd);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ajouter un objet</title>
    <link rel="stylesheet" href="../assets/bootstrap_css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/custom.css" />
</head>
<body>
    <div class="container mt-5">
        <h1>Ajouter un nouvel objet</h1>
        <form action="traitement_ajout_objet.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_membre" value="<?= htmlspecialchars($user_id) ?>" />
            <div class="mb-3">
                <label for="nom_objet" class="form-label">Nom de l'objet:</label>
                <input type="text" class="form-control" id="nom_objet" name="nom_objet" required />
            </div>
            <div class="mb-3">
                <label for="categorie" class="form-label">Catégorie:</label>
                <select class="form-select" id="categorie" name="categorie" required>
                    <option value="">--Choisir une catégorie--</option>
                    <?php foreach ($categories as $cat) { ?>
                        <option value="<?= htmlspecialchars($cat['id_categorie']) ?>"><?= htmlspecialchars($cat['nom_categorie']) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="images" class="form-label">Images (vous pouvez en sélectionner plusieurs):</label>
                <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple />
            </div>
            <button type="submit" class="btn btn-primary">Ajouter l'objet</button>
            <a href="accueil.php" class="btn btn-secondary ms-2">Annuler</a>
        </form>
    </div>
</body>
</html>
