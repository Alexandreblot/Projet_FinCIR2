window.addEventListener("DOMContentLoaded", function () {
  var selectDept = document.getElementById("select-departement");
  var selectAmenageur = document.getElementById("select-amenageur");
  var boutonRechercher = document.getElementById("btn-rechercher");
  var corpsTableau = document.getElementById("corps-tableau");

  // Chargement du filtre départements
  fetch("../../api/routes/filtres.php?type=departements")
    .then(function (reponseBrute) {
      return reponseBrute.json();
    })
    .then(function (listeDepartements) {
      for (var i = 0; i < listeDepartements.length; i++) {
        var unDept = listeDepartements[i];

        var option = document.createElement("option");
        option.value = unDept.dep_nom;
        option.innerText = unDept.dep_nom;

        selectDept.appendChild(option);
      }
    });

  // Chargement du filtre aménageurs
  fetch("../../api/routes/filtres.php?type=amenageurs")
    .then(function (reponseBrute) {
      return reponseBrute.json();
    })
    .then(function (listeAmenageurs) {
      for (var i = 0; i < listeAmenageurs.length; i++) {
        var unAmenageur = listeAmenageurs[i];

        var option = document.createElement("option");
        option.value = unAmenageur.nom;
        option.innerText = unAmenageur.nom;

        selectAmenageur.appendChild(option);
      }
    });

  if (boutonRechercher != null) {
    boutonRechercher.addEventListener("click", function (evenement) {
      evenement.preventDefault();

      var choixDept = selectDept.value;
      var choixAmenageur = selectAmenageur.value;

      var urlStations =
        "../../api/routes/stations.php?departement=" +
        choixDept +
        "&amenageur=" +
        choixAmenageur;

      fetch(urlStations)
        .then(function (reponseBrute) {
          return reponseBrute.json();
        })
        .then(function (listeStations) {
          console.log("Données reçues de l'API :", listeStations);
          corpsTableau.innerHTML = "";

          if (listeStations.length == 0) {
            corpsTableau.innerHTML =
              "<tr><td colspan='4' class='text-center'>Aucune station ne correspond à vos critères.</td></tr>";
            return;
          }

          for (var i = 0; i < listeStations.length; i++) {
            var uneStation = listeStations[i];

            var ligne = document.createElement("tr");

            var colEnseigne = document.createElement("td");
            colEnseigne.innerText = uneStation.nom_enseigne;
            ligne.appendChild(colEnseigne);

            var colAdresse = document.createElement("td");
            colAdresse.innerText = uneStation.adresse;
            ligne.appendChild(colAdresse);

            var colVille = document.createElement("td");
            colVille.innerText =
              uneStation.nom + " (" + uneStation.dep_nom + ")";
            ligne.appendChild(colVille);

            // --- SECTION MODIFIÉE : BOUTONS DE L'ADMINISTRATEUR ---
            var colAction = document.createElement("td");

            // 1. Création du bouton Modifier
            var lienModifier = document.createElement("a");
            lienModifier.href = "modification.php?id=" + uneStation.id_station;
            lienModifier.className = "btn btn-warning btn-sm mr-2"; // 'mr-2' ajoute un petit espace à droite
            lienModifier.innerText = "Modifier";
            colAction.appendChild(lienModifier);

            // 2. Création du bouton Supprimer
            var boutonSupprimer = document.createElement("button");
            boutonSupprimer.className = "btn btn-danger btn-sm";
            boutonSupprimer.innerText = "Supprimer";

            // Association de l'événement clic à la fonction de suppression
            (function (idStation) {
              boutonSupprimer.addEventListener("click", function () {
                supprimerStation(idStation);
              });
            })(uneStation.id_station);

            colAction.appendChild(boutonSupprimer);
            ligne.appendChild(colAction);

            corpsTableau.appendChild(ligne);
          }
        })
        .catch(function (erreur) {
          console.error("Erreur lors du traitement de la recherche : ", erreur);
        });
    });
  }

  // --- FONCTION DE SUPPRESSION ---
  function supprimerStation(id) {
    if (
      confirm(
        "Êtes-vous sûr de vouloir supprimer définitivement cette station de recharge ?",
      )
    ) {
      // Appel vers votre route API de suppression (Ex: supprimer_station.php)
      fetch("../../api/routes/supprimer_station.php?id=" + id, {
        method: "GET",
      })
        .then(function (reponseBrute) {
          return reponseBrute.json();
        })
        .then(function (resultat) {
          if (resultat.statut === "ok" || resultat.success === true) {
            alert("La station a été supprimée avec succès.");
            boutonRechercher.click();
          } else {
            alert(
              "Erreur lors de la suppression : " +
                (resultat.message || "Erreur inconnue"),
            );
          }
        })
        .catch(function (erreur) {
          console.error("Erreur lors de la suppression :", erreur);
          alert(
            "Impossible de joindre le serveur pour effectuer la suppression.",
          );
        });
    }
  }
});
