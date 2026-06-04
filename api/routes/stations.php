<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();

$filtreDepartement = "";
if (isset($_GET['departement'])) {
    $filtreDepartement = $_GET['departement'];
}

$filtreAmenageur = "";
if (isset($_GET['amenageur'])) {
    $filtreAmenageur = $_GET['amenageur'];
}

try {
    if ($filtreDepartement != "" && $filtreAmenageur != "") {
        $sql = "SELECT S.id, S.nom_enseigne, S.adresse, C.nom, C.dep_nom 
                FROM STATION S
                JOIN COMMUNE C ON S.id_commune = C.id
                WHERE C.dep_nom = :dept AND S.nom_enseigne = :amenageur
                LIMIT 50";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'dept' => $filtreDepartement,
            'amenageur' => $filtreAmenageur
        ]);
    } 
    else if ($filtreDepartement != "" && $filtreAmenageur == "") {
        $sql = "SELECT S.id, S.nom_enseigne, S.adresse, C.nom, C.dep_nom 
                FROM STATION S
                JOIN COMMUNE C ON S.id_commune = C.id
                WHERE C.dep_nom = :dept
                LIMIT 50";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'dept' => $filtreDepartement
        ]);
    } 
    else if ($filtreDepartement == "" && $filtreAmenageur != "") {
        $sql = "SELECT S.id, S.nom_enseigne, S.adresse, C.nom, C.dep_nom 
                FROM STATION S
                JOIN COMMUNE C ON S.id_commune = C.id
                WHERE S.nom_enseigne LIKE :amenageur
                LIMIT 50";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'amenageur' => '%' . $filtreAmenageur . '%'
        ]);
    } 
    else {
        $sql = "SELECT S.id, S.nom_enseigne, S.adresse, C.nom, C.dep_nom 
                FROM STATION S
                JOIN COMMUNE C ON S.id_commune = C.id
                LIMIT 50";
        
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }

    $stationsTrouvees = $stmt->fetchAll();

    if (count($stationsTrouvees) == 0 && $filtreDepartement == "") {
        $sql = "SELECT id, nom_enseigne, adresse, 'Ville non renseignée' AS nom, 'Bretagne' AS dep_nom 
                FROM STATION 
                LIMIT 50";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stationsTrouvees = $stmt->fetchAll();
    }

    http_response_code(200);
    echo json_encode($stationsTrouvees);

} catch (PDOException $erreur) {
    http_response_code(500);
    echo json_encode(["message_erreur" => $erreur->getMessage()]);
}
?>