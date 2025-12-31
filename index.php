<?php

session_start();
require_once "db.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'email'=> $email
    ]);

    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];

        header('location: produits.php');
        exit();
    }else{
        $erreur = "Email ou le mot de passe incorrect";
    }
}





?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Connexion</h3>
                        
                        <?php if (isset($erreur)): ?>
                            <div class="alert alert-danger"><?php echo $erreur; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label>Mot de passe</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="inscription.php">Créer un compte</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>