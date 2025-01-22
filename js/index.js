import { updateMenuDisplay, handleHamburgerMenu } from './menu.js';
import { handleModalEvents } from './modal.js';
import { handleFormSubmit } from './upload.js';

"use strict";

// Initialisation des fonctionnalités
updateMenuDisplay();
handleHamburgerMenu();
handleModalEvents();
handleFormSubmit();

// Ecoute des changements de la taille de l'écran
window.addEventListener("resize", updateMenuDisplay);

// Init
updateMenuDisplay();