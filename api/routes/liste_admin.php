<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();

try {
    $sql = "SELECT P.id_pdc, P.puissance_nominale, P.tarification, S.id_station, S.nom_station, S.nom_enseigne 
            FROM POINT_DE_CHARGE P
            JOIN STATION S ON P.id_station = S.id_station
            ORDER BY P.id_pdc DESC
            LIMIT 100";
            
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode($resultats);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message_erreur" => $e->getMessage()]);
}
?>