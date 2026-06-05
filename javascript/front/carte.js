window.addEventListener("DOMContentLoaded", function () {

  var markersLayer = L.layerGroup().addTo(map);

  function afficherMarqueurs(liste) {
    markersLayer.clearLayers();

    liste.forEach(function (s) {
      var marker = L.marker([parseFloat(s.latitude), parseFloat(s.longitude)]);

      marker.bindPopup("<strong>" + (s.nom_station || "Borne") + "</strong>");

      marker.on("click", function () {
        document.getElementById("info-placeholder").style.display = "none";
        document.getElementById("nom-station").textContent ="Informations : " + (s.nom_station || "Borne");
        document.getElementById("raccordement").textContent ="Raccordement : " + (s.raccordement || "N/A");
        document.getElementById("adresse").textContent ="Adresse : " + (s.adresse || "N/A");
        document.getElementById("horaires").textContent ="Horaires : " + (s.horaires || "N/A");
        document.getElementById("date_mise_en_service").textContent ="Date de mise en service : " + (s.date_mise_en_service || "N/A");
        document.getElementById("implantation").textContent ="Implantation : " + (s.implantation || "N/A");
      });
      markersLayer.addLayer(marker);
    });
  }

  function filtrerEtAfficher() {
    var dept = document.getElementById("departement").value;
    var annee = document.getElementById("annee-installation").value;

    var filtered = stationsData.filter(function (s) {
      var okDept = !dept || s.dep_nom === dept;
      var okAnnee =
        !annee ||
        (s.date_mise_en_service && s.date_mise_en_service.startsWith(annee));
      return okDept && okAnnee;
    });

    afficherMarqueurs(filtered);
  }
  afficherMarqueurs(stationsData);

  document
    .getElementById("departement")
    .addEventListener("change", filtrerEtAfficher);
  document
    .getElementById("annee-installation")
    .addEventListener("change", filtrerEtAfficher);




    
  var selectDept = document.getElementById("departement");
  if (selectDept) {
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
      })
      .catch(function (error) {
        console.error("Erreur chargement départements:", error);
      });
  }

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
