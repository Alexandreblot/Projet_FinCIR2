<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idStation = $_GET['id'];

    if ($db != null) {
        try {
            // 1. DÉSACTIVER les contraintes de clés étrangères pour éviter l'erreur 500
            $db->exec("SET FOREIGN_KEY_CHECKS = 0;");

            // 2. Supprimer les points de charge liés à cette station dans POINT_DE_CHARGE
            $sqlDeletePdc = "DELETE FROM POINT_DE_CHARGE WHERE id_station = :id";
            $requetePdc = $db->prepare($sqlDeletePdc);
            $requetePdc->bindParam(':id', $idStation, PDO::PARAM_STR); 
            $requetePdc->execute();

            // 3. Supprimer la station elle-même dans STATION
            $sqlDeleteStation = "DELETE FROM STATION WHERE id_station = :id";
            $requeteStation = $db->prepare($sqlDeleteStation);
            $requeteStation->bindParam(':id', $idStation, PDO::PARAM_STR); 
            $requeteStation->execute();

            // 4. RÉACTIVER les contraintes de clés étrangères après le travail
            $db->exec("SET FOREIGN_KEY_CHECKS = 1;");

            http_response_code(200);
            echo json_encode([
                "success" => true,
                "statut" => "ok",
                "message" => "La station et ses dépendances ont été supprimées."
            ]);

        } catch (PDOException $erreur) {
            // Si jamais ça plante, on réactive quand même la sécurité des clés étrangères
            $db->exec("SET FOREIGN_KEY_CHECKS = 1;");

            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Erreur SQL : " . $erreur->getMessage()
            ]);
        }
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Base de données inaccessible."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "ID manquant ou invalide."]);
}
?>