import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["link"]

    connect() {
        const options = { threshold: 0.6 }; // 60% de la section doit être visible
        const observer = new IntersectionObserver(this.onIntersection.bind(this), options);
        
        this.linkTargets.forEach(link => {
            const sectionId = link.getAttribute('href').replace('#', '');
            const section = document.getElementById(sectionId);
            if (section) observer.observe(section);
        });
    }

    onIntersection(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                this.linkTargets.forEach(link => {
                    link.classList.toggle('active-link', link.getAttribute('href') === `#${entry.target.id}`);
                });
            }
        });
    }
}