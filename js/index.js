"use strict";

const hamburgerMenu = document.querySelector(".hamburger-menu");
const userActionMenu = document.querySelector(".user-actions");
const desktopMenu = document.querySelector(".desktop-menu");
const mobileMenu = document.querySelector(".mobile-menu");

const isNone = "is-none";
const isOpen = "is-open";
const closeIcon = '<i class="fa-solid fa-xmark"></i>';
const hamburgerIcon = '<i class="fa-solid fa-bars"></i>';

// Fonctions

function updateMenuDisplay() {
    // Affichage desktop
    if (window.innerWidth > 769) {
        // Menus masqués
        hamburgerMenu.classList.add(isNone);
        mobileMenu.classList.add(isNone);
        hamburgerMenu.innerHTML = hamburgerIcon;
        hamburgerMenu.classList.remove(isOpen);
        // Menus affichés
        userActionMenu.classList.remove(isNone);
        desktopMenu.classList.remove(isNone);
    }
    // Affichage Mobile 
    else {
        // Menus masqués
        userActionMenu.classList.add(isNone);
        desktopMenu.classList.add(isNone);
        mobileMenu.classList.add(isNone);
        // Menus affichés
        hamburgerMenu.classList.remove(isNone);
    }
}

// Events

hamburgerMenu.addEventListener("click", () => {
    if (hamburgerMenu.classList.contains(isOpen)) {
        hamburgerMenu.innerHTML = hamburgerIcon;
        hamburgerMenu.classList.remove(isOpen);
    } else {
        hamburgerMenu.innerHTML = closeIcon;
        hamburgerMenu.classList.add(isOpen);
    }

    userActionMenu.classList.toggle(isNone);
    mobileMenu.classList.toggle(isNone);

})

// Ecoute des changements de la taille de l'écran
window.addEventListener("resize", updateMenuDisplay);

// Init
updateMenuDisplay();
