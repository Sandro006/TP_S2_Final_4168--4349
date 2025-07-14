<?php
// Simple form page for member data input
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Formulaire Membre</title>
    <link rel="stylesheet" href="../assets/bootstrap_css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Formulaire Membre Pour emprunt_SS</h1>
        <p><a href="login.php">Cliquez-ici</a> si vous avez déjà un compte</p>
        <form action="traitement_insc.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom:</label>
                <input type="text" class="form-control" id="nom" name="nom" required />
            </div>

            <div class="mb-3">
                <label for="date_naissance" class="form-label">Date de naissance:</label>
                <input type="date" class="form-control" id="date_naissance" name="date_naissance" required />
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Genre:</label>
                <select class="form-select" id="genre" name="genre" required>
                    <option value="">--Choisir--</option>
                    <option value="M">Masculin</option>
                    <option value="F">Féminin</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required />
            </div>

            <div class="mb-3">
                <label for="ville" class="form-label">Ville:</label>
                <input type="text" class="form-control" id="ville" name="ville" />
            </div>

            <div class="mb-3">
                <label for="mdp" class="form-label">Mot de passe:</label>
                <input type="password" class="form-control" id="mdp" name="mdp" required />
            </div>

            <div class="mb-3">
                <label for="image_profil" class="form-label">Image de profil:</label>
                <input type="file" class="form-control" id="image_profil" name="image_profil" accept="image/*" />
            </div>

            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
</body>
</html>
