<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zapkartenn - Recherche Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../css/back/modifications.css" />
    <link rel="stylesheet" href="../../css/back/navbar_admin.css" />
    <link rel="stylesheet" href="../../css/back/footer_admin.css" />
    <script src="../../js/front/navbar.js" defer></script>
    <script src="../../js/back/recherche_admin.js" defer></script>
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
          <li><a href="recherche_admin.php" class="nav-btn1 active">Recherche</a></li>
          <li>
            <a href="../../index.php" class="nav-btn2">
              <img src="../../image/avatar-de-connexion.png" class="Connexion" />Déconnexion
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container" style="margin-top: 120px; margin-bottom: 50px;">
      <h2 class="mb-4">Gestion des stations (Administration)</h2>
      
      <form id="form-recherche-admin" class="bg-light p-4 rounded shadow-sm mb-5" onsubmit="return false;">
        <div class="form-row">
          
          <div class="form-group col-md-5">
            <label for="select-departement">Département</label>
            <select id="select-departement" class="form-control">
              <option value="">Chargement...</option>
            </select>
          </div>

          <div class="form-group col-md-5">
            <label for="select-amenageur">Aménageur</label>
            <select id="select-amenageur" class="form-control">
              <option value="">Chargement...</option>
            </select>
          </div>

          <div class="form-group col-md-2 align-self-end">
            <button type="button" id="btn-rechercher" class="btn btn-info btn-block">Rechercher</button>
          </div>

        </div>
      </form>

      <table class="table table-striped table-hover shadow-sm">
        <thead class="thead-dark">
          <tr>
            <th>Enseigne</th>
            <th>Adresse</th>
            <th>Ville / Département</th>
            <th class="text-center">Actions Administrateur</th>
          </tr>
        </thead>
        <tbody id="corps-tableau">
          <tr>
            <td colspan="4" class="text-center text-muted">Veuillez choisir vos filtres et cliquer sur Rechercher.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <footer class="footer">
      <div class="footer-content">
        <p>2026 Zapkartenn. Nathan & Alexandre - CIR2</p>
      </div>
    </footer>
  </body>
</html>