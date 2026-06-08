window.addEventListener("DOMContentLoaded", function () {
  var selectStation = document.getElementById("select-station");

  if (selectStation) {
    var nomProjet = window.location.pathname.split('/')[1]; 
    var urlAPI = "/" + nomProjet + "/api/routes/liste_stations.php"; 

    console.log("Tentative de récupération des stations via :", urlAPI);

    fetch(urlAPI)
      .then(function (reponse) {
        if (!reponse.ok) {
          throw new Error("Erreur serveur : " + reponse.status);
        }
        return reponse.json();
      })
      .then(function (stations) {
        selectStation.innerHTML = "<option value=''>-- Choisissez une station --</option>";

        if (stations.message_erreur) {
          console.error("Erreur API :", stations.message_erreur);
          return;
        }

        stations.forEach(function (station) {
          var option = document.createElement("option");
          
          option.value = station.id_station; 
          
          option.textContent = station.nom_station + " (" + (station.nom_enseigne || "Sans enseigne") + ")";
          
          selectStation.appendChild(option);
        });
      })
      .catch(function (erreur) {
        console.error("Erreur lors du remplissage du menu déroulant :", erreur);
        selectStation.innerHTML = "<option value=''>Échec du chargement des stations</option>";
      });
  }
});