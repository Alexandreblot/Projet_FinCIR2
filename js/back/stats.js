window.addEventListener("DOMContentLoaded", function () {
  var urlAPI = "../../api/routes/stats.php";

  fetch(urlAPI)
    .then(function (reponseBrute) {
      return reponseBrute.json();
    })
    .then(function (donneesRecues) {
      console.log(donneesRecues);
// On met à jour les éléments du DOM avec les statistiques reçues de l'API
      var elementPdc = document.getElementById("compteur-pdc");
      var elementStations = document.getElementById("compteur-stations");
      var elementCommunes = document.getElementById("compteur-communes");
      var elementAmenageurs = document.getElementById("compteur-amenageurs");
      var elementOperateurs = document.getElementById("compteur-operateurs");

      if (elementPdc != null) {
        elementPdc.innerText = donneesRecues.total_points_charge;// Affiche le nombre total de points de charge
      }
      if (elementStations != null) {
        elementStations.innerText = donneesRecues.total_stations;// Affiche le nombre total de stations
      }
      if (elementCommunes != null) {
        elementCommunes.innerText = donneesRecues.total_communes;// Affiche le nombre total de communes
      }
      if (elementAmenageurs != null) {
        elementAmenageurs.innerText = donneesRecues.total_amenageurs;// Affiche le nombre total d'aménageurs
      }
      if (elementOperateurs != null) {
        elementOperateurs.innerText = donneesRecues.total_operateurs;// Affiche le nombre total d'opérateurs
      }
    })
    .catch(function (erreur) {
      console.error(
        "Erreur lors de la récupération des statistiques : ",
        erreur,
      );
    });
});
