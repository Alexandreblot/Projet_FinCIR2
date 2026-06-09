const toggle = document.getElementById("menu-toggle");
const menu = document.getElementById("menu");
// On ajoute un événement de clic sur le bouton de menu pour basculer l'affichage du menu
toggle.addEventListener("click", () => {
  menu.classList.toggle("open");
});
