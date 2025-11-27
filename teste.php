<?php
session_start();
if (!isset($_SESSION['User_prenom'])) {
    header('Location: login.php');
    exit();
}
$prenom = $_SESSION['User_prenom'];

// Initialiser le panier si non existant
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

// Ajouter un produit au panier
if (isset($_GET['add'])) {
    $id = $_GET['add'];
    // Exemple statique, à remplacer par une vraie recherche produit
    $produits = array(
        1 => array('nom' => 'Livre d’Art Africain', 'prix' => 25),
        2 => array('nom' => 'T-shirt CCCZ', 'prix' => 15),
        3 => array('nom' => 'Billet Spectacle', 'prix' => 10)
    );
    if (isset($produits[$id])) {
        $_SESSION['panier'][$id] = $produits[$id];
    }
}

// Retirer un produit du panier
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['panier'][$id]);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nos Produits</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; }
        .header {
            background: #7c59c3; color: #fff; padding: 15px 30px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .search-bar { display: flex; align-items: center; }
        .search-input { padding: 8px; border-radius: 4px; border: 1px solid #ccc; width: 250px; }
        .search-btn { padding: 8px 16px; margin-left: 8px; background: #ff9900; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .user-info { font-weight: bold; }
        .products-container { max-width: 900px; margin: 40px auto; display: flex; flex-wrap: wrap; gap: 30px; }
        .product-card { background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); width: 250px; padding: 20px; text-align: center; }
        .product-card img { width: 120px; height: 120px; object-fit: cover; margin-bottom: 15px; }
        .product-title { font-size: 18px; font-weight: bold; margin-bottom: 10px; }
        .product-price { color: #7c59c3; font-size: 16px; margin-bottom: 15px; }
        .order-btn, .add-btn, .remove-btn {
            background: #ff9900; color: #fff; border: none; padding: 10px 20px;
            border-radius: 4px; cursor: pointer; font-size: 15px;
        }
        .order-btn:hover, .add-btn:hover, .remove-btn:hover { background: #e68a00; }
        .cart-container { max-width: 900px; margin: 20px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; }
        .cart-title { font-size: 20px; font-weight: bold; margin-bottom: 15px; }
        .cart-list { list-style: none; padding: 0; }
        .cart-list li { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="search-bar">
            <form method="GET" action="">
                <input type="text" name="q" class="search-input" placeholder="Rechercher un produit...">
                <button type="submit" class="search-btn">Rechercher</button>
            </form>
        </div>
        <div class="user-info">
            Bonjour, <?php echo htmlspecialchars($prenom); ?>
        </div>
    </div>
    <h2 style="text-align:center;">Nos Produits</h2>
    <div class="products-container">
        <div class="product-card">
            <img src="https://via.placeholder.com/120x120?text=Produit+1" alt="Produit 1">
            <div class="product-title">Livre d’Art Africain</div>
            <div class="product-price">25 €</div>
            <a href="?add=1" class="add-btn">Ajouter au panier</a>
        </div>
        <div class="product-card">
            <img src="https://via.placeholder.com/120x120?text=Produit+2" alt="Produit 2">
            <div class="product-title">T-shirt CCCZ</div>
            <div class="product-price">15 €</div>
            <a href="?add=2" class="add-btn">Ajouter au panier</a>
        </div>
        <div class="product-card">
            <img src="https://via.placeholder.com/120x120?text=Produit+3" alt="Produit 3">
            <div class="product-title">Billet Spectacle</div>
            <div class="product-price">10 €</div>
            <a href="?add=3" class="add-btn">Ajouter au panier</a>
        </div>
    </div>
    <div class="cart-container">
        <div class="cart-title">Mon panier</div>
        <ul class="cart-list">
            <?php if (!empty($_SESSION['panier'])): ?>
                <?php foreach ($_SESSION['panier'] as $id => $prod): ?>
                    <li>
                        <?php echo htmlspecialchars($prod['nom']); ?> - <?php echo $prod['prix']; ?> €
                        <a href="?remove=<?php echo $id; ?>" class="remove-btn">Retirer</a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Votre panier est vide.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>