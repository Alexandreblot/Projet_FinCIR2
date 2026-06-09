window.addEventListener("DOMContentLoaded", function () {
  var btnRechercher = document.getElementById("btn-rechercher");
  var corpsTableau = document.getElementById("corps-tableau");
  var selectDept = document.getElementById("select-departement");
  var selectAmenageur = document.getElementById("select-amenageur");

  if (selectDept && selectAmenageur) {
// On va chercher les options pour les filtres de recherche (départements et aménageurs)
    fetch("../../api/routes/filtres.php?type=departements")
      .then(function (reponse) {
        if (!reponse.ok) throw new Error("Erreur filtres départements");
        return reponse.json();
      })
// On remplit les options du select des départements avec les données reçues de l'API
      .then(function (departements) {
        selectDept.innerHTML = '<option value="">Tous les départements</option>';
        departements.forEach(function (item) {
          if (item.nom) {
            var opt = document.createElement("option");
            opt.value = item.nom;
            opt.textContent = item.nom;
            selectDept.appendChild(opt);
          }
        });
      })
// En cas d'erreur lors du chargement des départements, on affiche une option d'erreur dans le select
      .catch(function (erreur) {
        console.error("Erreur lors de la récupération des départements :", erreur);
        selectDept.innerHTML = '<option value="">Erreur de chargement</option>';
      });
// On va chercher les options pour les filtres de recherche (départements et aménageurs)
    fetch("../../api/routes/filtres.php?type=amenageurs")
      .then(function (reponse) {
        if (!reponse.ok) throw new Error("Erreur filtres aménageurs");
        return reponse.json();
      })
// On remplit les options du select des aménageurs avec les données reçues de l'API
      .then(function (amenageurs) {
        selectAmenageur.innerHTML = '<option value="">Tous les aménageurs</option>';
        amenageurs.forEach(function (item) {
          if (item.nom) {
            var opt = document.createElement("option");
            opt.value = item.nom;
            opt.textContent = item.nom;
            selectAmenageur.appendChild(opt);
          }
        });
      })
// En cas d'erreur lors du chargement des aménageurs, on affiche une option d'erreur dans le select
      .catch(function (erreur) {
        console.error("Erreur lors de la récupération des aménageurs :", erreur);
        selectAmenageur.innerHTML = '<option value="">Erreur de chargement</option>';
      });
  }

// On vérifie que le bouton de recherche et le tableau existent avant d'ajouter l'événement de clic pour lancer la recherche
  if (btnRechercher && corpsTableau) {
    btnRechercher.addEventListener("click", function () {
      var dept = selectDept ? selectDept.value : "";
      var amenageur = selectAmenageur ? selectAmenageur.value : "";

      var estAdmin = window.location.pathname.includes("admin");

      var urlAPI =
        "../../api/routes/station.php?departement=" +
        encodeURIComponent(dept) +
        "&amenageur=" +
        encodeURIComponent(amenageur);

      corpsTableau.innerHTML =
        "<tr><td colspan='4' class='text-center'>Chargement des stations...</td></tr>";
// On effectue la requête pour rechercher les stations en fonction des critères sélectionnés
      fetch(urlAPI)
        .then(function (reponse) {
          if (!reponse.ok)
            throw new Error("Erreur serveur : " + reponse.status);
          return reponse.json();
        })
        .then(function (stations) {
          corpsTableau.innerHTML = "";

          if (!stations || stations.length === 0 || stations.message_erreur) {
            corpsTableau.innerHTML =
              "<tr><td colspan='4' class='text-center text-warning'>Aucune station trouvée pour ces critères.</td></tr>";
            return;
          }
// On parcourt les stations reçues et on les affiche dans le tableau
          stations.forEach(function (station) {
            var tr = document.createElement("tr");

            var tdEnseigne = document.createElement("td");
            tdEnseigne.textContent = station.nom_enseigne || "N/C";
            tr.appendChild(tdEnseigne);

            var tdAdresse = document.createElement("td");
            tdAdresse.textContent = station.adresse || "Adresse non renseignée";
            tr.appendChild(tdAdresse);

            var tdVille = document.createElement("td");
            tdVille.textContent =
              station.nom ||
              (station.dep_nom ? "Département " + station.dep_nom : "N/C");
            tr.appendChild(tdVille);

            var tdActions = document.createElement("td");
            tdActions.className = "text-center";

            // Bouton modifier
            var btnAction = document.createElement("a");

            if (estAdmin) {
              btnAction.href = "modification.php?id=" + station.id_station;
              btnAction.className = "btn btn-sm btn-warning mr-2";
              btnAction.textContent = "Modifier";
              tdActions.appendChild(btnAction);

              // bouton supprimer
              var btnSupprimer = document.createElement("button");
              btnSupprimer.className = "btn btn-sm btn-danger";
              btnSupprimer.textContent = "Supprimer";

              btnSupprimer.addEventListener("click", function () {
                supprimerStation(station.id_station);
              });

              tdActions.appendChild(btnSupprimer);
            } else {
              btnAction.href = "details.php?id=" + station.id_station;
              btnAction.className = "btn btn-sm btn-primary";
              btnAction.textContent = "Voir les détails";
              tdActions.appendChild(btnAction);
            }
// On ajoute les actions à la ligne du tableau
            tr.appendChild(tdActions);
            corpsTableau.appendChild(tr);
          });
        })
        .catch(function (erreur) {
          console.error("Erreur lors de la recherche :", erreur);
          corpsTableau.innerHTML =
            "<tr><td colspan='4' class='text-center text-danger'>Échec du chargement des données.</td></tr>";
        });
    });
  }
});

// suppression d'une station
function supprimerStation(idStation) {
  if (
    confirm(
      "Êtes-vous sûr de vouloir supprimer définitivement cette station ainsi que tous ses points de charge ?",
    )
  ) {
    var urlAPIDelete =
      "../../api/routes/supprimer_station.php?id=" +
      encodeURIComponent(idStation);
// On envoie la requête de suppression à l'API
    fetch(urlAPIDelete, {
      method: "DELETE",
    })
      .then(function (reponse) {
        if (!reponse.ok)
          throw new Error("Erreur serveur lors de la suppression.");
        return reponse.json();
      })
      .then(function (resultat) {
        if (resultat.success) {
          alert(resultat.message);
// Après la suppression, on relance la recherche pour mettre à jour le tableau
          var btnRechercher = document.getElementById("btn-rechercher");
          if (btnRechercher) {
            btnRechercher.click();
          }
        } else {
          alert("Erreur : " + resultat.message);
        }
      })
      .catch(function (erreur) {
        console.error("Erreur lors de la suppression :", erreur);
        alert(
          "Une erreur technique est survenue lors de la suppression de la station.",
        );
      });
  }
}