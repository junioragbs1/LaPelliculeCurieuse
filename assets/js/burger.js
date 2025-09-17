const X = document.querySelector(".menu-burger");
// je selectionne le bouton qui dois ouvrir le burger
const nav = document.querySelector(".nav-list");
// je selectionne la nav qui dois s'ouvrir

X.addEventListener("click", () => {
    nav.classList.toggle("active");
});
/*
    J'ajoute un event listener au bouton burger , lorsqu'il est cliqué,
    ajoute  la classe "active" de la nav, ce qui permet de l'afficher.
*/

document.addEventListener("click", (e) => {
    if (!X.contains(e.target) && !nav.contains(e.target)) {
        nav.classList.remove("active");
    }
});

