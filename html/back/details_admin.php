<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zapkartenn - Détails Administration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../css/back/navbar_admin.css" />
    <link rel="stylesheet" href="../../css/back/footer_admin.css" />
    <link rel="stylesheet" href="../../css/front/index.css" />
    <link rel="stylesheet" href="../../css/front/details.css" />

    <script src="../../javascript/front/navbar.js" defer></script>
    <script src="../../javascript/front/details.js" defer></script>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="acceuil_admin.php">
            <img src="../../image/logo_zapkartenn.png" alt="Logo" class="logo-icon" />
          </a>
        </div>
        <ul class="nav navbar-nav" id="menu">
          <li><a href="creation.php" class="nav-btn1">Nouveau PDR</a></li>
          <li><a href="recherche_admin.php" class="nav-btn1">Recherche</a></li>
          <li>
            <a href="../../index.php" class="nav-btn2">
              <img src="../../image/avatar-de-connexion.png" class="Connexion" />Déconnexion
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="details-page container" style="position: relative; z-index: 2; margin-top: 40px; padding-bottom: 60px;">
      <section class="details-header text-center">
        <h1 id="titre-station" style="color: #ffffff;">Chargement des données...</h1>
      </section>

      <h3 class="mt-4 mb-3 text-info">Caractéristiques du Point de Recharge (Mode Admin)</h3>
      <section class="details-grid">
        <article class="detail-card">
          <span class="label">Nom de la station :</span>
          <strong id="det-nom">...</strong>
        </article>
        <article class="detail-card">
          <span class="label">Enseigne :</span>
          <strong id="det-enseigne">...</strong>
        </article>
        <article class="detail-card">
          <span class="label">Adresse postale :</span>
          <strong id="det-adresse">...</strong>
        </article>
        <article class="detail-card">
          <span class="label">Horaires d'ouverture :</span>
          <strong id="det-horaires">...</strong>
        </article>
        <article class="detail-card">
          <span class="label">Date de mise en service :</span>
          <strong id="det-date-service">...</strong>
        </article>
        <article class="detail-card">
          <span class="label">Puissance nominale :</span>
          <strong id="det-puissance">...</strong>
        </article>
        <article class="detail-card">
          <span class="label">Types de prises disponibles :</span>
          <strong id="det-prises">...</strong>
        </article>
        <article class="detail-card">
          <span class="label">Accès Gratuit :</span>
          <strong id="det-gratuit">...</strong>
        </article>
      </section>

      <div class="text-center mt-5">
        <a href="acceuil_admin.php" class="btn btn-secondary px-5" style="border-radius: 20px;">Retour au registre</a>
      </div>
    </main>

    <footer class="footer">
      <div class="footer-content">
        <p>2026 Zapkartenn. Nathan & Alexandre - CIR2</p>
      </div>
    </footer>
  </body>
</html>