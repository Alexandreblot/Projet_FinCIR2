window.addEventListener("DOMContentLoaded", function() {

    var urlAPI = "api/routes/stats.php";

    fetch(urlAPI)
        .then(function(reponseBrute) {
            return reponseBrute.json();
        })
        .then(function(donneesRecues) {
            console.log(donneesRecues);

            var elementPdc = document.getElementById("compteur-pdc");
            var elementStations = document.getElementById("compteur-stations");
            var elementCommunes = document.getElementById("compteur-communes");
            var elementAmenageurs = document.getElementById("compteur-amenageurs");
            var elementOperateurs = document.getElementById("compteur-operateurs");

            if (elementPdc != null) {
                elementPdc.innerText = donneesRecues.total_points_charge;
            }
            if (elementStations != null) {
                elementStations.innerText = donneesRecues.total_stations;
            }
            if (elementCommunes != null) {
                elementCommunes.innerText = donneesRecues.total_communes;
            }
            if (elementAmenageurs != null) {
                elementAmenageurs.innerText = donneesRecues.total_amenageurs;
            }
            if (elementOperateurs != null) {
                elementOperateurs.innerText = donneesRecues.total_operateurs;
            }
        })
        .catch(function(erreur) {
            console.error("Erreur lors de la récupération des statistiques : ", erreur);
        });

});