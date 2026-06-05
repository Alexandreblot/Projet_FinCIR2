<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();

$idStation = isset($_GET['id']) ? $_GET['id'] : "";

if ($idStation == "") {
    http_response_code(400);
    echo json_encode(["message_erreur" => "Identifiant de station manquant."]);
    exit;
}

try {
    $sql = "SELECT S.*, P.*
            FROM STATION S
            LEFT JOIN POINT_DE_CHARGE P ON S.id_station = P.id_station
            WHERE S.id_station = :id
            LIMIT 1";
            
    $stmt = $db->prepare($sql);
    $stmt->execute(['id' => $idStation]);
    $donneesStation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($donneesStation) {
        http_response_code(200);
        echo json_encode($donneesStation);
    } else {
        http_response_code(404);
        echo json_encode(["message_erreur" => "Station introuvable."]);
    }

} catch (PDOException $erreur) {
    http_response_code(500);
    echo json_encode(["message_erreur" => $erreur->getMessage()]);
}
?>