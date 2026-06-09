<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zapkartenn - Navigation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/front/index.css" />
    <link rel="stylesheet" href="css/front/navbar.css" />
    <link rel="stylesheet" href="css/front/footer.css" />

    <script src="js/front/navbar.js" defer></script>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="index.php">
            <img src="image/logo_zapkartenn.png" alt="Logo" class="logo-icon" />
          </a>
        </div>
        <button class="menu-toggle" id="menu-toggle">
          <span></span>
          <span></span>
          <span></span>
        </button>
        <ul class="nav navbar-nav" id="menu">
          <li><a href="html/front/carte.php" class="nav-btn1">Carte</a></li>
          <li><a href="html/front/recherche.php" class="nav-btn1">Recherche</a></li>
          <li>
            <a href="html/back/acceuil_admin.php" class="nav-btn2">
              <img src="image/avatar-de-connexion.png" class="Connexion" />Connexion
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <section class="hero">
      <img src="image/voiture-elec.png" class="hero-bg" />
      <div class="hero-overlay"></div>
      <img src="image/logo_zapkartenn.png" alt="Logo logo_zapkartenn" class="hero-logo" />
      <h1 class="hero-titre">
        Trouver des points de recharges de véhicules électriques en Bretagne
      </h1>
      
      <div class="statistics">
        <div class="stats-grid">
          
          <article class="stat-card">
            <div class="stat-number"><span id="compteur-pdc">0</span></div>
            <div class="stat-label">Nombre d'enregistrements en base</div>
          </article>

          <article class="stat-card">
            <div class="stat-number"><span id="compteur-stations">0</span></div>
            <div class="stat-label">Nombre de stations</div>
          </article>

          <article class="stat-card">
            <div class="stat-number"><span id="compteur-communes">0</span></div>
            <div class="stat-label">Nombre de communes couvertes</div>
          </article>

          <article class="stat-card">
            <div class="stat-number"><span id="compteur-amenageurs">0</span></div>
            <div class="stat-label">Nombre d'aménageurs</div>
          </article>

          <article class="stat-card">
            <div class="stat-number"><span id="compteur-operateurs">0</span></div>
            <div class="stat-label">Nombre d'opérateurs</div>
          </article>

          <article class="stat-card">
            <div class="stat-number"><span id="compteur-prise">3</span></div>
            <div class="stat-label">Type de prise</div>
          </article>

        </div>
      </div>
    </section>

    <footer class="footer">
      <div class="footer-content">
        <p>2026 Zapkartenn. Nathan & Alexandre - CIR2</p>
      </div>
    </footer>

    <script src="js/front/accueil.js"></script>
  </body>
</html>