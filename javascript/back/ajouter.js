window.addEventListener("DOMContentLoaded", function() {
    var selectStation = document.getElementById("select-station-liaison");
    var form = document.getElementById("creation-form");
    var msg = document.getElementById("msg-retour");

    // Charger les stations disponibles pour la liaison
    if (selectStation) {
        fetch("../../api/routes/stations_simples.php")
            .then(function(res) { return res.json(); })
            .then(function(stations) {
                for(var i=0; i<stations.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = stations[i].id_station;
                    opt.innerText = stations[i].nom_enseigne + " - " + stations[i].adresse;
                    selectStation.appendChild(opt);
                }
            });
    }

    if (form) {
        form.addEventListener("submit", function(e) {
            e.preventDefault();

            var nouveauPdc = {
                id_station: selectStation.value,
                puissance_nominale: document.getElementById("puissance").value,
                tarification: document.getElementById("tarif").value,
                gratuit: document.getElementById("gratuit").value,
                prise_ef: document.getElementById("prise_ef").value,
                prise_t2: document.getElementById("prise_t2").value,
                prise_type_ccs: document.getElementById("prise_ccs").value,
                chademo: document.getElementById("chademo").value,
                paiement: document.getElementById("paiement").value
            };

            fetch("../../api/routes/creer_pdc.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(nouveauPdc)
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                msg.classList.remove("d-none", "alert-danger", "alert-success");
                if(data.message_succes) {
                    msg.classList.add("alert-success");
                    msg.innerText = data.message_succes;
                    form.reset();
                } else {
                    msg.classList.add("alert-danger");
                    msg.innerText = data.message_erreur;
                }
            });
        });
    }
});