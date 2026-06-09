window.addEventListener("DOMContentLoaded", function () {
  var estAdmin = window.location.pathname.includes("admin");

  var prefixePath = estAdmin ? "../../api/routes/" : "../../api/routes/";

  var btnRechercher = document.getElementById("btn-rechercher");
  var corpsTableau = document.getElementById("corps-tableau");
  var selectDept = document.getElementById("select-departement");
  var selectAmenageur = document.getElementById("select-amenageur");


  if (selectDept && selectAmenageur) {
    
    fetch(prefixePath + "filtres.php?type=departements")
      .then(function (reponse) {
        if (!reponse.ok) throw new Error("Erreur filtres départements");
        return reponse.json();
      })
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
      .catch(function (erreur) {
        console.error("Erreur lors de la récupération des départements :", erreur);
      });

    fetch(prefixePath + "filtres.php?type=amenageurs")
      .then(function (reponse) {
        if (!reponse.ok) throw new Error("Erreur filtres aménageurs");
        return reponse.json();
      })
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
      .catch(function (erreur) {
        console.error("Erreur lors de la récupération des aménageurs :", erreur);
      });
  }


  if (btnRechercher && corpsTableau) {
    btnRechercher.addEventListener("click", function () {
      var dept = selectDept ? selectDept.value : "";
      var amenageur = selectAmenageur ? selectAmenageur.value : "";

      var urlAPI = prefixePath + "station.php?departement=" + encodeURIComponent(dept) + "&amenageur=" + encodeURIComponent(amenageur);

      corpsTableau.innerHTML = "<tr><td colspan='4' class='text-center'>Chargement des stations...</td></tr>";

      fetch(urlAPI)
        .then(function (reponse) {
          if (!reponse.ok) throw new Error("Erreur serveur : " + reponse.status);
          return reponse.json();
        })
        .then(function (stations) {
          corpsTableau.innerHTML = "";

          if (!stations || stations.length === 0 || stations.message_erreur) {
            corpsTableau.innerHTML = "<tr><td colspan='4' class='text-center text-warning'>Aucune station trouvée pour ces critères.</td></tr>";
            return;
          }

          stations.forEach(function (station) {
            var tr = document.createElement("tr");

            // Colonne Enseigne
            var tdEnseigne = document.createElement("td");
            tdEnseigne.textContent = station.nom_enseigne || "N/C";
            tr.appendChild(tdEnseigne);

            var tdAdresse = document.createElement("td");
            tdAdresse.textContent = station.adresse || "Adresse non renseignée";
            tr.appendChild(tdAdresse);

            var tdVille = document.createElement("td");
            tdVille.textContent = station.nom || (station.dep_nom ? "Département " + station.dep_nom : "N/C");
            tr.appendChild(tdVille);

            var tdActions = document.createElement("td");
            tdActions.className = "text-center";

            var btnAction = document.createElement("a");
            
            if (estAdmin) {
              btnAction.href = "modification.php?id=" + encodeURIComponent(station.id_station);
              btnAction.className = "btn btn-sm btn-warning";
              btnAction.textContent = "Modifier";
            } else {
              btnAction.href = "details.php?id=" + encodeURIComponent(station.id_station);
              btnAction.className = "btn btn-sm btn-primary";
              btnAction.textContent = "Voir les détails";
            }

            tdActions.appendChild(btnAction);
            tr.appendChild(tdActions);
            corpsTableau.appendChild(tr);
          });
        })
        .catch(function (erreur) {
          console.error("Erreur lors de la recherche :", erreur);
          corpsTableau.innerHTML = "<tr><td colspan='4' class='text-center text-danger'>Échec du chargement des données.</td></tr>";
        });
    });
  }
});