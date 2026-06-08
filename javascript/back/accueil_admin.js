window.addEventListener("DOMContentLoaded", function() {
    var tbodyAdmin = document.getElementById("corps-tableau-admin");

    if (tbodyAdmin) {
        fetch("../../api/routes/liste_admin.php")
            .then(function(reponse) {
                return reponse.json();
            })
            .then(function(pointsDeCharge) {
                tbodyAdmin.innerHTML = "";

                if (pointsDeCharge.message_erreur) {
                    tbodyAdmin.innerHTML = "<tr><td colspan='6' class='text-center text-danger'>Erreur : " + pointsDeCharge.message_erreur + "</td></tr>";
                    return;
                }

                if (pointsDeCharge.length === 0) {
                    tbodyAdmin.innerHTML = "<tr><td colspan='6' class='text-center text-muted'>Aucun point de recharge répertorié.</td></tr>";
                    return;
                }

                for (var i = 0; i < pointsDeCharge.length; i++) {
                    var pdc = pointsDeCharge[i];
                    var ligne = document.createElement("tr");

                    var idPdc = pdc.id_pdc;
                    var nomStation = pdc.nom_station ? pdc.nom_station : (pdc.nom_enseigne + " - En attente");
                    var enseigne = pdc.nom_enseigne ? pdc.nom_enseigne : "N/C";
                    var puissance = pdc.puissance_nominale ? pdc.puissance_nominale + " kW" : "Inconnue";
                    var tarif = pdc.tarification ? pdc.tarification : "Standard";

                    var actionsHTML = 
                        "<a href='details_admin.php?id=" + pdc.id_station + "' class='btn btn-info btn-sm mr-1'>Détails</a>" +
                        "<a href='modification.php?id=" + pdc.id_pdc + "' class='btn btn-warning btn-sm'>Modifier</a>";

                    ligne.innerHTML = "<td><strong>#" + idPdc + "</strong></td>" +
                                      "<td>" + nomStation + "</td>" +
                                      "<td>" + enseigne + "</td>" +
                                      "<td>" + puissance + "</td>" +
                                      "<td>" + tarif + "</td>" +
                                      "<td>" + actionsHTML + "</td>";

                    tbodyAdmin.appendChild(ligne);
                }
            })
            .catch(function(erreur) {
                console.error("Erreur d'alimentation de l'accueil admin :", erreur);
                tbodyAdmin.innerHTML = "<tr><td colspan='6' class='text-center text-danger'>Impossible de joindre le serveur de données.</td></tr>";
            });
    }
});