window.addEventListener("DOMContentLoaded", function() {

    var selectDept = document.getElementById("select-departement");
    var selectAmenageur = document.getElementById("select-amenageur");
    var boutonRechercher = document.getElementById("btn-rechercher");
    var corpsTableau = document.getElementById("corps-tableau");


    fetch("../../api/routes/filtres.php?type=departements")
        .then(function(reponseBrute) { 
            return reponseBrute.json(); 
        })
        .then(function(listeDepartements) {
            for (var i = 0; i < listeDepartements.length; i++) {
                var unDept = listeDepartements[i];
                
                var option = document.createElement("option");
                option.value = unDept.dep_nom;
                option.innerText = unDept.dep_nom;
                
                selectDept.appendChild(option);
            }
        });

    fetch("../../api/routes/filtres.php?type=amenageurs")
        .then(function(reponseBrute) { 
            return reponseBrute.json(); 
        })
        .then(function(listeAmenageurs) {
            for (var i = 0; i < listeAmenageurs.length; i++) {
                var unAmenageur = listeAmenageurs[i];
                
                var option = document.createElement("option");
                option.value = unAmenageur.nom;
                option.innerText = unAmenageur.nom;
                
                selectAmenageur.appendChild(option);
            }
        });



    if (boutonRechercher != null) {
        boutonRechercher.addEventListener("click", function(evenement) {
            evenement.preventDefault();

            var choixDept = selectDept.value;
            var choixAmenageur = selectAmenageur.value;

            var urlStations = "../../api/routes/stations.php?departement=" + choixDept + "&amenageur=" + choixAmenageur;

            fetch(urlStations)
                .then(function(reponseBrute) { 
                    return reponseBrute.json(); 
                })
                .then(function(listeStations) {
                    
                    console.log("Données reçues de l'API :", listeStations);
                    corpsTableau.innerHTML = "";

                    if (listeStations.length == 0) {
                        corpsTableau.innerHTML = "<tr><td colspan='4' class='text-center'>Aucune station ne correspond à vos critères.</td></tr>";
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
                        colVille.innerText = uneStation.nom + " (" + uneStation.dep_nom + ")";
                        ligne.appendChild(colVille);

                        var colAction = document.createElement("td");
                        var lienDetails = document.createElement("a");
                        
                        lienDetails.href = "details.php?id=" + uneStation.id_station;
                        
                        lienDetails.className = "btn btn-info btn-sm";
                        lienDetails.innerText = "Voir détails";
                        colAction.appendChild(lienDetails);
                        ligne.appendChild(colAction);

                        corpsTableau.appendChild(ligne);
                    }
                })
                .catch(function(erreur) {
                    console.error("Erreur lors du traitement de la recherche : ", erreur);
                });
        });
    }

});