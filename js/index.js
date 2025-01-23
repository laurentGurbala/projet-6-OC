import { updateMenuDisplay, handleHamburgerMenu } from './menu.js';
import { handleModalEvents } from './modal.js';
import { handleFormSubmit } from './upload.js';
import { handleUploadBook} from './uploadBook.js';

"use strict";

// Initialisation des fonctionnalités
updateMenuDisplay();
handleHamburgerMenu();
handleModalEvents();
handleFormSubmit();
handleUploadBook();

// Ecoute des changements de la taille de l'écran
window.addEventListener("resize", updateMenuDisplay);

// Init
updateMenuDisplay();