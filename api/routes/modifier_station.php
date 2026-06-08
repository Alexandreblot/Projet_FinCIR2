<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Récupération des données envoyées en JSON par le fetch JavaScript
$donnees = json_decode(file_get_contents("php://input"), true);

if (!empty($donnees['id_station']) && !empty($donnees['nom_enseigne']) && !empty($donnees['adresse'])) {
    
    if ($db != null) {
        try {
            $sql = "UPDATE STATION 
                    SET nom_enseigne = :nom_enseigne, 
                        adresse = :adresse 
                    WHERE id_station = :id_station";
                    
            $requete = $db->prepare($sql);
            
            $requete->bindParam(':nom_enseigne', $donnees['nom_enseigne'], PDO::PARAM_STR);
            $requete->bindParam(':adresse', $donnees['adresse'], PDO::PARAM_STR);
            $requete->bindParam(':id_station', $donnees['id_station'], PDO::PARAM_STR);
            
            if ($requete->execute()) {
                http_response_code(200);
                echo json_encode([
                    "success" => true,
                    "statut" => "ok",
                    "message" => "La station a été modifiée avec succès."
                ]);
            } else {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Échec de l'exécution de la mise à jour."]);
            }
        } catch (PDOException $erreur) {
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
    echo json_encode(["success" => false, "message" => "Données incomplètes pour la modification."]);
}
?>