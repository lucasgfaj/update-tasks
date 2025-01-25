const modalAddTeam = document.getElementById("modalAddTeam");
const addTaskBtn = document.getElementById("addTaskBtn");
const closeAddTeamBtn = document.getElementById("closeAddTeamBtn");

// Abrir o modal
addTaskBtn.addEventListener("click", () => {
    modalAddTeam.classList.remove("hidden"); // Mostra o modal
});

// Fechar o modal
closeAddTeamBtn.addEventListener("click", () => {
    modalAddTeam.classList.add("hidden"); // Esconde o modal
});

// Fechar o modal clicando fora do conteúdo
window.addEventListener("click", (e) => {
    if (e.target === modalAddTeam) {
        modalAddTeam.classList.add("hidden");
    }
});

// Datas do Modal

// Função para formatar data no formato yyyy-mm-dd
function formatDate(date) {
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, "0");
    const day = date.getDate().toString().padStart(2, "0");
    return `${year}-${month}-${day}`;
}

// Configuração da data de início (hoje)
const today = new Date();
const startDate = formatDate(today);

// Configuração da data de fim (1 ano à frente)
const endDate = formatDate(
    new Date(today.setFullYear(today.getFullYear() + 1))
);

// Preenche os campos com as datas calculadas
document.getElementById("start_date").value = startDate;
document.getElementById("end_date").value = endDate;

// Modal de Edição
function openEditModal(id) {
    // Aqui você pode pegar os dados do time e preencher os campos do modal com AJAX ou outros métodos, caso necessário
    document.getElementById("edit-modal").classList.remove("hidden");
}

function closeEditModal() {
    document.getElementById("edit-modal").classList.add("hidden");
}

// Modal de Deletar

function confirmDelete(id) {
    // Exibe o modal
    document.getElementById('delete-modal').classList.remove('hidden');

    // Define a URL da rota de exclusão no formulário
    document.getElementById('delete-form').action = '/teams/' + id; // Substitua pelo caminho correto para sua rota
}

function closeDeleteModal() {
    // Fecha o modal
    document.getElementById('delete-modal').classList.add('hidden');
}
