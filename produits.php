<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: index.php');
    exit();
}

require "db.php";

// Ajouter un produit

if (isset($_POST['ajouter'])) {
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];

    $sql = "INSERT INTO Produits(nom, prix, quantite) VALUES (:nom, :prix, :quantite)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nom' => $nom,
        'prix' => $prix,
        'quantite' => $quantite,
    ]);

    $message = "Produit ajouté";
}

// Afficher les produits

$sql = "SELECT * FROM Produits";
$produits = $pdo->query($sql)->fetchAll();


// Récupérer le produits à modifier

$produit_a_modifier = null;

if (isset($_GET['modifier'])) {
    $id = $_GET['modifier'];

    $sql = "SELECT * FROM Produits WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id' => $id
    ]);

    $produit_a_modifier = $stmt->fetch();
}

// Modifier un produit

if (isset($_POST['modifier'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];

    $sql = "UPDATE Produits SET nom= :nom, prix= :prix, quantite= :quantite WHERE id= :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id' => $id,
        'nom' => $nom,
        'prix' => $prix,
        'quantite' => $quantite
    ]);

    $message = "Produit modifier";
}

// Supprimer un produit

if (isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];
    $sql = "DELETE FROM Produits WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id' => $id
    ]);

    $message = "Produit supprimé";
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-4">

        <!-- En-tête -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>🛍️ Gestion des Produits</h2>
            <div>
                <span class="me-3">Bonjour, <?php echo $_SESSION['user_nom']; ?></span>
                <a href="deconnexion.php" class="btn btn-danger btn-sm">Déconnexion</a>
            </div>
        </div>

        <!-- Message de succès -->
        <?php if (isset($message)): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Formulaire Ajouter/Modifier -->
        <div class="card mb-4">
            <div class="card-body">
                <h5><?php echo $produit_a_modifier ? 'Modifier le produit' : 'Ajouter un produit'; ?></h5>

                <form method="POST" class="row g-3">
                    <?php if ($produit_a_modifier): ?>
                        <input type="hidden" name="id" value="<?php echo $produit_a_modifier['id']; ?>">
                    <?php endif; ?>

                    <div class="col-md-4">
                        <label>Nom du produit</label>
                        <input type="text" name="nom" class="form-control"
                            value="<?php echo $produit_a_modifier ? $produit_a_modifier['nom'] : ''; ?>" required>
                    </div>

                    <div class="col-md-3">
                        <label>Prix (FCFA)</label>
                        <input type="number" name="prix" class="form-control"
                            value="<?php echo $produit_a_modifier ? $produit_a_modifier['prix'] : ''; ?>" required>
                    </div>

                    <div class="col-md-3">
                        <label>Quantité</label>
                        <input type="number" name="quantite" class="form-control"
                            value="<?php echo $produit_a_modifier ? $produit_a_modifier['quantite'] : ''; ?>" required>
                    </div>

                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <?php if ($produit_a_modifier): ?>
                            <button type="submit" name="modifier" class="btn btn-warning w-100">Modifier</button>
                        <?php else: ?>
                            <button type="submit" name="ajouter" class="btn btn-primary w-100">Ajouter</button>
                        <?php endif; ?>
                    </div>
                </form>

                <?php if ($produit_a_modifier): ?>
                    <a href="produits.php" class="btn btn-secondary btn-sm mt-2">Annuler</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Liste des produits -->
        <div class="card">
            <div class="card-body">
                <h5>📦 Liste des produits en stock</h5>

                <?php if (empty($produits)): ?>
                    <p class="text-muted">Aucun produit. Ajoutez-en un !</p>
                <?php else: ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prix</th>
                                <th>Quantité</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produits as $p): ?>
                                <tr>
                                    <td><?php echo $p['id']; ?></td>
                                    <td><?php echo $p['nom']; ?></td>
                                    <td><?php echo number_format($p['prix'], 0, ',', ' '); ?> FCFA</td>
                                    <td><?php echo $p['quantite']; ?></td>
                                    <td>
                                        <a href="?modifier=<?php echo $p['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                                        <a href="?supprimer=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Supprimer ce produit ?')">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

    </div>
</body>

</html>