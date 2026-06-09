window.addEventListener("DOMContentLoaded", function () {
  var formModif = document.getElementById("modification-form");
  var msgRetour = document.getElementById("msg-retour");

  var parametres = new URLSearchParams(window.location.search);
  var idStation = parametres.get("id");
// On vérifie que l'ID de station est présent dans l'URL avant de faire la requête pour pré-remplir les champs
  if (!idStation) {
    if (msgRetour) {
      msgRetour.classList.remove("d-none");
      msgRetour.classList.add("alert-danger");
      msgRetour.textContent = "Aucun identifiant de station n'a été fourni dans l'URL.";
    }
    return;
  }
// Requête pour récupérer les détails de la station et pré-remplir les champs du formulaire
  var urlAPIDetails = "../../api/routes/details.php?id=" + encodeURIComponent(idStation);
// On effectue la requête pour obtenir les détails de la station
  fetch(urlAPIDetails)
    .then(function (reponse) {
      if (!reponse.ok) throw new Error("Impossible de charger les détails de cette station.");
      return reponse.json();
    })
    .then(function (donnees) {
      var station = Array.isArray(donnees) ? donnees[0] : donnees;
// On vérifie que les données de la station ont été correctement récupérées avant de pré-remplir les champs
      if (!station || station.message_erreur) {
        throw new Error(station.message_erreur || "Station introuvable dans la base de données.");
      }
// Pré-remplissage des champs du formulaire avec les données de la station
      formModif.querySelector("input[name='id']").value = station.id_station || idStation;
      formModif.querySelector("input[name='nom']").value = station.nom_station || "";
      formModif.querySelector("input[name='enseigne']").value = station.nom_enseigne || "";
      formModif.querySelector("input[name='horaires']").value = station.horaires || "";
      formModif.querySelector("input[name='tarif']").value = station.tarification || station.tarif || "";
      formModif.querySelector("input[name='longitude']").value = station.longitude || "";
      formModif.querySelector("input[name='latitude']").value = station.latitude || "";
      formModif.querySelector("input[name='adresse']").value = station.adresse || "";
// Pré-remplissage du champ opérateur en vérifiant que la donnée existe
      if (station.nom_operateur) {
        formModif.querySelector("input[name='operateur']").value = station.nom_operateur;
      }
// Pré-remplissage du champ puissance en vérifiant que la donnée existe
      var selectPrise = formModif.querySelector("select[name='prise']");
      if (selectPrise) {
        if (parseInt(station.prise_t2) === 1) selectPrise.value = "Type 2";
        else if (parseInt(station.prise_ef) === 1) selectPrise.value = "EF";
        else if (station.prise_type_ccs == true || parseInt(station.prise_type_ccs) === 1) selectPrise.value = "CCS";
        else if (station.chademo == true || parseInt(station.chademo) === 1) selectPrise.value = "CHAdeMO";
      }
    })
// En cas d'erreur lors du chargement des détails de la station, on affiche un message d'erreur à l'utilisateur
    .catch(function (erreur) {
      console.error(erreur);
      if (msgRetour) {
        msgRetour.classList.remove("d-none");
        msgRetour.classList.add("alert-danger");
        msgRetour.textContent = "Erreur lors du pré-remplissage des champs de la station.";
      }
    });
// Gestion de la soumission du formulaire de modification d'une station
  if (formModif) {
    formModif.addEventListener("submit", function (evenement) {
      evenement.preventDefault();

      var urlAPIUpdate = "../../api/routes/modifier_pdr.php";
      var donneesFormulaire = new FormData(formModif);
// On envoie les données à l'API pour mettre à jour la station
      fetch(urlAPIUpdate, {
        method: "POST",
        body: donneesFormulaire
      })
      // On traite la réponse de l'API après la tentative de mise à jour de la station
        .then(function (reponse) {
          return reponse.json();
        })
        .then(function (resultat) {
          if (msgRetour) {
            msgRetour.classList.remove("d-none", "alert-danger", "alert-success");

            if (resultat.message_erreur) {
              msgRetour.classList.add("alert-danger");
              msgRetour.textContent = resultat.message_erreur;
            } else {
              msgRetour.classList.add("alert-success");
              msgRetour.textContent = resultat.message_succes;
              
              setTimeout(function () {
                window.location.href = "recherche_admin.php";
              }, 2500);
            }
          }
        })
        .catch(function (erreur) {
          console.error("Erreur lors de la modification :", erreur);
          if (msgRetour) {
            msgRetour.classList.remove("d-none", "alert-success");
            msgRetour.classList.add("alert-danger");
            msgRetour.textContent = "Une erreur technique est survenue durant la mise à jour.";
          }
        });
    });
  }
});
