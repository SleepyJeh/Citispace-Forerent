import 'flowbite';
// Initialize Flowbite dropdowns
document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggles = document.querySelectorAll('[data-collapse-toggle]');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const targetId = this.getAttribute('data-collapse-toggle');
            const target = document.getElementById(targetId);
            target.classList.toggle('hidden');
        });
    });
});
