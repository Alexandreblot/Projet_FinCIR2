<?php
include_once 'api/config/database.php';

if ($conn) {
    echo "Connexion réussie à la base de données !\n";
    
    try {
        $stmt = $conn->query("SELECT COUNT(*) as count FROM STATION");
        $result = $stmt->fetch();
        echo "Nombre de stations : " . $result['count'] . "\n";
        
        $stmt = $conn->query("SELECT * FROM STATION LIMIT 1");
        $station = $stmt->fetch();
        if ($station) {
            echo "Exemple de station : " . json_encode($station, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
        }
    } catch (Exception $e) {
        echo "Erreur lors de la requête : " . $e->getMessage() . "\n";
    }
} else {
    echo "Échec de la connexion\n";
}
?>
