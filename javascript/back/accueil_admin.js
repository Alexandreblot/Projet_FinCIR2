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
                    tbodyAdmin.innerHTML = "<tr><td colspan='6' class='text-center' style='color: rgba(255,255,255,0.6);'>Aucun enregistrement trouvé.</td></tr>";
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

                    // CORRECTION DU LIEN : Redirection vers le fichier d'administration back details_admin.php
                    var urlDetails = "details_admin.php?id=" + pdc.id_station;
                    var urlModification = "modification.php?id=" + pdc.id_pdc;

                    var actionsHTML = 
                        "<a href='" + urlDetails + "' class='btn btn-info btn-sm mr-2' style='border-radius:15px; font-size:12px;'>Détails</a>" +
                        "<a href='" + urlModification + "' class='btn btn-warning btn-sm' style='border-radius:15px; font-size:12px; color:#111;'>Modifier</a>";

                    ligne.innerHTML = "<td style='font-weight: bold; color: #f87171;'>#" + idPdc + "</td>" +
                                      "<td>" + nomStation + "</td>" +
                                      "<td>" + enseigne + "</td>" +
                                      "<td><span class='badge badge-secondary' style='background: rgba(255,255,255,0.2); font-size:13px;'>" + puissance + "</span></td>" +
                                      "<td>" + tarif + "</td>" +
                                      "<td>" + actionsHTML + "</td>";

                    tbodyAdmin.appendChild(ligne);
                }
            })
            .catch(function(erreur) {
                console.error("Erreur serveur registre :", erreur);
                tbodyAdmin.innerHTML = "<tr><td colspan='6' class='text-center text-danger'>Échec de la connexion avec la passerelle API.</td></tr>";
            });
    }
});