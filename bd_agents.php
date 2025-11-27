<?php 
// Configuration de la connexion
    $database= new PDO ('mysql:host=localhost;dbname=centrelezoo','root','');
    $database->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $results=$database->query('SELECT nom,post_nom,prenom FROM agents');
    while($row=$results->fetch())
    {
        echo $row['nom']."-".$row['nom']."-".$row['prenom'].'<br>'; 
    }

try {
    // Connexion à la base de données

    
 
    
    // Fonction pour nettoyer les données
    function cleanInput($data) {
        return htmlspecialchars(trim($data));
    }

    // Ajout d'un nouvel agent (formulaire)
    echo "<h2>Ajouter un nouvel agent</h2>";
    echo "<form method='POST'>
            <input type='text' name='nom' placeholder='Nom' required><br>
            <input type='text' name='post_nom' placeholder='Post-nom' required><br>
            <input type='text' name='prenom' placeholder='Prénom' required><br>
            <select name='sexe'>
                <option value='M'>Masculin</option>
                <option value='F'>Féminin</option>
            </select><br>
            <input type='text' name='adresse' placeholder='Adresse' required><br>
            <input type='tel' name='telephone' placeholder='Téléphone' required><br>
            <input type='email' name='email' placeholder='Email' required><br>
            <input type='submit' name='ajouter' value='Ajouter'>
          </form>";

    // Traitement de l'ajout d'un agent
    if(isset($_POST['ajouter'])) {
        $sql = "INSERT INTO agents (nom, post_nom, prenom, sexe, adresse, telephone, email) 
                VALUES (:nom, :post_nom, :prenom, :sexe, :adresse, :telephone, :email)";
        $stmt = $database->prepare($sql);
        

        
        echo "<p class='success'>Agent ajouté avec succès!</p>";
    }

    // Affichage des agents
    echo "<h2>Liste des agents</h2>";
    $results = $database->query('SELECT * FROM agents ORDER BY nom');

    echo "<table border='1'>
            <tr>
                <th>Nom</th>
                <th>Post-nom</th>
                <th>Prénom</th>
                <th>Sexe</th>
                <th>Adresse</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>";

    while($row = $results->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . cleanInput($row['nom']) . "</td>";
        echo "<td>" . cleanInput($row['post_nom']) . "</td>";
        echo "<td>" . cleanInput($row['prenom']) . "</td>";
        echo "<td>" . cleanInput($row['sexe']) . "</td>";
        echo "<td>" . cleanInput($row['adresse']) . "</td>";
        echo "<td>" . cleanInput($row['telephone']) . "</td>";
        echo "<td>" . cleanInput($row['email']) . "</td>";
        echo "<td>
                <form method='POST' style='display:inline;'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <input type='submit' name='supprimer' value='Supprimer' onclick='return confirm(\"Êtes-vous sûr ?\");'>
                </form>
              </td>";
        echo "</tr>";
    }
    
    echo "</table>";

    // Traitement de la suppression
    if(isset($_POST['supprimer'])) {
        $sql = "DELETE FROM agents WHERE id = :id";
        $stmt = $database->prepare($sql);

        
        echo "<p class='success'>Agent supprimé avec succès!</p>";
        echo "<script>window.location.reload();</script>";
    }

} catch(PDOException $e) {
    echo "<p class='error'>Erreur de connexion : " . $e->getMessage() . "</p>";
}
?>

<style>
/* Styles généraux */
body {
    font-family: Arial, sans-serif;
    background-color: #f5f3fa; /* Violet très clair */
    margin: 20px;
    color: #333;
}

h2 {
    color: #7c59c3; /* Couleur principale */
    border-bottom: 2px solid #7c59c3;
    padding-bottom: 10px;
}

/* Style du formulaire */
form {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(124, 89, 195, 0.1);
    max-width: 500px;
    margin: 20px 0;
}

input, select {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #d4c6f0; /* Violet clair */
    border-radius: 4px;
    box-sizing: border-box;
}

input:focus, select:focus {
    outline: none;
    border-color: #7c59c3;
    box-shadow: 0 0 5px rgba(124, 89, 195, 0.3);
}

input[type="submit"] {
    background-color: #7c59c3;
    color: white;
    border: none;
    padding: 12px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #6647a3; /* Violet plus foncé */
}

/* Style du tableau */
table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
    background-color: white;
    box-shadow: 0 2px 10px rgba(124, 89, 195, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

th {
    background-color: #7c59c3;
    color: white;
    padding: 12px 8px;
    text-align: left;
}

td {
    padding: 12px 8px;
    border-bottom: 1px solid #e8e1f7; /* Violet très clair */
}

tr:hover {
    background-color: #f8f6fc; /* Violet très très clair */
}

/* Bouton de suppression */
form[style*="inline"] input[type="submit"] {
    background-color: #ff6b6b; /* Rouge pour le bouton supprimer */
    padding: 6px 12px;
    font-size: 14px;
}

form[style*="inline"] input[type="submit"]:hover {
    background-color: #ff5252;
}

/* Messages de succès et d'erreur */
.success {
    background-color: #e8f5e9;
    color: #2e7d32;
    padding: 10px;
    border-radius: 4px;
    margin: 10px 0;
}

.error {
    background-color: #ffebee;
    color: #c62828;
    padding: 10px;
    border-radius: 4px;
    margin: 10px 0;
}
</style>