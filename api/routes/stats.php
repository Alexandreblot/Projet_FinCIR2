<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

if($db != null) {
    try {
        // --- 1. COMPTER LES POINTS DE CHARGE ---
        $sqlPdc = "SELECT COUNT(*) AS total FROM POINT_DE_CHARGE";
        $requetePdc = $db->query($sqlPdc);
        $resultatPdc = $requetePdc->fetch();
        $nombrePdc = $resultatPdc['total'];

        // --- 2. COMPTER LES STATIONS ---
        $sqlStation = "SELECT COUNT(*) AS total FROM STATION";
        $requeteStation = $db->query($sqlStation);
        $resultatStation = $requeteStation->fetch();
        $nombreStations = $resultatStation['total'];

        // --- 3. COMPTER LES COMMUNES ---
        $sqlCommune = "SELECT COUNT(*) AS total FROM COMMUNE";
        $requeteCommune = $db->query($sqlCommune);
        $resultatCommune = $requeteCommune->fetch();
        $nombreCommunes = $resultatCommune['total'];

        // --- 4. COMPTER LES AMÉNAGEURS ---
        $sqlAmenageur = "SELECT COUNT(*) AS total FROM AMENAGEUR";
        $requeteAmenageur = $db->query($sqlAmenageur);
        $resultatAmenageur = $requeteAmenageur->fetch();
        $nombreAmenageurs = $resultatAmenageur['total'];

        // --- 5. COMPTER LES OPÉRATEURS ---
        $sqlOperateur = "SELECT COUNT(*) AS total FROM OPERATEUR";
        $requeteOperateur = $db->query($sqlOperateur);
        $resultatOperateur = $requeteOperateur->fetch();
        $nombreOperateurs = $resultatOperateur['total'];

        // On regroupe toutes nos variables dans un grand tableau propre
        $tableauStatistiques = [
            "total_points_charge" => (int)$nombrePdc,
            "total_stations" => (int)$nombreStations,
            "total_communes" => (int)$nombreCommunes,
            "total_amenageurs" => (int)$nombreAmenageurs,
            "total_operateurs" => (int)$nombreOperateurs
        ];

        // On répond que tout s'est bien passé (Code 200) et on transforme le tableau en JSON
        http_response_code(200);
        echo json_encode($tableauStatistiques);

    } catch (PDOException $erreur) {
        // Si le SQL a une erreur, on renvoie le message
        http_response_code(500);
        echo json_encode(["message_erreur" => $erreur->getMessage()]);
    }
} else {
    http_response_code(500);
    echo json_encode(["message_erreur" => "La base de données n'est pas accessible."]);
}
?>