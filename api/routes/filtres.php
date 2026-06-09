<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();

$typeDemande = "";
if (isset($_GET['type'])) {
    $typeDemande = $_GET['type'];
}

$listeResultats = [];
// En fonction du type de demande reçu, on exécute la requête SQL correspondante pour récupérer les données à afficher dans les filtres du front-end
try {
    if ($typeDemande == "departements") {
        $sql = "SELECT DISTINCT dep_nom AS nom 
                FROM COMMUNE 
                WHERE dep_nom IN ('Côtes-d\'Armor', 'Finistère', 'Ille-et-Vilaine', 'Morbihan') 
                ORDER BY dep_nom ASC";
        
        $requete = $db->query($sql);
        $listeResultats = $requete->fetchAll();
    }
    // Si le type de demande est "amenageurs", on récupère la liste des aménageurs présents dans la base de données
    else if ($typeDemande == "amenageurs") {
        $sql = "SELECT DISTINCT nom_enseigne AS nom 
                FROM STATION 
                WHERE nom_enseigne IS NOT NULL AND nom_enseigne != ''
                ORDER BY nom_enseigne ASC 
                LIMIT 30";
        
        $requete = $db->query($sql);
        $listeResultats = $requete->fetchAll();
    }
    // Si le type de demande est "annees", on récupère la liste des années de mise en service des stations présentes dans la base de données
    else if ($typeDemande == "annees") {
        $sql = "SELECT DISTINCT YEAR(date_mise_en_service) AS annee
                FROM STATION 
                WHERE date_mise_en_service IS NOT NULL AND YEAR(date_mise_en_service) > 0
                ORDER BY annee DESC";
        
        $requete = $db->query($sql);
        $listeResultats = $requete->fetchAll();
    }

    http_response_code(200);
    echo json_encode($listeResultats);

} catch (PDOException $erreur) {
    http_response_code(500);
    echo json_encode(["message_erreur" => $erreur->getMessage()]);
}
?>