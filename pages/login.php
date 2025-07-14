<?php
// Revised login page with Bootstrap styling and error message display
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="../assets/bootstrap_css/bootstrap.min.css" />
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Connexion</h1>
        <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
            <div class="alert alert-danger" role="alert">
                Email ou mot de passe incorrect.
            </div>
        <?php endif; ?>
        <form action="traitement_login.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required />
            </div>

            <div class="mb-3">
                <label for="mdp" class="form-label">Mot de passe:</label>
                <input type="password" class="form-control" id="mdp" name="mdp" required />
            </div>

            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</body>
</html>
