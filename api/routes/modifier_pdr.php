<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

require_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["message_erreur" => "Méthode non autorisée. POST attendu."]);
    exit;
}

try {
    $id_station    = $_POST['id'] ?? null;
    $nom_station   = $_POST['nom'] ?? null;
    $enseigne      = $_POST['enseigne'] ?? null;
    $horaires      = $_POST['horaires'] ?? null;
    $tarif         = $_POST['tarif'] ?? null;
    $prise_choisie = $_POST['prise'] ?? '';
    $longitude     = $_POST['longitude'] ?? null;
    $latitude      = $_POST['latitude'] ?? null;
    $adresse       = $_POST['adresse'] ?? null;

    if (empty($id_station)) {
        http_response_code(400);
        echo json_encode(["message_erreur" => "L'identifiant de la station (id) est obligatoire pour la modification."]);
        exit;
    }

    $db->beginTransaction();

    $sqlStation = "UPDATE STATION 
                   SET nom_station = :nom, nom_enseigne = :enseigne, horaires = :horaires, 
                       longitude = :lng, latitude = :lat, adresse = :adresse 
                   WHERE id_station = :id";
    
    $stmtStation = $db->prepare($sqlStation);
    $stmtStation->execute([
        'nom'      => $nom_station,
        'enseigne' => $enseigne,
        'horaires' => $horaires,
        'lng'      => !empty($longitude) ? $longitude : null,
        'lat'      => !empty($latitude) ? $latitude : null,
        'adresse'  => $adresse,
        'id'       => $id_station
    ]);

    $prise_ef  = ($prise_choisie === 'EF') ? 1 : 0;
    $prise_t2  = ($prise_choisie === 'Type 2') ? 1 : 0;
    $prise_ccs = ($prise_choisie === 'CCS') ? true : false;
    $chademo   = ($prise_choisie === 'CHAdeMO') ? true : false;

    $sqlPDC = "UPDATE POINT_DE_CHARGE 
               SET prise_ef = :ef, prise_t2 = :t2, prise_type_ccs = :ccs, 
                   chademo = :chademo, tarification = :tarif 
               WHERE id_station = :id";

    $stmtPDC = $db->prepare($sqlPDC);
    $stmtPDC->execute([
        'ef'      => $prise_ef,
        't2'      => $prise_t2,
        'ccs'     => $prise_ccs,
        'chademo' => $chademo,
        'tarif'   => $tarif,
        'id'      => $id_station
    ]);

    $db->commit();

    http_response_code(200);
    echo json_encode(["message_succes" => "Le point de recharge a été mis à jour avec succès !"]);

} catch (PDOException $erreur) {
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    http_response_code(500);
    echo json_encode(["message_erreur" => "Erreur SQL : " . $erreur->getMessage()]);
}
?>