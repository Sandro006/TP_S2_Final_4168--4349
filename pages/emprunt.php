<?php
session_start();
require '../inc/fonction.php';

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

$bdd = connecter_bdd();

if (!isset($_GET['id'])) {
    echo "Objet non spécifié.";
    exit;
}

$id_objet = intval($_GET['id']);
$user_email = $_SESSION['user_email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jours = intval($_POST['jours']);

        $email_esc = mysqli_real_escape_string($bdd, $user_email);
        $sql_user = "SELECT id_membre FROM obj_membre WHERE email = '$email_esc' LIMIT 1";
        $result_user = mysqli_query($bdd, $sql_user);
        if ($result_user && mysqli_num_rows($result_user) === 1) {
            $row_user = mysqli_fetch_assoc($result_user);
            $id_membre = $row_user['id_membre'];
        // date de retour = date d'emprunt + nbr de jour d'emprunt

            $sql_check = "SELECT 1 FROM obj_emprunt WHERE id_objet = $id_objet AND (date_retour IS NULL OR date_retour > CURDATE()) LIMIT 1";
            $result_check = mysqli_query($bdd, $sql_check);
            if ($result_check && mysqli_num_rows($result_check) > 0) {
                $error = "Cet objet est déjà emprunté.";
            } else {
                $date_emprunt = date('Y-m-d');
                $date_retour = date('Y-m-d', strtotime("+$jours days"));
                $sql_insert = "INSERT INTO obj_emprunt (id_objet, id_membre, date_emprunt, date_retour) VALUES ($id_objet, $id_membre, '$date_emprunt', '$date_retour')";
                if (mysqli_query($bdd, $sql_insert)) {
                    $success = "Emprunt enregistré avec succès. Vous serez remboursé le $date_retour.";
                } else {
                    $error = "Erreur lors de l'enregistrement de l'emprunt.";
                }
            }
        } else {
            $error = "Utilisateur non trouvé.";
        }
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Emprunt</title>
    <link rel="stylesheet" href="../assets/bootstrap_css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/custom.css" />
</head>
<body>
    <div class="container mt-5">
        <h1>Emprunter l'objet</h1>
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php } ?>
        <?php if (isset($success)) { ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <a href="accueil.php" class="btn btn-primary">Retour à l'accueil</a>
        <?php } else { ?>
            <form method="POST" action="emprunt.php?id=<?= $id_objet ?>">
                <div class="mb-3">
                    <label for="jours" class="form-label">Nombre de jours d'emprunt:</label>
                    <input type="number" id="jours" name="jours" class="form-control" required />
                </div>
                <button type="submit" class="btn btn-primary">Emprunter</button>
                <a href="accueil.php" class="btn btn-secondary">Annuler</a>
            </form>
        <?php } ?>
    </div>
</body>
</html>
