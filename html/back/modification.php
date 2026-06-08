<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zapkartenn - Modification</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="../../css/back/navbar_admin.css" />
    <link rel="stylesheet" href="../../css/back/footer_admin.css" />
    <link rel="stylesheet" href="../../css/back/modifications.css" />

    <script src="../../javascript/front/navbar.js" defer></script>
    <script src="../../javascript/back/modification.js" defer></script>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="acceuil_admin.php">
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
          <li>
            <a href="creation.php" class="nav-btn1">Nouveau PDR</a>
          </li>
          <li><a href="recherche_admin.php" class="nav-btn1">Recherche</a></li>
          <li>
            <a href="../../index.php" class="nav-btn2"
              ><img
                src="../../image/avatar-de-connexion.png"
                class="Connexion"
              />Déconnexion</a
            >
          </li>
        </ul>
      </div>
    </nav>
    
    <main class="container" style="padding: 120px 24px 40px">
      <h2>Modifier un point de recharge :</h2>
      
      <div id="msg-retour" class="alert d-none mt-3" role="alert"></div>

      <form
        id="modification-form"
        method="post"
        action="#"
        style="margin-top: 18px"
      >
        <div
          style="
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            align-items: start;
          "
        >
          <div>
            <label>Nom station :</label>
            <input name="nom" class="form-control" value="" />
          </div>
          <div>
            <label>Nom opérateur :</label>
            <input name="operateur" class="form-control" value="" />
          </div>
          <div>
            <label>Enseigne :</label>
            <input name="enseigne" class="form-control" value="" />
          </div>

          <div>
            <label>Horaires :</label>
            <input name="horaires" class="form-control" value="" />
          </div>
          <div>
            <label>Tarif (€/kWh) :</label>
            <input name="tarif" class="form-control" value="" />
          </div>
          <div>
            <label>ID :</label>
            <input name="id" class="form-control" value="" readonly />
          </div>

          <div>
            <label>Type de prise :</label>
            <select name="prise" class="form-control">
              <option value="EF">EF (Prise Standard)</option>
              <option value="Type 2">Type 2</option>
              <option value="CCS">CCS</option>
              <option value="CHAdeMO">CHAdeMO</option>
            </select>
          </div>
          <div>
            <label>Longitude :</label>
            <input name="longitude" class="form-control" value="" />
          </div>
          <div>
            <label>Latitude :</label>
            <input name="latitude" class="form-control" value="" />
          </div>

          <div style="grid-column: 1 / span 2">
            <label>Adresse :</label>
            <input
              name="adresse"
              class="form-control"
              value=""
            />
          </div>
        </div>

        <div style="margin-top: 18px; text-align: right">
          <button type="submit" class="btn btn-success">Valider</button>
        </div>
      </form>
    </main>

    <footer class="footer">
      <div class="footer-content">
        <p>2026 Zapkartenn. Nathan & Alexandre - CIR2</p>
      </div>
    </footer>
  </body>
</html>