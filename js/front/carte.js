window.addEventListener("DOMContentLoaded", function () {
  var markersLayer = L.layerGroup().addTo(map);

  // On va chercher la liste des stations pour les afficher sur la carte
  function afficherMarqueurs(liste) {
    markersLayer.clearLayers();

    liste.forEach(function (s) {
      var marker = L.marker([parseFloat(s.latitude), parseFloat(s.longitude)]);
      // On prépare le contenu de la popup pour chaque station
      var popupContent = "<strong>" + (s.nom_station || "Borne") + "</strong>";
      marker.bindPopup(popupContent);

      // On affiche les détails de la station dans la section d'information lorsque l'utilisateur clique sur le marqueur
      marker.on("click", function () {
        // On masque le message d'information par défaut et on affiche les détails de la station
        document.getElementById("info-placeholder").style.display = "none";
        document.getElementById("nom-station").textContent =
          "Informations : " + (s.nom_station || "Borne");

        document.getElementById("raccordement").textContent =
          "Raccordement : " + (s.raccordement || "N/A");
        document.getElementById("puissance").textContent =
          "Puissance : " + (s.puissance_max ? s.puissance_max + " kW" : "N/A");
        document.getElementById("adresse").textContent =
          "Adresse : " + (s.adresse || "N/A");
        document.getElementById("horaires").textContent =
          "Horaires : " + (s.horaires || "N/A");
        document.getElementById("date_mise_en_service").textContent =
          "Date de mise en service : " + (s.date_mise_en_service || "N/A");
        document.getElementById("implantation").textContent =
          "Implantation : " + (s.implantation || "N/A");

        // On affiche les informations sur les prises disponibles pour la station
        var detailsLink = document.getElementById("details-link");
        if (detailsLink) {
          var stationId = s.id_station || s.id;
          if (stationId) {
            detailsLink.href =
              "details.php?id=" + encodeURIComponent(stationId);
            detailsLink.style.display = "inline-block";
          } else {
            detailsLink.style.display = "none";
          }
        }
      });
      markersLayer.addLayer(marker);
    });
  }

  // Fonction pour filtrer les stations en fonction des critères sélectionnés et mettre à jour les marqueurs affichés sur la carte
  function filtrerEtAfficher() {
    var dept = document.getElementById("departement").value;
    var annee = document.getElementById("annee-installation").value;

    // On filtre les données des stations en fonction des critères sélectionnés
    var filtered = stationsData.filter(function (s) {
      var okDept = !dept || s.dep_nom === dept;
      var okAnnee =
        !annee ||
        (s.date_mise_en_service && s.date_mise_en_service.startsWith(annee));
      return okDept && okAnnee;
    });

    // On affiche les marqueurs correspondants aux stations filtrées
    afficherMarqueurs(filtered);
  }

  afficherMarqueurs(stationsData);
// On ajoute les événements de changement sur les filtres pour mettre à jour les marqueurs affichés en fonction des critères sélectionnés
  document
    .getElementById("departement")
    .addEventListener("change", filtrerEtAfficher);
  document
    .getElementById("annee-installation")
    .addEventListener("change", filtrerEtAfficher);

  // On va chercher les départements pour remplir les filtres
  var selectDept = document.getElementById("departement");
  if (selectDept) { // On va chercher les options pour les filtres de recherche (départements)
    fetch("../../api/routes/filtres.php?type=departements")
      .then(function (reponseBrute) {
        return reponseBrute.json();
      })
      // On remplit les options du select des départements avec les données reçues de l'API
      .then(function (listeDepartements) {
        for (var i = 0; i < listeDepartements.length; i++) {
          var unDept = listeDepartements[i];

          var option = document.createElement("option");
          option.value = unDept.nom;
          option.innerText = unDept.nom;

          selectDept.appendChild(option);
        }
      })
      .catch(function (error) {
        console.error("Erreur chargement départements:", error);
      });
  }

  // On va chercher les années d'installation pour remplir le select des années
  var selectAnnee = document.getElementById("annee-installation");
  if (selectAnnee) {
    fetch("../../api/routes/filtres.php?type=annees")
      .then(function (reponseBrute) {
        return reponseBrute.json();
      })
      .then(function (listeAnnees) {
        for (var i = 0; i < listeAnnees.length; i++) {
          var item = listeAnnees[i];

          var option = document.createElement("option");
          option.value = item.annee;
          option.innerText = item.annee;

          selectAnnee.appendChild(option);
        }
      })
      .catch(function (error) {
        console.error("Erreur chargement années:", error);
      });
  }
});
