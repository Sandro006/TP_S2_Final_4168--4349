<?php
// Revised login page with Bootstrap styling and error message display
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link rel="stylesheet" href="../assets/bootstrap_css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/custom.css" />
</head>
<body>
    <header>
        <br>
        <h1 class="mb-4">SS_emprunt</h1>        
    </header>
    <main class="container mt-5">
        <h1 class="mb-4">Connexion</h1>
        <?php if (isset($_GET['error']) && $_GET['error'] == 1){ ?>
            <div class="alert alert-danger" role="alert">
                Email ou mot de passe incorrect.
            </div>
        <?php } ?>
        <p><a href="formulaire.php">Cliquez-ici</a> si vous n'avez pas encore de compte</p>       
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
    </main>
    <footer>
        <div class="container">
            &copy; <?= date('Y') ?> SS_emprunt.
        </div>
    </footer>
</body>
</html>
