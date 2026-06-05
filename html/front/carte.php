<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<?php
include_once __DIR__ . '/../../api/config/database.php';
$stations = [];
if (isset($conn) && $conn) {
  try {
    $stmt = $conn->query("
  SELECT s.latitude, s.longitude, s.nom_station, s.adresse, s.raccordement, 
         s.horaires, s.implantation, s.date_mise_en_service, c.dep_nom
  FROM STATION s
  LEFT JOIN COMMUNE c ON s.code_insee = c.code_insee
  WHERE s.latitude IS NOT NULL AND s.longitude IS NOT NULL
");
    $stations = $stmt->fetchAll();
  } catch (Exception $e) {
    echo "<!-- Erreur SQL : " . $e->getMessage() . " -->";
  }
} else {
  echo "<!-- Connexion BDD échouée -->";
}
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zapkartenn - Navigation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="../../css/front/carte.css" />
    <link rel="stylesheet" href="../../css/front/navbar.css" />
    <link rel="stylesheet" href="../../css/front/footer.css" />

    <script src="../../javascript/front/navbar.js" defer></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="../../javascript/front/carte.js" defer></script>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="../../index.php">
            <img
              src="../../image/logo_zapkartenn.png"
              alt="Logo"
              class="logo-icon"
            />
          </a>
        </div>
        <button class="menu-toggle" id="menu-toggle">
          <span></span>
          <span></span>
          <span></span>
        </button>
        <ul class="nav navbar-nav" id="menu">
          <li><a href="carte.php" class="nav-btn1">Carte</a></li>
          <li><a href="recherche.php" class="nav-btn1">Recherche</a></li>
          <li>
            <a href="../back/acceuil_admin.php" class="nav-btn2"
              ><img
                src="../../image/avatar-de-connexion.png"
                class="Connexion"
              />Connexion</a
            >
          </li>
        </ul>
      </div>
    </nav>

    <section class="carte-page">
      <div class="carte-grid">
        <aside class="carte-sidebar">
          <h2>Recherche</h2>
          <div class="filter-card">
            <label for="departement">Département</label>
            <select id="departement">
              <option value="">Choisir</option>
            </select>
          </div>
          <div class="filter-card">
            <label for="annee-installation">Année d'installation</label>
            <select id="annee-installation">
              <option value="">Choisir</option>
            </select>
          </div>
        </aside>

        <main class="map-panel">
          <div id="map"></div>
        </main>

        <aside class="info-panel">
          <div class="info-header" id="nom-station">Informations :</div>
          <div class="info-body">
            <p id="info-placeholder">
              Sélectionnez un point sur la carte pour afficher ses informations.
            </p>
            <ul>
              <li id="raccordement">Raccordement</li>
              <li id="adresse">Adresse</li>
              <li id="horaires">Horaires</li>
              <li id="date_mise_en_service">Date de mise en service</li>
              <li id="implantation">implantation</li>
            </ul>
          </div>
        </aside>
      </div>
    </section>

    <footer class="footer">
      <div class="footer-content">
        <p>2026 Zapkartenn. Nathan & Alexandre - CIR2</p>
      </div>
    </footer> 

    <script>
      var map = L.map("map").setView([48, -2.7], 8);
      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "&copy; OpenStreetMap contributors",
        maxZoom: 19,
      }).addTo(map);
    </script>

    <script>
      var stationsData = <?= json_encode(array_values($stations)) ?>;
    </script>

  </body>
</html>