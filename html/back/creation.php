<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zapkartenn - Nouveau PDR</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../css/back/navbar_admin.css" />
    <link rel="stylesheet" href="../../css/back/footer_admin.css" />
    <link rel="stylesheet" href="../../css/back/modifications.css" />
    <script src="../../javascript/front/navbar.js" defer></script>
    <script src="../../javascript/back/creation.js" defer></script>
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
    
    <main class="container" style="padding: 120px 24px 40px">
      <h2>Création d'un point de recharge :</h2>
      <div id="msg-retour" class="alert d-none mt-3"></div>

      <form id="creation-form" style="margin-top: 18px">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; align-items: start;">
          
          <div style="grid-column: 1 / span 3">
            <label class="font-weight-bold text-info">Sélectionner la Station de rattachement * :</label>
            <select name="id_station" id="select-station-liaison" class="form-control" required>
              <option value="">-- Choisissez une station existante --</option>
            </select>
          </div>

          <div>
            <label>Puissance nominale (kW) :</label>
            <input name="puissance" id="puissance" type="number" class="form-control" value="22" required />
          </div>
          <div>
            <label>Tarif (€/kWh) :</label>
            <input name="tarif" id="tarif" class="form-control" placeholder="Ex: 0.49" />
          </div>
          <div>
            <label>Accès Gratuit ?</label>
            <select name="gratuit" id="gratuit" class="form-control">
              <option value="Non">Non (Payant)</option>
              <option value="Oui">Oui (Gratuit)</option>
            </select>
          </div>

          <div>
            <label>Prise Domestique (EF) :</label>
            <select name="prise_ef" id="prise_ef" class="form-control">
              <option value="Non">Non</option>
              <option value="Oui">Oui</option>
            </select>
          </div>
          <div>
            <label>Prise Type 2 (T2) :</label>
            <select name="prise_t2" id="prise_t2" class="form-control">
              <option value="Oui">Oui</option>
              <option value="Non">Non</option>
            </select>
          </div>
          <div>
            <label>Prise Combo CCS :</label>
            <select name="prise_ccs" id="prise_ccs" class="form-control">
              <option value="Non">Non</option>
              <option value="Oui">Oui</option>
            </select>
          </div>
          
          <div>
            <label>Prise CHAdeMO :</label>
            <select name="chademo" id="chademo" class="form-control">
              <option value="Non">Non</option>
              <option value="Oui">Oui</option>
            </select>
          </div>
          <div style="grid-column: 2 / span 2">
            <label>Moyens de paiement acceptés :</label>
            <input name="paiement" id="paiement" class="form-control" placeholder="Ex: Carte bancaire, Application" />
          </div>
        </div>

        <div style="margin-top: 18px; text-align: right">
          <a href="acceuil_admin.php" class="btn btn-secondary mr-2">Retour</a>
          <button type="submit" class="btn btn-success">Valider la création</button>
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