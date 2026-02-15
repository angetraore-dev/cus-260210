/*
import './stimulus_bootstrap.js';

 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 * import './styles/app.css';
 */

document.addEventListener('DOMContentLoaded', () => {
    console.log('at-devs WhatsApp +225 07 00 42 27 55');

    /* Nav-link Toggle*/
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

    /* Reservation form Process */
    const modal = document.getElementById('reservation-modal');
    const modalContent = document.getElementById('modal-content');

    // 1. Écouter le clic sur TOUS les boutons de réservation
    document.querySelectorAll('a[href="#reservovat-stul"]').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
           await openModal();
        });
    });

    // 2. Fermeture (en cliquant sur le fond)
    //modal.addEventListener('click', (e) => {
    //         if (e.target === modal) closeModal();
    //     });


    async function openModal() {
        // Afficher le fond
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        // Petit délai pour l'animation d'entrée
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);

        // Charger le formulaire via AJAX
        try {
            const response = await fetch('/reservation/ajax-form');
            modalContent.innerHTML = await response.text();

        } catch (error) {
            modalContent.innerHTML = "<p class='text-light-rose'>Chyba při načítání formuláře.</p>";
        }
    }
    window.closeModal = function() { // Rendu global pour le bouton '✕'
        modalContent.classList.add('scale-95', 'opacity-0');
        document.body.style.overflow = '';
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    };

    // 3. Gestion de la soumission AJAX
    document.addEventListener('submit', async (e) => {
        if (e.target && e.target.id === 'ajax-reservation-form') {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);

            const response = await fetch(form.action, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            if (result.success) {
                modalContent.innerHTML = `
                    <div class="p-12 text-center bg-rich-green border border-logo-rose/30">
                        <h2 class="font-seasons text-3xl text-logo-rose mb-4 uppercase">Děkujeme!</h2>
                        <p class="text-light-rose italic">${result.message}</p>
                        <button onclick="closeModal()" class="mt-8 btn-nav-contact">Zavřít</button>
                    </div>`;
            }else {
                // GESTION DES ERREURS
                // On peut soit faire une alerte propre, soit injecter les erreurs dans le DOM
                alert("Chyba: " + result.errors.join("\n"));

                // Astuce : tu peux aussi secouer la modale pour montrer que ça a échoué
                modalContent.classList.add('animate-shake');
                setTimeout(() => modalContent.classList.remove('animate-shake'), 500);
            }
        }
    });



    //pour recenze
    const swiper = new Swiper('.reviewSwiper', {
        loop: true,
        speed: 800,
        autoplay: {
            delay: 5000,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });


});

/*
 * const items = document.querySelectorAll('.menu-item-container');

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
 */
