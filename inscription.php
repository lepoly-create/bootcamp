<?php
require "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql ="INSERT INTO Users (nom, email, password) VALUES (:nom, :email, :password)";

    $stmt = $pdo->prepare($sql);

    if($stmt->execute([
        'nom'=> $nom,
        'email'=> $email,
        'password'=> $password,
    ])){
        $succes = "Compte Créer avec succès";
    }
}




?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Inscription</h3>
                        
                        <?php if (isset($succes)): ?>
                            <div class="alert alert-success">
                                <?php echo $succes; ?>
                                <a href="index.php">Se connecter</a>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label>Nom</label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label>Mot de passe</label>
                                <input type="password" name="password" class="form-control" required> 
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100">S'inscrire</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="index.php">Déjà un compte ? Se connecter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>