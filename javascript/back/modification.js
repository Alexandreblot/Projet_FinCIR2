window.addEventListener("DOMContentLoaded", function () {
  var formulaire = document.getElementById("form-modification");

  if (formulaire) {
    formulaire.addEventListener("submit", function (evenement) {
      evenement.preventDefault(); // Empêche le rechargement de la page

      // Récupération des données du formulaire
      var idStation = document.getElementById("input-id").value;
      var nomEnseigne = document.getElementById("input-enseigne").value;
      var adresseStation = document.getElementById("input-adresse").value;

      // Détermination automatique du chemin de l'API
      var nomProjet = window.location.pathname.split("/")[1];
      var urlAPI = "/" + nomProjet + "/api/routes/modifier_station.php";

      var donneesFormulaire = {
        id_station: idStation,
        nom_enseigne: nomEnseigne,
        adresse: adresseStation,
      };

      // Envoi des données à l'API via FETCH en méthode POST
      fetch(urlAPI, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(donneesFormulaire),
      })
        .then(function (reponse) {
          return reponse.json();
        })
        .then(function (resultat) {
          if (resultat.success === true || resultat.statut === "ok") {
            alert("Modification enregistrée avec succès !");
            // Redirection vers l'espace recherche après validation
            window.location.href = "recherche_admin.php";
          } else {
            alert(
              "Erreur lors de la modification : " +
                (resultat.message || "Erreur inconnue"),
            );
          }
        })
        .catch(function (erreur) {
          console.error("Erreur d'envoi :", erreur);
          alert(
            "Impossible de joindre le serveur pour enregistrer les modifications.",
          );
        });
    });
  }
});
