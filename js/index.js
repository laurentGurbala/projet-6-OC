"use strict";

// éléments pour le menu hamburger du header
const hamburgerMenu = document.querySelector(".hamburger-menu");
const userActionMenu = document.querySelector(".user-actions");
const desktopMenu = document.querySelector(".desktop-menu");
const mobileMenu = document.querySelector(".mobile-menu");

const isNone = "is-none";
const isOpen = "is-open";
const closeIcon = '<i class="fa-solid fa-xmark"></i>';
const hamburgerIcon = '<i class="fa-solid fa-bars"></i>';

// éléments pour la fenêtre modale du changement d'image
// dans le profil de l'utilisateur
const openModalBtn = document.getElementById("openModalBtn");
const closeModalBtn = document.getElementById("closeModalBtn");
const modal = document.getElementById("uploadModal");

const uploadProfileForm = document.getElementById("uploadProfileForm");
const errorMessageUpload = document.getElementById("errorMessage");

// Fonctions

// Fonction pour metter à jour l'affichage du header
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

// Fonction pour ouvrir la modale
function openModal() {
    modal.style.display = "block";    
}

// Fonction pour fermer la modale
function closeModal() {
    modal.style.display = "none";
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

openModalBtn.addEventListener("click", openModal);
closeModalBtn.addEventListener("click", closeModal);

uploadProfileForm.addEventListener("submit", function (event) {
    // Empêche la soumission du formulaire
    event.preventDefault();

    // Récupère les données du formulaire
    const formData = new FormData(this);

    // Envoie les données en AJAX
    fetch("index.php?action=uploadProfileImage", {
        method: "POST",
        body: formData,
    })
    .then(response => {
        return response.json()
    })
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            errorMessageUpload.textContent = data.error || "Une erreur est survenue.";
        }
    })
    .catch(error => {
        console.error("Erreur: ", error);
    })
})

// Ecoute des changements de la taille de l'écran
window.addEventListener("resize", updateMenuDisplay);

// Init
updateMenuDisplay();
