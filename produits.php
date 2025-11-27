<?php
<?php
$database = new PDO('mysql:host=localhost;dbname=centrelezoo', 'root', '');
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Supprimer un produit
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $database->prepare("DELETE FROM produits WHERE id = ?")->execute(array($id));
    header('Location: produits.php');
    exit();
}

// Insérer un produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'], $_POST['prix'])) {
    $nom = trim($_POST['nom']);
    $prix = floatval($_POST['prix']);
    $image = trim($_POST['image']);
    $database->prepare("INSERT INTO produits (nom, prix, image) VALUES (?, ?, ?)")->execute(array($nom, $prix, $image));
    header('Location: produits.php');
    exit();
}

// Récupérer tous les produits
$stmt = $database->query("SELECT * FROM produits");
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestion des produits</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 800px; margin: 40px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);}
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px;}
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center;}
        th { background: #7c59c3; color: #fff;}
        .btn { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer;}
        .delete-btn { background: #e74c3c; color: #fff;}
        .refresh-btn { background: #3498db; color: #fff;}
        .insert-btn { background: #27ae60; color: #fff;}
        .form-inline input { padding: 6px; margin-right: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Liste des produits</h2>
        <form method="POST" class="form-inline" style="margin-bottom: 20px;">
            <input type="text" name="nom" placeholder="Nom du produit" required>
            <input type="number" step="0.01" name="prix" placeholder="Prix (€)" required>
            <input type="text" name="image" placeholder="URL de l'image (optionnel)">
            <button type="submit" class="btn insert-btn">Insérer</button>
            <a href="produits.php" class="btn refresh-btn">Actualiser</a>
        </form>
        <table>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prix (€)</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php foreach ($produits as $prod): ?>
            <tr>
                <td><?php echo $prod['id']; ?></td>
                <td><?php echo htmlspecialchars($prod['nom']); ?></td>
                <td><?php echo $prod['prix']; ?></td>
                <td>
                    <?php if ($prod['image']): ?>
                        <img src="<?php echo htmlspecialchars($prod['image']); ?>" alt="" style="width:40px;height:40px;">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="?delete=<?php echo $prod['id']; ?>" class="btn delete-btn" onclick="return confirm('Supprimer ce produit ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>