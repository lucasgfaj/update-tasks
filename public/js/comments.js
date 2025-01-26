const modalAddComment = document.getElementById("modalAddComment");
const addCommentBtn = document.getElementById("addCommentBtn");
const closeAddCommentBtn = document.getElementById("closeAddCommentBtn");

// Abrir o modal de adicionar comentário
addCommentBtn.addEventListener("click", () => {
    modalAddComment.classList.remove("hidden");
});

// Fechar o modal de adicionar comentário
closeAddCommentBtn.addEventListener("click", () => {
    modalAddComment.classList.add("hidden");
});

// Fechar o modal clicando fora do conteúdo
window.addEventListener("click", (e) => {
    if (e.target === modalAddComment) {
        modalAddComment.classList.add("hidden");
    }
});

// Modal de Edição de Comentário
function openEditCommentModal(id) {
    document.getElementById("editCommentModal").classList.remove("hidden");
}

function closeEditCommentModal() {
    document.getElementById("editCommentModal").classList.add("hidden");
}

// Modal de Deletar Comentário
function confirmDeleteComment(id) {
    document.getElementById('deleteCommentModal').classList.remove('hidden');
    document.getElementById('deleteCommentForm').action = '/comments/delete/' + id;
}

function closeDeleteCommentModal() {
    document.getElementById('deleteCommentModal').classList.add('hidden');
}

// Modal de Visualização de Comentário
function openViewCommentModal(id) {
    document.getElementById("viewCommentModal").classList.remove("hidden");
}

function closeViewCommentModal() {
    document.getElementById("viewCommentModal").classList.add("hidden");
}

// Modal de Filtros
function openFiltersModal() {
    document.getElementById("filters-modal").classList.remove("hidden");
    document.getElementById("taskFilter").focus();
}

function closeFiltersModal() {
    document.getElementById("filters-modal").classList.add("hidden");
}

// Fechar o modal de filtros clicando fora da área do conteúdo
document.getElementById("filters-modal").addEventListener("click", function(event) {
    if (event.target === document.getElementById("filters-modal")) {
        closeFiltersModal();
    }
});
