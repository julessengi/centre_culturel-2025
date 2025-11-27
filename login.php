<?php
session_start();

$database = new PDO('mysql:host=localhost;dbname=centrelezoo', 'root', '');
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = htmlspecialchars(trim($_POST['email']));
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM agents WHERE email = :email";
        $stmt = $database->prepare($sql);
        $stmt->execute(array('email' => $email));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && $user['password'] === md5($password)) {
            $_SESSION['User_id'] = $user['id'];
            $_SESSION['User_prenom'] = $user['prenom'];
            header('Location: teste.php');
            exit();
        } else {
            $error = "Email ou mot de passe incorrect";
        }
    } catch(Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #7c59c3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <input type="email" name="email" placeholder="Votre Email" class="form-input" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Votre Mot de passe" class="form-input" required>
            </div>
            <button type="submit" class="submit-btn">Se connecter</button>
            <div style="margin-top: 15px; text-align: center;">
                Pas encore inscrit? <a href="register.php">S'inscrire</a>
            </div>
        </form>
    </div>
</body>
</html>