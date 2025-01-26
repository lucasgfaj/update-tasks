const modalAddUser = document.getElementById("modalAddUser");
const addUserBtn = document.getElementById("addUserBtn");
const closeAddUserBtn = document.getElementById("closeAddUserBtn");

addUserBtn.addEventListener("click", () => {
    modalAddUser.classList.remove("hidden");
});

closeAddUserBtn.addEventListener("click", () => {
    modalAddUser.classList.add("hidden");
});

const modalEditUser = document.getElementById("modalEditUser");
const closeEditUserBtn = document.getElementById("closeEditUserBtn");

function openEditUserModal(id) {
    // Fetch user data and populate the form if necessary
    modalEditUser.classList.remove("hidden");
}

closeEditUserBtn.addEventListener("click", () => {
    modalEditUser.classList.add("hidden");
});

const deleteUserModal = document.getElementById("deleteUserModal");
const closeDeleteUserBtn = document.getElementById("closeDeleteUserBtn");

function confirmDeleteUser(id) {
    deleteUserModal.classList.remove("hidden");
    document.getElementById('deleteUserForm').action = '/users/delete/' + id;
}

closeDeleteUserBtn.addEventListener("click", () => {
    deleteUserModal.classList.add("hidden");
});

const viewUserModal = document.getElementById("viewUserModal");

function openViewUserModal(id) {
    // Fetch user data and populate the modal if necessary
    viewUserModal.classList.remove("hidden");
}

function closeViewUserModal() {
    viewUserModal.classList.add("hidden");
}

const filtersModal = document.getElementById("filters-modal");

function openFiltersModal() {
    filtersModal.classList.remove("hidden");
    document.getElementById("userFilter").focus();
}

function closeFiltersModal() {
    filtersModal.classList.add("hidden");
}

filtersModal.addEventListener("click", function(event) {
    if (event.target === filtersModal) {
        closeFiltersModal();
    }
});
