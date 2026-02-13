/*
import './stimulus_bootstrap.js';

 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 * import './styles/app.css';
 */

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault(); // On stoppe le saut brusque

        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);

        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: 'smooth', // Le scroll fluide "gastronomique"
                block: 'start'
            });

            // Si tu as un menu mobile, on peut le fermer ici
        }
    });
});


console.log('at-devs JS');

/*
    *Vanilla JS
 */
document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('.menu-item-container');

    items.forEach(item => {
        item.addEventListener('click', () => {
            const description = item.querySelector('.description-content');
            const icon = item.querySelector('.toggle-icon');
            const isExpanded = item.getAttribute('data-expanded') === 'true';

            // Fermer les autres (optionnel, pour un effet pur accordéon)
            // items.forEach(other => { if(other !== item) ... });

            if (!isExpanded) {
                // Ouvrir : on utilise scrollHeight pour connaître la hauteur réelle du texte
                description.style.maxHeight = description.scrollHeight + "px";
                icon.style.transform = "rotate(45deg)"; // Le + devient un x
                item.setAttribute('data-expanded', 'true');
            } else {
                // Fermer
                description.style.maxHeight = "0";
                icon.style.transform = "rotate(0deg)";
                item.setAttribute('data-expanded', 'false');
            }
        });
    });
});
