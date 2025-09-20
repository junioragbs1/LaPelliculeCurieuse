document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelector(".slides");
    const slideCount = document.querySelectorAll(".slide").length;
    let index = 0;
    /*
    * J'attends que le document soit chargé
    * Je recupère la div de tous les affiches
    * Dans 'slideCount' je recupre le nombre de tout les images
    * nouvelle variable index initialisé à 0
    *
    */

    document.querySelector(".next").addEventListener("click", () => {
        index = (index + 1) % slideCount;
        slides.style.transform = `translateX(-${index * 100}%)`;
    });

    document.querySelector(".prev").addEventListener("click", () => {
        index = (index - 1 + slideCount) % slideCount;
        slides.style.transform = `translateX(-${index * 100}%)`;
    });
    /*
   * Quand je vais cliquer sur next ou js
   * index prends +1 et j'applique le style transform sur translateX de 100%
   */
});
