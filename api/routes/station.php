<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();

$filtreDepartement = "";// Vérification de la présence d'un filtre de département dans les paramètres GET
if (isset($_GET['departement'])) {
    $filtreDepartement = $_GET['departement'];
}

$filtreAmenageur = "";// Vérification de la présence d'un filtre d'aménageur dans les paramètres GET
if (isset($_GET['amenageur'])) {
    $filtreAmenageur = $_GET['amenageur'];
}
//on essaie d'exécuter la requête SQL pour récupérer les stations en fonction des filtres reçus
try {
    if ($filtreDepartement != "" && $filtreAmenageur != "") {
        $sql = "SELECT S.id_station, S.nom_enseigne, S.adresse, C.nom, C.dep_nom 
                FROM STATION S
                JOIN COMMUNE C ON S.code_insee = C.code_insee
                WHERE C.dep_nom = :dept AND S.nom_enseigne = :amenageur
                LIMIT 50";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'dept' => $filtreDepartement,
            'amenageur' => $filtreAmenageur
        ]);
    } 
    // Si seul le filtre de département est présent, on récupère les stations situées dans ce département
    else if ($filtreDepartement != "" && $filtreAmenageur == "") {
        $sql = "SELECT S.id_station, S.nom_enseigne, S.adresse, C.nom, C.dep_nom 
                FROM STATION S
                JOIN COMMUNE C ON S.code_insee = C.code_insee
                WHERE C.dep_nom = :dept
                LIMIT 50";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'dept' => $filtreDepartement
        ]);
    } 
    // Si seul le filtre d'aménageur est présent, on récupère les stations gérées par cet aménageur
    else if ($filtreDepartement == "" && $filtreAmenageur != "") {
        $sql = "SELECT S.id_station, S.nom_enseigne, S.adresse, C.nom, C.dep_nom 
                FROM STATION S
                JOIN COMMUNE C ON S.code_insee = C.code_insee
                WHERE S.nom_enseigne LIKE :amenageur
                LIMIT 50";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'amenageur' => '%' . $filtreAmenageur . '%'
        ]);
    } 
    // Si aucun filtre n'est présent, on récupère une liste générale de stations avec leurs départements associés
    else {
        $sql = "SELECT S.id_station, S.nom_enseigne, S.adresse, C.nom, C.dep_nom 
                FROM STATION S
                JOIN COMMUNE C ON S.code_insee = C.code_insee
                LIMIT 50";
        
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }
// Récupération des stations trouvées en fonction des filtres appliqués
    $stationsTrouvees = $stmt->fetchAll();

    if (count($stationsTrouvees) == 0 && $filtreDepartement == "") {
        $sql = "SELECT id_station, nom_enseigne, adresse, 'Bretagne' AS nom, 'Département' AS dep_nom 
                FROM STATION 
                LIMIT 50";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stationsTrouvees = $stmt->fetchAll();
    }

// Envoi de la réponse JSON avec les stations trouvées
    http_response_code(200);
    echo json_encode($stationsTrouvees);

} catch (PDOException $erreur) {
    http_response_code(500);
    echo json_encode(["message_erreur" => $erreur->getMessage()]);
}
?>