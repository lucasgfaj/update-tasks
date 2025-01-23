// Função para alternar a visibilidade de um menu
function toggleMenu(menu) {
    menu.classList.toggle('hidden');
}

// Função para configurar o evento de clique para abrir/fechar o menu de usuário
function setupUserMenu(userMenuButton, userMenu) {
    userMenuButton.addEventListener('click', function() {
        event.stopPropagation();
        toggleMenu(userMenu); // Alterna visibilidade do menu de usuário
    });

    document.addEventListener('click', function(event) {
        // Verifica se o clique aconteceu fora do menu
        if (!userMenu.contains(event.target) && !userMenuButton.contains(event.target)) {
            userMenu.classList.add('hidden'); // Fecha o menu se clicar fora
        }
    });
}

// Função para configurar o evento de clique para abrir/fechar o menu móvel
function setupMobileMenu(mobileButton, mobileMenu) {
    mobileButton.addEventListener('click', function() {
        toggleMenu(mobileMenu); // Alterna visibilidade do menu móvel
    });
}

// Obtendo os elementos
const userMenuButton = document.getElementById('user-menu-button');
const userMenu = document.getElementById('user-menu');
const mobileButton = document.getElementById('mobile-button');
const mobileMenu = document.getElementById('mobile-menu');

// Configurando os menus
setupUserMenu(userMenuButton, userMenu);
setupMobileMenu(mobileButton, mobileMenu);

