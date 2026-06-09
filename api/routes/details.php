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
// Récupération des détails de la station et de ses points de recharge associés
try {
    $sql = "SELECT S.*, P.*
            FROM STATION S
            LEFT JOIN POINT_DE_CHARGE P ON S.id_station = P.id_station
            WHERE S.id_station = :id
            LIMIT 1";
    // Préparation et exécution de la requête
    $stmt = $db->prepare($sql); // Prépare la requête SQL avec un paramètre pour l'identifiant de station
    $stmt->execute(['id' => $idStation]); // Exécution de la requête avec l'identifiant de station fourni
    $donneesStation = $stmt->fetch(PDO::FETCH_ASSOC); // Récupère la première ligne

    if ($donneesStation) { // Si la station existe, on renvoie ses détails
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