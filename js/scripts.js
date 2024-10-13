// scripts.js
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    form.addEventListener('submit', (e) => {
        const username = form.username.value.trim();
        const password = form.password.value.trim();
        
        if (!username || !password) {
            e.preventDefault();  // Prevent form submission
            alert('Please fill in both fields.');
        }
    });
});
