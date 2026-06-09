window.addEventListener("DOMContentLoaded", function () {
  // On récupère l'id de la station à afficher depuis les paramètres de l'URL
  var parametres = new URLSearchParams(window.location.search);
  var idStation = parametres.get("id");
// On sélectionne les éléments du DOM où afficher les détails de la station
  var titreStation = document.getElementById("titre-station");
  var detNom = document.getElementById("det-nom");
  var detEnseigne = document.getElementById("det-enseigne");
  var detAdresse = document.getElementById("det-adresse");
  var detHoraires = document.getElementById("det-horaires");
  var detDateService = document.getElementById("det-date-service");
  var detPuissance = document.getElementById("det-puissance");
  var detPrises = document.getElementById("det-prises");
  var detGratuit = document.getElementById("det-gratuit");
// On vérifie que l'ID de station est présent dans l'URL avant de faire la requête pour afficher les détails
  if (!idStation) {
    if (titreStation) titreStation.textContent = "Erreur : Aucune station sélectionnée.";
    return;
  }
// On construit l'URL de l'API pour récupérer les détails de la station en utilisant l'ID récupéré
  var nomProjet = window.location.pathname.split('/')[1]; 
  var urlAPI = "/" + nomProjet + "/api/routes/details.php?id=" + idStation;

  console.log("Tentative d'appel de l'API à l'adresse :", urlAPI);
// On effectue la requête pour récupérer les détails de la station
  fetch(urlAPI)
    .then(function (reponse) {
      if (!reponse.ok) {
        throw new Error("Le serveur a répondu avec un statut " + reponse.status);
      }
      return reponse.json();
    })
    .then(function (donnees) {
      if (donnees.message_erreur) {
        if (titreStation) titreStation.textContent = "Station introuvable.";
        return;
      }
// On vérifie que les données reçues contiennent les informations nécessaires avant de les afficher
      console.log("Données reçues avec succès :", donnees);
      var nom = donnees.nom_station || donnees.nom_enseigne || "Station sans nom";
      if (titreStation) titreStation.textContent = nom;
      if (detNom) detNom.textContent = nom;
      
      if (detEnseigne) detEnseigne.textContent = donnees.nom_enseigne || donnees.enseigne || "N/C";
      
      if (detAdresse) detAdresse.textContent = donnees.adresse_station || donnees.adresse || "Adresse non renseignée";
      
      if (detHoraires) detHoraires.textContent = donnees.horaires_ouverture || donnees.horaires || "Non spécifiés";
      
      if (detDateService) {
        var dateBrute = donnees.date_mise_en_service || donnees.date_service;
        
        if (!dateBrute || dateBrute === "0000-00-00") {
          detDateService.textContent = "Non renseignée";
        } else {
          var parties = dateBrute.split("-");
          if (parties.length === 3) {
            detDateService.textContent = parties[2] + "/" + parties[1] + "/" + parties[0];
          } else {
            detDateService.textContent = dateBrute;
          }
        }
      }
// Pour la puissance, on vérifie d'abord si le champ "puissance_nominale" existe, sinon on regarde si un champ "puissance" existe
      var pwr = donnees.puissance_nominale || donnees.puissance;
      if (detPuissance) detPuissance.textContent = pwr ? pwr + " kW" : "Inconnue";
      
      if (detPrises) detPrises.textContent = donnees.type_prise || donnees.type_prises || "Standard";
      
      var gratuit = donnees.acces_gratuit || donnees.gratuit;
      if (detGratuit) {
        if (gratuit === "oui" || gratuit === true || gratuit === 1 || gratuit === "OUI") {
          detGratuit.textContent = "Oui";
        } else {
          detGratuit.textContent = "Non";
        }
      }
    })
    .catch(function (erreur) {
      console.error("Erreur détails :", erreur);
      if (titreStation) titreStation.textContent = "Échec du chargement des données.";
    });
});