<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zapkartenn - Recherche</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="../../css/front/recherche.css" />
    <link rel="stylesheet" href="../../css/front/navbar.css" />
    <link rel="stylesheet" href="../../css/front/footer.css" />

    <script src="../../javascript/front/navbar.js" defer></script>
    <script src="../../javascript/front/recherche.js" defer></script>
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
            <a href="../back/acceuil_admin.php" class="nav-btn2"
              ><img src="../../image/avatar-de-connexion.png" class="Connexion" />Connexion</a
            >
          </li>
        </ul>
      </div>
    </nav>

    <main class="container" style="padding: 120px 24px 40px;">
      <h2>Rechercher un point de recharge :</h2>
      
      <form id="search-form" class="form-inline mt-3 bg-light p-3 rounded shadow-sm" onsubmit="return false;">
        
        <div class="form-group mr-3">
          <label for="select-departement" class="mr-2">Département :</label>
          <select id="select-departement" class="form-control">
            <option value="">Chargement...</option>
          </select>
        </div>

        <div class="form-group mr-3">
          <label for="select-amenageur" class="mr-2">Aménageur :</label>
          <select id="select-amenageur" class="form-control">
            <option value="">Chargement...</option>
          </select>
        </div>

        <button type="button" id="btn-rechercher" class="btn btn-primary">Filtrer</button>
      </form>

      <div id="message-filtres" class="alert alert-warning mt-3 d-none">
        Veuillez renseigner au moins un filtre (Département ou Aménageur) pour lancer la recherche.
      </div>

      <div class="table-responsive mt-4">
        <table class="table table-striped table-hover shadow-sm">
          <thead class="thead-dark">
            <tr>
              <th>Enseigne</th>
              <th>Adresse</th>
              <th>Ville / Département</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody id="corps-tableau">
            <tr>
              <td colspan="4" class="text-center text-muted">Utilisez les filtres ci-dessus pour afficher des stations.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>

    <footer class="footer">
      <div class="footer-content">
        <p>2026 Zapkartenn. Nathan & Alexandre - CIR2</p>
      </div>
    </footer>
  </body>
</html>