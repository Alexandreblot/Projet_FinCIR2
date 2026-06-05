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

try {
    if ($typeDemande == "departements") {
        $sql = "SELECT DISTINCT dep_nom 
                FROM COMMUNE 
                WHERE dep_nom IN ('Côtes-d\'Armor', 'Finistère', 'Ille-et-Vilaine', 'Morbihan') 
                ORDER BY dep_nom ASC";
        
        $requete = $db->query($sql);
        $listeResultats = $requete->fetchAll();
    }
    
    else if ($typeDemande == "amenageurs") {
        $sql = "SELECT DISTINCT nom_enseigne AS nom 
                FROM STATION 
                WHERE nom_enseigne IS NOT NULL AND nom_enseigne != ''
                ORDER BY nom_enseigne ASC 
                LIMIT 30";
        
        $requete = $db->query($sql);
        $listeResultats = $requete->fetchAll();
    }
    
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