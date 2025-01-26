const modalAddTask = document.getElementById("modalAddTask");
const addTaskBtn = document.getElementById("addTaskBtn");
const closeAddTaskBtn = document.getElementById("closeAddTaskBtn");

// Abrir o modal
addTaskBtn.addEventListener("click", () => {
    modalAddTask.classList.remove("hidden"); // Mostra o modal
});

// Fechar o modal
closeAddTaskBtn.addEventListener("click", () => {
    modalAddTask.classList.add("hidden"); // Esconde o modal
});

// Fechar o modal clicando fora do conteúdo
window.addEventListener("click", (e) => {
    if (e.target === modalAddTask) {
        modalAddTask.classList.add("hidden");
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
function openEditTaskModal(id) {
    // Aqui você pode pegar os dados da tarefa e preencher os campos do modal com AJAX ou outros métodos, caso necessário
    document.getElementById("editTaskModal").classList.remove("hidden");
}

function closeEditTaskModal() {
    document.getElementById("editTaskModal").classList.add("hidden");
}

// Modal de Deletar

function confirmDeleteTask(id) {
    // Exibe o modal
    document.getElementById('delete-modal').classList.remove('hidden');

    // Define a URL da rota de exclusão no formulário
    document.getElementById('delete-form').action = '/tasks/delete/' + id; // Substitua pelo caminho correto para sua rota
}

function closeDeleteModal() {
    // Fecha o modal
    document.getElementById('delete-modal').classList.add('hidden');
}

// Modal de Visualização
function openViewTaskModal(id) {
  // Exibe o modal
    document.getElementById("view-modal").classList.remove("hidden");
}

function closeViewModal() {
    // Fecha o modal
    document.getElementById("view-modal").classList.add("hidden");
}

// Modal de Filtros
function openFiltersModal() {
    // Exibe o modal
    document.getElementById("filters-modal").classList.remove("hidden");
    // Opcional: Focar no primeiro campo de filtro ao abrir
    document.getElementById("taskFilter").focus();
}

function closeFiltersModal() {
    // Fecha o modal
    document.getElementById("filters-modal").classList.add("hidden");
}

// Fechar o modal ao clicar fora da área do conteúdo (facultativo)
document.getElementById("filters-modal").addEventListener("click", function(event) {
    if (event.target === document.getElementById("filters-modal")) {
        closeFiltersModal();
    }
});
