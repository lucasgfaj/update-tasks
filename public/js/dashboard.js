const userMenuButton = document.getElementById('user-menu-button');
const userMenu = document.getElementById('user-menu');

userMenuButton.addEventListener('click', function() {
    userMenu.classList.toggle('hidden'); // Alterna a visibilidade
});

