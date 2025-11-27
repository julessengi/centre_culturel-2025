<?php
session_start();
// if (!isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit();
// }

// Configuration de la connexion
    $database= new PDO ('mysql:host=localhost;dbname=centrelezoo','root','');
    $database->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $results = $database->query('SELECT nom,post_nom,prenom FROM agents');
// while($row = $results->fetch()) { 
//     // ...traitement ici si besoin...
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $database = new PDO(
            "mysql:host={$config['localhost']};dbname={$config['centrelezoo']}",
            $config['user'],
            $config['pass']
        );
        
        // Hashage du mot de passe
        $password = md5($_POST['password']);
        
        $sql = "INSERT INTO agents (nom, post_nom, prenom, sexe, adresse, telephone, email, password) 
                VALUES (:nom, :post_nom, :prenom, :sexe, :adresse, :telephone, :email, :password)";
                
        $stmt = $database->prepare($sql);

        
        header('Location: login.php?success=1');
        exit();
        
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <style>
        .register-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group { margin-bottom: 15px; }
        .form-input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .submit-btn { width: 100%; padding: 12px; background: #7c59c3; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Inscription</h2>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="nom" placeholder="Nom" class="form-input" required>
            </div>
            <div class="form-group">
                <input type="text" name="post_nom" placeholder="Post-nom" class="form-input" required>
            </div>
            <div class="form-group">
                <input type="text" name="prenom" placeholder="Prénom" class="form-input" required>
            </div>
            <div class="form-group">
                <select name="sexe" class="form-input" required>
                    <option value="">Sexe</option>
                    <option value="M">Masculin</option>
                    <option value="F">Féminin</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="adresse" placeholder="Adresse" class="form-input" required>
            </div>
            <div class="form-group">
                <input type="tel" name="telephone" placeholder="Téléphone" class="form-input" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" class="form-input" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Mot de passe" class="form-input" required>
            </div>
            <button type="submit" class="submit-btn">Valiver</button>
        </form>
    </div>
</body>
</html>