window.addEventListener("DOMContentLoaded", function () {
  
  var selectStation = document.getElementById("select-station-liaison");

  if (selectStation) {
    var urlAPIListe = "../../api/routes/station.php"; 

    fetch(urlAPIListe)
      .then(function (reponse) {
        if (!reponse.ok) {
          throw new Error("Erreur statut serveur : " + reponse.status);
        }
        return reponse.json();
      })
      .then(function (stations) {
        selectStation.innerHTML = "<option value=''>-- Choisissez une station existante --</option>";

        if (stations.message_erreur) {
          console.error("Erreur renvoyée par l'API :", stations.message_erreur);
          return;
        }

        stations.forEach(function (station) {
          var option = document.createElement("option");
          option.value = station.id_station; 
          
          var affichageNom = station.nom_enseigne || "Station sans enseigne";
          if (station.adresse) {
            affichageNom += " - " + station.adresse;
          }
          
          option.textContent = affichageNom;
          selectStation.appendChild(option);
        });
      })
      .catch(function (erreur) {
        console.error("Erreur lors du chargement des stations :", erreur);
        selectStation.innerHTML = "<option value=''>Échec du chargement des stations</option>";
      });
  }

  var formCreation = document.getElementById("creation-form");
  var msgRetour = document.getElementById("msg-retour");

  if (formCreation) {
    formCreation.addEventListener("submit", function (evenement) {
      evenement.preventDefault(); 

      var urlAPICreation = "../../api/routes/creer_pdr.php";

      var donneesFormulaire = new FormData(formCreation);

      fetch(urlAPICreation, {
        method: "POST",
        body: donneesFormulaire
      })
      .then(function (reponse) {
        return reponse.json();
      })
      .then(function (resultat) {
        if (msgRetour) {
          msgRetour.classList.remove("d-none", "alert-danger", "alert-success");

          if (resultat.message_erreur) {
            msgRetour.classList.add("alert-danger");
            msgRetour.textContent = resultat.message_erreur;
          } else {
            msgRetour.classList.add("alert-success");
            msgRetour.textContent = resultat.message_succes;
            formCreation.reset(); 
          }
        }
      })
      .catch(function (erreur) {
        console.error("Erreur lors de l'insertion :", erreur);
        if (msgRetour) {
          msgRetour.classList.remove("d-none", "alert-success");
          msgRetour.classList.add("alert-danger");
          msgRetour.textContent = "Une erreur technique est survenue lors de l'enregistrement.";
        }
      });
    });
  }
});