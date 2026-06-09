<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();

try {// Récupération de la liste des points de recharge avec leurs stations associées
    $sql = "SELECT P.id_pdc, P.puissance_nominale, P.tarification, S.id_station, S.nom_station, S.nom_enseigne 
            FROM POINT_DE_CHARGE P
            JOIN STATION S ON P.id_station = S.id_station
            ORDER BY P.id_pdc DESC
            LIMIT 100";
    // Préparation et exécution de la requête
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Envoi de la réponse JSON avec la liste des points de recharge
    http_response_code(200);
    echo json_encode($resultats);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message_erreur" => $e->getMessage()]);
}
?>