<?php
<?php
    // Affiche le contenu HTML statique
    $header = file_get_contents('index.html');

    // Connexion à la base de données
    $database = new PDO('mysql:host=localhost;dbname=centrelezoo', 'root', '');
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupère les prénoms des membres
    $results = $database->query('SELECT prenom FROM agents');
    $members_html = '<div class="members-list"><h4>Membres inscrits :</h4><ul>';
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        $members_html .= '<li>' . htmlspecialchars($row['prenom']) . '</li>';
    }
    $members_html .= '</ul></div>';

    // Remplace le placeholder dans le HTML par la liste des membres
    $header = str_replace('<?php /*MEMBERS_PLACEHOLDER*/ ?>', $members_html, $header);

    echo $header;
?>