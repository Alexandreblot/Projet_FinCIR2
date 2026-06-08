<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zapkartenn - Navigation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../css/back/navbar_admin.css" />
    <link rel="stylesheet" href="../../css/back/footer_admin.css" />
    <link rel="stylesheet" href="../../css/front/index.css" />
    <link rel="stylesheet" href="../../css/back/accueil_admin.css" />

    <script src="../../javascript/front/navbar.js" defer></script>
    <script src="../../javascript/back/accueil_admin.js" defer></script>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="acceuil_admin.php">
            <img src="../../image/logo_zapkartenn.png" alt="Logo" class="logo-icon" />
          </a>
        </div>
        <button class="menu-toggle" id="menu-toggle">
          <span></span>
          <span></span>
          <span></span>
        </button>
        <ul class="nav navbar-nav" id="menu">
          <li>
            <a href="creation.php" class="nav-btn1">Nouveau PDR</a>
          </li>
          <li><a href="recherche_admin.php" class="nav-btn1">Recherche</a></li>
          <li>
            <a href="../../index.php" class="nav-btn2">
              <img src="../../image/avatar-de-connexion.png" class="Connexion" />Déconnexion
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <section class="hero">
      <img src="../../image/voiture-elec.png" class="hero-bg" />
      <div class="hero-overlay"></div>
      <img src="../../image/logo_zapkartenn.png" alt="Logo logo_zapkartenn" class="hero-logo" />
      <h1 class="hero-titre">
        Trouver des points de recharges de véhicules électriques en Bretagne
      </h1>
      
      <div class="statistics">
        <div class="stats-grid">
          <article class="stat-card">
            <div class="stat-number">N/A</div>
            <div class="stat-label">Nombre d’enregistrements en base</div>
          </article>
          <article class="stat-card">
            <div class="stat-number">N/A</div>
            <div class="stat-label">Nombre de points par années</div>
          </article>
          <article class="stat-card">
            <div class="stat-number">N/A</div>
            <div class="stat-label">Nombre de points par département</div>
          </article>
          <article class="stat-card">
            <div class="stat-number">N/A</div>
            <div class="stat-label">Nombre de points par années et par département</div>
          </article>
          <article class="stat-card">
            <div class="stat-number">N/A</div>
            <div class="stat-label">Nombre d’aménageurs</div>
          </article>
          <article class="stat-card">
            <div class="stat-number">N/A</div>
            <div class="stat-label">Nombre de types de prise (nbre_pdc)</div>
          </article>
        </div>
      </div>

      <div class="admin-management-container text-left">
        
        <div class="admin-glass-panel">
          <h2>🎯 Objectif de l'Espace Administrateur</h2>
          <p class="mt-3" style="color: rgba(255,255,255,0.85); font-size: 15px; line-height: 1.6;">
            Bienvenue sur le centre de contrôle de <strong>Zapkartenn</strong>. Cette interface technique vous permet de piloter l'ensemble du parc de bornes de recharge implanté en Bretagne. Vous pouvez ajouter de nouveaux connecteurs électriques sur des stations existantes, réviser la tarification au kilowattheure ou auditer les fiches de renseignements publiques.
          </p>
          <div class="mt-4">
            <a href="creation.php" class="btn btn-custom-create">➕ Déployer un connecteur (PDR)</a>
          </div>
        </div>

        <div class="admin-glass-panel">
          <h3 class="mb-4">📋 Registre des points de recharge (Limité aux 100 derniers enregistrements)</h3>
          <div class="table-responsive">
            <table class="table admin-table table-borderless m-0">
              <thead>
                <tr>
                  <th>ID PDC</th>
                  <th>Nom de la Station</th>
                  <th>Enseigne</th>
                  <th>Puissance</th>
                  <th>Tarif</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="corps-tableau-admin">
                <tr>
                  <td colspan="6" class="text-center py-4" style="color: rgba(255,255,255,0.6);">
                    Chargement du registre en cours...
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </section>

    <footer class="footer">
      <div class="footer-content">
        <p>2026 Zapkartenn. Nathan & Alexandre - CIR2</p>
      </div>
    </footer>
  </body>
</html>