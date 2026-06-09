<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

require_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();

// Vérification que la méthode HTTP utilisée est bien POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["message_erreur" => "Méthode non autorisée. POST attendu."]);
    exit;
}

try { // Récupération des données envoyées en POST
    $id_station = $_POST['id_station'] ?? null;
    $puissance  = $_POST['puissance'] ?? null;
    $tarif      = $_POST['tarif'] ?? null;
    $gratuit    = $_POST['gratuit'] ?? 'Non';
    $prise_ef   = $_POST['prise_ef'] ?? 'Non';
    $prise_t2   = $_POST['prise_t2'] ?? 'Non';
    $prise_ccs  = $_POST['prise_ccs'] ?? 'Non';
    $chademo    = $_POST['chademo'] ?? 'Non';
    $paiement   = $_POST['paiement'] ?? null;

    $val_prise_ef = ($prise_ef === 'Oui') ? 1 : 0;
    $val_prise_t2 = ($prise_t2 === 'Oui') ? 1 : 0;

    $val_prise_ccs = ($prise_ccs === 'Oui') ? true : false;
    $val_chademo   = ($chademo === 'Oui') ? true : false;
    //insertion du nouveau point de recharge dans la base de données
    $sql = "INSERT INTO POINT_DE_CHARGE (
                puissance_nominale, 
                prise_ef, 
                prise_t2, 
                prise_type_ccs, 
                chademo, 
                gratuit, 
                paiement, 
                tarification, 
                id_station
            ) VALUES (
                :puissance, 
                :prise_ef, 
                :prise_t2, 
                :prise_type_ccs, 
                :chademo, 
                :gratuit, 
                :paiement, 
                :tarification, 
                :id_station
            )";
    // Préparation et exécution de la requête d'insertion
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'puissance'    => $puissance,
        'prise_ef'     => $val_prise_ef,
        'prise_t2'     => $val_prise_t2,
        'prise_type_ccs'=> $val_prise_ccs,
        'chademo'      => $val_chademo,
        'gratuit'      => $gratuit,
        'paiement'     => $paiement,
        'tarification' => $tarif,
        'id_station'   => $id_station
    ]);

    http_response_code(201);
    echo json_encode(["message_succes" => "Le point de recharge a été créé avec succès !"]);

} catch (PDOException $erreur) {
    http_response_code(500);
    echo json_encode(["message_erreur" => "Erreur SQL : " . $erreur->getMessage()]);
}
?>