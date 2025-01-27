@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/users.css') }}">
<section class="mt-10">
    <div class="container mx-auto">
        <h1 class="text-3xl font-extrabold mb-6 text-center text-transparent bg-clip-text bg-gradient-to-r from-purple-500 via-fuchsia-500 to-pink-500">
            Usuários
        </h1>
        <div>
            <div class="mb-4 flex justify-between">
                <button
                    id="addFiltersBtn"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 mr-2"
                    onclick="openFiltersModal()">
                    Filtros
                </button>
                <button
                    id="addUserBtn"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    Adicionar Usuário
                </button>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto shadow-lg rounded-lg">
        <table id="users" class="display table-auto w-full border-collapse bg-white rounded-lg">
            <!-- Cabeçalho -->
            <thead>
                <tr class="bg-gradient-to-r from-blue-400 to-purple-400 text-white text-sm uppercase tracking-wide">
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Nome</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Papel</th>
                    <th class="px-4 py-3 text-left">Data de Criação</th>
                    <th class="px-4 py-3 text-left">Opções</th>
                </tr>
            </thead>
            <!-- Corpo -->
            <tbody>
                @foreach($users as $index => $user)
                <tr class="bg-gray-50 hover:bg-blue-50 transition" onclick="openViewUserModal({{ $user->id_user ?? ''}})">
                    <td class="px-4 py-3 border-t border-gray-200">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 border-t border-gray-200">{{ $user->name }}</td>
                    <td class="px-4 py-3 border-t border-gray-200">{{ $user->email }}</td>
                    <td class="px-4 py-3 border-t border-gray-200">{{ $user->role }}</td>
                    <td class="px-4 py-3 border-t border-gray-200">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>

                    <td class="px-4 py-3 border-t border-gray-200 flex gap-2">
                        <button
                            class="text-sm bg-blue-500 text-white px-3 py-1 rounded shadow hover:bg-blue-600"
                            onclick="openEditUserModal({{ $user->id_user ?? '' }}); event.stopPropagation()">
                            Editar
                        </button>
                        <button
                            class="text-sm bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600"
                            onclick="confirmDeleteUser({{ $user->id_user ?? '' }}); event.stopPropagation()">
                            Excluir
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6 flex flex-col items-center">
        <span class="text-sm text-gray-700 dark:text-gray-400">
            Mostrando <span class="font-semibold text-gray-900 dark:text-white">{{ $users->firstItem() }}</span> para
            <span class="font-semibold text-gray-900 dark:text-white">{{ $users->lastItem() }}</span> de
            <span class="font-semibold text-gray-900 dark:text-white">{{ $users->total() }}</span> Entradas
        </span>

        <nav class="mt-4" aria-label="Page navigation example">
            <ul class="flex items-center -space-x-px h-8 text-sm">
                @if ($users->onFirstPage())
                <li class="disabled">
                    <a href="#" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-300 bg-white border border-e-0 border-gray-300 rounded-s-lg cursor-not-allowed">
                        <span class="sr-only">Previous</span>
                        <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                        </svg>
                    </a>
                </li>
                @else
                <li>
                    <a href="{{ $users->previousPageUrl() }}" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="sr-only">Previous</span>
                        <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                        </svg>
                    </a>
                </li>
                @endif

                @for ($i = 1; $i <= $users->lastPage(); $i++)
                    <li>
                        <a href="{{ $users->url($i) }}" class="flex items-center justify-center px-3 h-8 leading-tight {{ $i == $users->currentPage() ? 'text-white bg-blue-500 border-blue-500' : 'text-gray-500 bg-white border-gray-300' }} hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            {{ $i }}
                        </a>
                    </li>
                    @endfor

                    @if ($users->hasMorePages())
                    <li>
                        <a href="{{ $users->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Next</span>
                            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                    </li>
                    @else
                    <li class="disabled">
                        <a href="#" class="flex items-center justify-center px-3 h-8 rounded-e-lg text-gray-300 bg-white border-gray-300 cursor-not-allowed">
                            <span class="sr-only">Next</span>
                            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                    </li>
                    @endif
            </ul>
        </nav>
    </div>
</section>

