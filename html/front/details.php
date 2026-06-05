<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zapkartenn - Détails de la Borne</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../css/front/details.css" />
    <link rel="stylesheet" href="../../css/front/navbar.css" />
    <link rel="stylesheet" href="../../css/front/footer.css" />
    <script src="../../javascript/front/navbar.js" defer></script>
    <script src="../../javascript/front/details.js" defer></script>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="../../index.php">
            <img src="../../image/logo_zapkartenn.png" alt="Logo" class="logo-icon" />
          </a>
        </div>
        <ul class="nav navbar-nav" id="menu">
          <li><a href="carte.php" class="nav-btn1">Carte</a></li>
          <li><a href="recherche.php" class="nav-btn1">Recherche</a></li>
          <li><a href="../back/acceuil_admin.php" class="nav-btn2">Connexion</a></li>
        </ul>
      </div>
    </nav>

    <main class="details-page container">
      <section class="details-header text-center">
        <h1 id="titre-station">Chargement des données...</h1>
      </section>

      <h3 class="mt-4 mb-3 text-info">Informations Station</h3>
      <section class="details-grid">
        <article class="detail-card">
          <span class="label">Identifiant unique :</span>
          <strong id="det-id-station">...</strong>
        </article>
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
          <span class="label">Type d'implantation :</span>
          <strong id="det-implantation">...</strong>
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
          <span class="label">Coordonnées (GPS) :</span>
          <strong id="det-gps">...</strong>
        </article>
      </section>

      <h3 class="mt-4 mb-3 text-info">Caractéristiques Techniques (PDC)</h3>
      <section class="details-grid">
        <article class="detail-card">
          <span class="label">Identifiant Point de Charge (PDC) :</span>
          <strong id="det-id-pdc">...</strong>
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
          <span class="label">Type de raccordement :</span>
          <strong id="det-raccordement">...</strong>
        </article>
      </section>

      <h3 class="mt-4 mb-3 text-info">Accès et Tarification</h3>
      <section class="details-grid">
        <article class="detail-card">
          <span class="label">Accès Gratuit :</span>
          <strong id="det-gratuit">...</strong>
        </article>
        <article class="detail-card">
          <span class="label">Moyens de paiement :</span>
          <strong id="det-paiement">...</strong>
        </article>
        <article class="detail-card">
          <span class="label">Tarification détaillée :</span>
          <strong id="det-tarifs">...</strong>
        </article>
      </section>

      <h3 class="mt-4 mb-3 text-info">Données Administratives</h3>
      <section class="details-grid">
        <article class="detail-card">
          <span class="label">Numéro SIREN :</span>
          <strong id="det-siren">...</strong>
        </article>
        <article class="detail-card">
          <span class="label">Code INSEE Commune :</span>
          <strong id="det-insee">...</strong>
        </article>
        <article class="detail-card">
          <span class="label">Identifiant Local :</span>
          <strong id="det-id-local">...</strong>
        </article>
      </section>
    </main>

    <footer class="footer">
      <div class="footer-content">
        <p>2026 Zapkartenn. Nathan & Alexandre - CIR2</p>
      </div>
    </footer>
  </body>
</html>