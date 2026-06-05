window.addEventListener("DOMContentLoaded", function() {
    var parametres = new URLSearchParams(window.location.search);
    var idStation = parametres.get("id");

    if (idStation) {
        fetch("../../api/routes/details_station.php?id=" + idStation)
            .then(function(reponse) { 
                return reponse.json(); 
            })
            .then(function(donnees) {
                if (donnees.message_erreur) {
                    document.getElementById("titre-station").innerText = "Erreur : Station introuvable.";
                    return;
                }

                document.getElementById("titre-station").innerText = "Détails de : " + (donnees.nom_station ? donnees.nom_station : donnees.nom_enseigne);
                document.getElementById("det-id-station").innerText = donnees.id_station;
                document.getElementById("det-nom").innerText = donnees.nom_station ? donnees.nom_station : "Non renseigné";
                document.getElementById("det-enseigne").innerText = donnees.nom_enseigne ? donnees.nom_enseigne : "Non renseignée";
                document.getElementById("det-adresse").innerText = donnees.adresse;
                document.getElementById("det-implantation").innerText = donnees.implantation ? donnees.implantation : "Inconnue (Voir adresse)";
                document.getElementById("det-horaires").innerText = donnees.horaires ? donnees.horaires : "Non spécifiés (Généralement 24h/24)";
                document.getElementById("det-date-service").innerText = donnees.date_mise_en_service ? donnees.date_mise_en_service : "Inconnue";
                document.getElementById("det-gps").innerText = "Longitude : " + donnees.longitude + " / Latitude : " + donnees.latitude;

                document.getElementById("det-id-pdc").innerText = donnees.id_pdc ? donnees.id_pdc : "Aucun point de charge lié";
                document.getElementById("det-puissance").innerText = donnees.puissance_nominale ? donnees.puissance_nominale + " kW" : "Non renseignée";
                document.getElementById("det-raccordement").innerText = donnees.raccordement ? donnees.raccordement : "Standard Enedis";

                var listePrises = [];
                if(donnees.prise_ef == "1" || donnees.prise_ef == "Oui" || donnees.prise_ef == "true") listePrises.push("Domestique (EF)");
                if(donnees.prise_t2 == "1" || donnees.prise_t2 == "Oui" || donnees.prise_t2 == "true") listePrises.push("Type 2 (T2)");
                if(donnees.prise_type_ccs == "1" || donnees.prise_type_ccs == "Oui" || donnees.prise_type_ccs == "true") listePrises.push("Combo CCS");
                if(donnees.chademo == "1" || donnees.chademo == "Oui" || donnees.chademo == "true") listePrises.push("CHAdeMO");
                document.getElementById("det-prises").innerText = listePrises.length > 0 ? listePrises.join(", ") : "Type 2 par défaut";

                
                if (donnees.gratuit == "1" || donnees.gratuit == "Oui" || donnees.gratuit == "true") {
                    document.getElementById("det-gratuit").innerText = "Oui (Recharge gratuite)";
                } else if (donnees.gratuit == "0" || donnees.gratuit == "Non" || donnees.gratuit == "false") {
                    document.getElementById("det-gratuit").innerText = "Non (Recharge payante)";
                } else {
                    document.getElementById("det-gratuit").innerText = "Non spécifié (Vérifier sur borne)";
                }

                if (donnees.paiement == "true" || donnees.paiement == "1" || donnees.paiement == "Oui") {
                    document.getElementById("det-paiement").innerText = "Accepté (Carte Bancaire, Badge Opérateur ou Application Mobile)";
                } else if (donnees.paiement == "false" || donnees.paiement == "0" || donnees.paiement == "Non") {
                    document.getElementById("det-paiement").innerText = "Paiement direct refusé (Badge d'abonnement requis)";
                } else {
                    document.getElementById("det-paiement").innerText = donnees.paiement ? donnees.paiement : "Carte, Badge ou Application";
                }

                document.getElementById("det-tarifs").innerText = donnees.tarification ? donnees.tarification : "Selon grille tarifaire de l'aménageur";

                document.getElementById("det-siren").innerText = donnees.siren ? donnees.siren : "N/C";
                document.getElementById("det-insee").innerText = donnees.code_insee ? donnees.code_insee : "N/C";
                document.getElementById("det-id-local").innerText = donnees.id_local ? donnees.id_local : "N/C";
            })
            .catch(function(erreur) {
                console.error("Erreur détails :", erreur);
                document.getElementById("titre-station").innerText = "Erreur réseau de l'API.";
            });
    }
});