<?php
// Configuration pour Replit DB
$config = [
    'host' => $_ENV['REPLIT_DB_HOST'] ?? 'localhost',
    'dbname' => $_ENV['REPLIT_DB_NAME'] ?? 'centrelezoo',
    'user' => $_ENV['REPLIT_DB_USER'] ?? 'root',
    'pass' => $_ENV['REPLIT_DB_PASSWORD'] ?? ''
];

try {
    $database = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']}",
        $config['user'],
        $config['pass']
    );
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?> 