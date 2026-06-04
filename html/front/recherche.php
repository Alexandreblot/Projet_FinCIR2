<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zapkartenn - Recherche</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../css/front/recherche.css" />
    <link rel="stylesheet" href="../../css/front/navbar.css" />
    <link rel="stylesheet" href="../../css/front/footer.css" />
    <script src="../../javascript/front/navbar.js" defer></script>
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
          <li><a href="recherche.php" class="nav-btn1 active">Recherche</a></li>
          <li>
            <a href="../back/acceuil_admin.php" class="nav-btn2">
              <img src="../../image/avatar-de-connexion.png" class="Connexion" />Connexion
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container" style="margin-top: 100px; margin-bottom: 50px;">
      <h2 class="mb-4">Rechercher une station de recharge</h2>
      
      <form class="bg-light p-4 rounded shadow-sm mb-5">
        <div class="form-row">
          
          <div class="form-group col-md-5">
            <label for="select-departement">Département</label>
            <select id="select-departement" class="form-control">
              <option value="">Tous les départements</option>
              </select>
          </div>

          <div class="form-group col-md-5">
            <label for="select-amenageur">Aménageur</label>
            <select id="select-amenageur" class="form-control">
              <option value="">Tous les aménageurs</option>
              </select>
          </div>

          <div class="form-group col-md-2 align-self-end">
            <button id="btn-rechercher" class="btn btn-primary btn-block">Rechercher</button>
          </div>

        </div>
      </form>

      <table class="table table-striped table-hover shadow-sm">
        <thead class="thead-dark">
          <tr>
            <th>Enseigne</th>
            <th>Adresse</th>
            <th>Ville</th>
            <th>Action</th>
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

    <script src="../../javascript/front/recherche.js"></script>
  </body>
</html>