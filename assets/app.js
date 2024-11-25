// import { registerReactControllerComponents } from '@symfony/ux-react';
// import { Application } from '@hotwired/stimulus';
import './bootstrap.js';
import './styles/app.css';

registerReactControllerComponents(require.context('./react/controllers', true, /\.(j|t)sx?$/));

/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
// assets/app.js

// Créez une instance de l'application Stimulus
const application = Application.start();
// import'./styles/app.css';
// assets/app.js

// import '@symfony/ux-toggle-password';


// afficher/cacher password
console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
// console.log("Fichier JS chargé avec succès !");
// document.getElementById("togglePassword").addEventListener("click", function() {
//     const passwordField = document.getElementById("passwordField");
//     const passwordFieldType = passwordField.getAttribute("type") === "password" ? "text" : "password";
//     passwordField.setAttribute("type", passwordFieldType);

    // Changer l'icône
//     this.classList.toggle("bi bi-eye");
//     this.classList.toggle("bi bi-eye-slash");
// });
import './bootstrap.js';

// document.getElementById("toggleConfirmPassword").addEventListener("click", function() {
//     const confirmPasswordField = document.getElementById("confirmPasswordField");
//     const confirmPasswordFieldType = confirmPasswordField.getAttribute("type") === "password" ? "text" : "password";
//     confirmPasswordField.setAttribute("type", confirmPasswordFieldType);

    // Changer l'icône
//     this.classList.toggle("bi bi-eye");
//     this.classList.toggle("bi bi-eye-slash");
// });
import './styles/app.css';

console.log('Ce log provient de assets/app.js - bienvenue sur AssetMapper! 🎉');

// registerReactControllerComponents(require.context('./react/controllers', true, /\.(j|t)sx?$/), application);

// registerReactControllerComponents();
// registerReactControllerComponents(application);