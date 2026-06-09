window.addEventListener("DOMContentLoaded", function () {
  var btnRechercher = document.getElementById("btn-rechercher");
  var corpsTableau = document.getElementById("corps-tableau");
  var selectDept = document.getElementById("select-departement");
  var selectAmenageur = document.getElementById("select-amenageur");
// On va chercher les options pour les filtres de recherche (départements et aménageurs)
  if (selectDept && selectAmenageur) {
    
    // Remplissage du menu déroulant des Départements
    fetch("../../api/routes/filtres.php?type=departements")
      .then(function (reponse) {
        if (!reponse.ok) throw new Error("Erreur filtres départements");
        return reponse.json();
      })
      // On traite la liste des départements reçue de l'API pour remplir le select des départements
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

    // Remplissage du menu déroulant des Aménageurs
    fetch("../../api/routes/filtres.php?type=amenageurs")
      .then(function (reponse) {
        if (!reponse.ok) throw new Error("Erreur filtres aménageurs");
        return reponse.json();
      })
      // On traite la liste des aménageurs reçue de l'API pour remplir le select des aménageurs
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
// On vérifie que le bouton de recherche et le tableau existent avant d'ajouter l'événement de clic pour lancer la recherche
  if (btnRechercher && corpsTableau) {
    btnRechercher.addEventListener("click", function () {
      // On récupère les valeurs sélectionnées dans les filtres de recherche
      var dept = selectDept ? selectDept.value : "";
      var amenageur = selectAmenageur ? selectAmenageur.value : "";

      var estAdmin = window.location.pathname.includes("admin");
// On construit l'URL de l'API pour récupérer les stations en fonction des critères de recherche sélectionnés
      var urlAPI = "../../api/routes/station.php?departement=" + encodeURIComponent(dept) + "&amenageur=" + encodeURIComponent(amenageur);

      corpsTableau.innerHTML = "<tr><td colspan='4' class='text-center'>Chargement des stations...</td></tr>";
// On effectue la requête pour rechercher les stations en fonction des critères sélectionnés
      fetch(urlAPI)
        .then(function (reponse) {
          if (!reponse.ok) throw new Error("Erreur serveur : " + reponse.status);
          return reponse.json();
        })
        .then(function (stations) {
          corpsTableau.innerHTML = "";
// On vérifie que des stations ont été trouvées avant de les afficher
          if (!stations || stations.length === 0 || stations.message_erreur) {
            corpsTableau.innerHTML = "<tr><td colspan='4' class='text-center text-warning'>Aucune station trouvée pour ces critères.</td></tr>";
            return;
          }
// On parcourt les stations trouvées et on les affiche dans le tableau
          stations.forEach(function (station) {
            var tr = document.createElement("tr");

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
// Si on est sur la page d'administration, le bouton redirige vers la page de modification, sinon il redirige vers la page de détails
            if (estAdmin) {
              btnAction.href = "modification.php?id=" + encodeURIComponent(station.id_station);
              btnAction.className = "btn btn-sm btn-warning";
              btnAction.textContent = "Modifier";
            } else {
              btnAction.href = "details.php?id=" + encodeURIComponent(station.id_station);
              btnAction.className = "btn btn-sm btn-primary";
              btnAction.textContent = "Voir les détails";
            }
// On ajoute le bouton d'action à la cellule des actions, puis on ajoute la ligne au corps du tableau
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