<div
    id="modalAddUser"
    class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div
        class="bg-white rounded-lg shadow-lg p-6 w-full max-w-6xl h-auto relative max-h-[80vh] overflow-y-auto">
        <!-- Título do Modal -->
        <h2 class="text-xl font-bold text-gray-800">Adicionar Novo Usuário</h2>

        <!-- Formulário -->
        <form id="addUserForm" action="{{ route('users.store') }}" method="POST" class="mt-4">
            @csrf
            <!-- Nome do Usuário -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nome do Usuário</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
            </div>

            <!-- Senha -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
            </div>

            <!-- Confirmação de Senha -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmação de Senha</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
            </div>

            <!-- Papel -->
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Papel</label>
                <select name="role" id="role"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    {{ auth()->user()->role !== 'Admin' ? 'disabled' : '' }}>
                    <option value="Developer">Developer</option>
                    <option value="Frontend">Frontend Developer</option>
                    <option value="Backend">Backend Developer</option>
                    <option value="Fullstack">Fullstack Developer</option>
                    <option value="Mobile">Mobile Developer</option>
                    <option value="DevOps">DevOps</option>
                    <option value="Designer">Designer</option>
                    <option value="QA">QA Engineer</option>
                    <option value="Admin">Administrador</option>
                </select>
                @if(auth()->user()->role !== 'Admin')
                <small class="text-gray-500">Somente um administrador pode alterar este campo.</small>
                @endif
            </div>

            <!-- Experiência -->
            <div class="mb-4">
                <label for="experience" class="block text-sm font-medium text-gray-700">Experiência</label>
                <select name="experience" id="experience"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="Junior">Júnior</option>
                    <option value="Pleno">Pleno</option>
                    <option value="Senior">Sênior</option>
                </select>
            </div>

            <!-- Botões -->
            <div cla ss="flex justify-end mt-6 gap-3">
                <button
                    id="closeAddUserBtn"
                    type="button"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Fechar
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Usuário -->
<div id="modalEditUser" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-6xl h-auto relative max-h-[80vh] overflow-y-auto">
        <!-- Título do Modal -->
        <h2 class="text-xl font-bold text-gray-800">Editar Usuário</h2>

        <!-- Formulário -->
        <form id="editUserForm" action="{{ route('users.update', $user->id_user ?? '') }}" method="POST" class="mt-4">
            @csrf
            @method('PUT')
            <!-- Nome do Usuário -->
            <div class="mb-4">
                <label for="edit_name" class="block text-sm font-medium text-gray-700">Nome do Usuário</label>
                <input
                    type="text"
                    id="edit_name"
                    name="name"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ $user->name ?? '' }}"
                    required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="edit_email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    type="email"
                    id="edit_email"
                    name="email"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ $user->email ?? '' }}"
                    required>
            </div>

            <!-- Senha -->
            <div class="mb-4">
                <label for="edit_password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input
                    type="password"
                    id="edit_password"
                    name="password"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Confirmação de Senha -->
            <div class="mb-4">
                <label for="edit_password_confirmation" class="block text-sm font-medium text-gray-700">Confirmação de Senha</label>
                <input
                    type="password"
                    id="edit_password_confirmation"
                    name="password_confirmation"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Papel -->
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Papel</label>
                <select name="role" id="role"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="Developer" {{ isset($user->role) && $user->role == 'Developer' ? 'selected' : '' }}>Developer</option>
                    <option value="Frontend" {{ isset($user->role) && $user->role == 'Frontend' ? 'selected' : '' }}>Frontend Developer</option>
                    <option value="Backend" {{ isset($user->role) && $user->role == 'Backend' ? 'selected' : '' }}>Backend Developer</option>
                    <option value="Fullstack" {{ isset($user->role) && $user->role == 'Fullstack' ? 'selected' : '' }}>Fullstack Developer</option>
                    <option value="Mobile" {{ isset($user->role) && $user->role == 'Mobile' ? 'selected' : '' }}>Mobile Developer</option>
                    <option value="DevOps" {{ isset($user->role) && $user->role == 'DevOps' ? 'selected' : '' }}>DevOps</option>
                    <option value="Designer" {{ isset($user->role) && $user->role == 'Designer' ? 'selected' : '' }}>Designer</option>
                    <option value="QA" {{ isset($user->role) && $user->role == 'QA' ? 'selected' : '' }}>QA Engineer</option>
                    <option value="Admin" {{ isset($user->role) && $user->role == 'Admin' ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>

            <!-- Experiência -->
            <div class="mb-4">
                <label for="experience" class="block text-sm font-medium text-gray-700">Experiência</label>
                <select name="experience" id="experience"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="Junior" {{ isset($user->experience) && $user->experience == 'Junior' ? 'selected' : '' }}>Júnior</option>
                    <option value="Pleno" {{ isset($user->experience) && $user->experience == 'Pleno' ? 'selected' : '' }}>Pleno</option>
                    <option value="Senior" {{ isset($user->experience) && $user->experience == 'Senior' ? 'selected' : '' }}>Sênior</option>
                </select>
            </div>


            <!-- Botões -->
            <div class="flex justify-end mt-6 gap-3">
                <button
                    id="closeEditUserBtn"
                    type="button"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Fechar
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Excluir Usuário -->
<div id="deleteUserModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xl h-auto relative max-h-[80vh] overflow-y-auto">
        <h2 class="text-xl font-bold text-gray-800">Tem certeza de que deseja excluir este usuário?</h2>
        <form id="deleteUserForm" action="" method="POST" class="mt-4">
            @csrf
            @method('DELETE')
            <div class="flex justify-end mt-6 gap-3">
                <button
                    id="closeDeleteUserBtn"
                    type="button"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Fechar
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    Excluir
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Visualizar Usuário -->
<div id="viewUserModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-5xl h-auto relative max-h-[80vh] overflow-y-auto">
        <h2 class="text-xl font-bold text-gray-800">Visualizar Usuário</h2>
        <div class="mt-4 space-y-4">
            <div>
                <label for="view_name" class="block text-sm font-medium text-gray-700">Nome do Usuário</label>
                <input
                    type="text"
                    id="view_name"
                    class="w-full px-3 py-2 border rounded-lg text-gray-700 bg-gray-100"
                    value="{{ $user->name ?? '' }}"
                    readonly>
            </div>
            <div>
                <label for="view_email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    type="email"
                    id="view_email"
                    class="w-full px-3 py-2 border rounded-lg text-gray-700 bg-gray-100"
                    value="{{ $user->email ?? '' }}"
                    readonly>
            </div>
            <div>
                <label for="view_created_at" class="block text-sm font-medium text-gray-700">Data de Criação</label>
                <input
                    type="text"
                    id="view_created_at"
                    class="w-full px-3 py-2 border rounded-lg text-gray-700 bg-gray-100"
                    value="{{ isset($user) && $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') : '' }}"

                    readonly>
            </div>
            <div>
                <label for="view_role" class="block text-sm font-medium text-gray-700">Papel</label>
                <input
                    type="text"
                    id="view_role"
                    class="w-full px-3 py-2 border rounded-lg text-gray-700 bg-gray-100"
                    value="{{ $user->role ?? '' }}"
                    readonly>
            </div>
            <div>
                <label for="view_experience" class="block text-sm font-medium text-gray-700">Experiência</label>
                <input
                    type="text"
                    id="view_experience"
                    class="w-full px-3 py-2 border rounded-lg text-gray-700 bg-gray-100"
                    value="{{ $user->experience ?? '' }}"
                    readonly>
            </div>
            <div class="flex justify-end mt-6">
                <button
                    type="button"
                    onclick="closeViewUserModal()"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de filtros -->
<div id="filters-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-end sm:items-center hidden transition-transform duration-300 ease-in-out">
    <div class="bg-white p-6 rounded-t-lg sm:rounded-lg w-full sm:w-96 md:w-[28rem] lg:w-[32rem] xl:w-[40rem] max-h-[80vh] overflow-y-auto shadow-lg">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Filtros</h2>

        <form action="{{ route('users.index') }}" method="GET" class="space-y-4">
            <!-- Filtro por Nome do Usuário -->
            <div>
                <label for="userFilter" class="block text-sm font-medium text-gray-700 mb-1">Nome do Usuário</label>
                <input type="text" id="userFilter" name="name"
                    class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                    value="{{ $filters['name'] ?? '' }}" placeholder="Digite o nome do usuário">
            </div>

            <!-- Filtro por Email -->
            <div>
                <label for="filter-email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="filter-email" name="email"
                    class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                    value="{{ $filters['email'] ?? '' }}" placeholder="Digite o email do usuário">
            </div>

            <!-- Filtro por Data de Criação -->
            <div>
                <label for="created_at" class="block text-sm font-medium text-gray-700 mb-1">Data de Criação</label>
                <input type="date" id="created_at" name="created_at" value="{{ $filters['created_at'] ?? '' }}" class="w-full px-3 py-2 border rounded-lg mb-4">
            </div>

            <!-- Botões de filtro -->
            <div class="flex justify-between items-center pt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg font-medium transition">Aplicar</button>
                <button type="button" onclick="closeFiltersModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg font-medium transition">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/users.js') }}"></script>


@endsection
