@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/teams.css') }}">
<section class="mt-10">
    <div class="container mx-auto">
        <h1 class="text-3xl font-extrabold mb-6 text-center text-transparent bg-clip-text bg-gradient-to-r from-purple-500 via-fuchsia-500 to-pink-500">
            Time de Projetos
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
                        id="addTeamBtn"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                        Adicionar Time
                    </button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table id="team" class="display table-auto w-full border-collapse bg-white rounded-lg">
                <!-- Cabeçalho -->
                <thead>
                    <tr class="bg-gradient-to-r from-blue-400 to-purple-400 text-white text-sm uppercase tracking-wide">
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Time</th>
                        <!-- <th class="px-4 py-3 text-left">Descrição</th> -->
                        <th class="px-4 py-3 text-left">Responsável</th>
                        <th class="px-4 py-3 text-left">Tipo</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Data Inicial</th>
                        <th class="px-4 py-3 text-left">Data Final</th>
                        <!-- <th class="px-4 py-3 text-left">Data de Criação</th> -->
                        <th class="px-4 py-3 text-left">Opções</th>
                    </tr>
                </thead>
                <!-- Corpo -->
                <tbody>
                    @foreach($teams as $index => $team)
                    <tr class="bg-gray-50 hover:bg-blue-50 transition" onclick="openViewModal({{ $team->id_teams ?? ''}})">
                        <!-- Exibindo um valor mascarado, aqui usando o índice + 1 -->
                        <td class="px-4 py-3 border-t border-gray-200">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 border-t border-gray-200">{{ $team->name }}</td>
                        <td class="px-4 py-3 border-t border-gray-200">
                            @foreach ($users as $user)
                            {{ $user->name }}{{ !$loop->last ? ',' : '' }}
                            @endforeach
                        </td>
                        <td class="px-4 py-3 border-t border-gray-200">
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">{{ $team->type }}</span>
                        </td>
                        <td class="px-4 py-3 border-t border-gray-200">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">{{ $team->status }}</span>
                        </td>
                        <td class="px-4 py-3 border-t border-gray-200">{{ \Carbon\Carbon::parse($team->start_date)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 border-t border-gray-200">{{ \Carbon\Carbon::parse($team->end_date)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 border-t border-gray-200 flex gap-2">
                            <button
                                class="text-sm bg-blue-500 text-white px-3 py-1 rounded shadow hover:bg-blue-600"
                                onclick="openEditModal({{ $team->id_teams ?? '' }}); event.stopPropagation()">
                                Editar
                            </button>
                            <button
                                class="text-sm bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600"
                                onclick="confirmDelete({{ $team->id_teams ?? '' }}); event.stopPropagation()">
                                Excluir
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex flex-col items-center">
            <!-- Help text -->
            <span class="text-sm text-gray-700 dark:text-gray-400">
                Mostrando <span class="font-semibold text-gray-900 dark:text-white">{{ $teams->firstItem() }}</span> para
                <span class="font-semibold text-gray-900 dark:text-white">{{ $teams->lastItem() }}</span> de
                <span class="font-semibold text-gray-900 dark:text-white">{{ $teams->total() }}</span> Entradas
            </span>

            <nav class="mt-4" aria-label="Page navigation example">
                <ul class="flex items-center -space-x-px h-8 text-sm">
                    <!-- Página anterior -->
                    @if ($teams->onFirstPage())
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
                        <a href="{{ $teams->previousPageUrl() }}" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Previous</span>
                            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                            </svg>
                        </a>
                    </li>
                    @endif

                    <!-- Páginas numeradas -->
                    @for ($i = 1; $i <= $teams->lastPage(); $i++)
                        <li>
                            <a href="{{ $teams->url($i) }}" class="flex items-center justify-center px-3 h-8 leading-tight {{ $i == $teams->currentPage() ? 'text-white bg-blue-500 border-blue-500' : 'text-gray-500 bg-white border-gray-300' }} hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                {{ $i }}
                            </a>
                        </li>
                        @endfor

                        <!-- Próxima página -->
                        @if ($teams->hasMorePages())
                        <li>
                            <a href="{{ $teams->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
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
    id="modalAddTeam"
    class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div
        class="bg-white rounded-lg shadow-lg p-6 w-full max-w-6xl h-auto relative max-h-[80vh] overflow-y-auto">
        <!-- Título do Modal -->
        <h2 class="text-xl font-bold text-gray-800">Adicionar Novo Time</h2>

        <!-- Formulário -->
        <form id="addTeamForm" action="{{ route('teams.store') }}" method="POST" class="mt-4">
            @csrf
            <!-- Nome do Time -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nome do Time</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
            </div>

            <!-- Responsável -->
            <div class="mb-4">
                <label for="responsible_id" class="block text-sm font-medium text-gray-700">Responsável</label>
                <select
                    id="responsible_id"
                    name="responsible_id"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="" disabled selected>Escolha um responsável</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id_user }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Tipo de Time -->
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Time</label>
                <select
                    id="type"
                    name="type"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="" disabled selected>Escolha o tipo de time</option>
                    <option value="Desenvolvimento">Desenvolvimento</option>
                    <option value="Infraestrutura">Infraestrutura</option>
                    <option value="Suporte">Suporte</option>
                    <option value="Seguranca">Segurança</option>
                    <option value="Qualidade">Qualidade</option>
                    <option value="Dev-Ops">DevOps</option>
                    <option value="Dados">Dados</option>
                    <option value="Produto">Produto</option>
                </select>
            </div>
            <!-- Descrição -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required></textarea>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select
                    id="status"
                    name="status"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>
            </div>

            <!-- Data de Início -->
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Data de Início</label>
                <input
                    type="date"
                    id="start_date"
                    name="start_date"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value=""
                    required>
            </div>

            <!-- Data de Fim -->
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">Data de Fim</label>
                <input
                    type="date"
                    id="end_date"
                    name="end_date"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value=""
                    required>
            </div>

            <!-- Botões -->
            <div class="flex justify-end mt-6 gap-3">
                <button
                    id="closeAddTeamBtn"
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
    </div><!-- Modal Editar -->
<div id="edit-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg w-full sm:w-96 md:w-96 lg:w-[32rem] xl:w-[40rem] max-h-[80vh] overflow-y-auto">
        <h2 class="text-xl font-semibold mb-4">Editar Time</h2>
        <form method="POST" action="{{ route('teams.update', $team->id_teams ?? '') }}">
            @csrf
            @method('PUT')

            <!-- Nome do Time -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nome do Time</label>
                <input type="text" name="name" id="name" class="w-full p-2 border rounded" value="{{ $team->name ?? '' }}" required>
            </div>

            <!-- Descrição -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>{{ $team->description ?? '' }}</textarea>
            </div>

            <!-- Responsável -->
            <div class="mb-4">
                <label for="responsible_id" class="block text-sm font-medium text-gray-700">Responsável</label>
                <select
                    id="responsible_id"
                    name="responsible_id"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="" disabled {{ empty($team->responsible_id) ? 'selected' : '' }}>Escolha um responsável</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id_user }}" {{ ($team->responsible_id ?? '') == $user->id_user ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tipo de Time -->
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Time</label>
                <select
                    id="type"
                    name="type"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="" disabled {{ empty($team->type) ? 'selected' : '' }}>Escolha o tipo de time</option>
                    <option value="Desenvolvimento" {{ ($team->type ?? '') == 'Desenvolvimento' ? 'selected' : '' }}>Desenvolvimento</option>
                    <option value="Infraestrutura" {{ ($team->type ?? '') == 'Infraestrutura' ? 'selected' : '' }}>Infraestrutura</option>
                    <option value="Suporte" {{ ($team->type ?? '') == 'Suporte' ? 'selected' : '' }}>Suporte</option>
                    <option value="Seguranca" {{ ($team->type ?? '') == 'Seguranca' ? 'selected' : '' }}>Segurança</option>
                    <option value="Qualidade" {{ ($team->type ?? '') == 'Qualidade' ? 'selected' : '' }}>Qualidade</option>
                    <option value="Dev-Ops" {{ ($team->type ?? '') == 'Dev-Ops' ? 'selected' : '' }}>DevOps</option>
                    <option value="Dados" {{ ($team->type ?? '') == 'Dados' ? 'selected' : '' }}>Dados</option>
                    <option value="Produto" {{ ($team->type ?? '') == 'Produto' ? 'selected' : '' }}>Produto</option>
                </select>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select
                    id="status"
                    name="status"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="Ativo" {{ ($team->status ?? '') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="Inativo" {{ ($team->status ?? '') == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>

            <!-- Data de Início -->
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Data de Início</label>
                <input
                    type="date"
                    id="start_date"
                    name="start_date"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ $team->start_date ?? '' }}"
                    required>
            </div>

            <!-- Data de Fim -->
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">Data de Fim</label>
                <input
                    type="date"
                    id="end_date"
                    name="end_date"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ $team->end_date ?? '' }}"
                    required>
            </div>

            <!-- Botões de ação -->
            <div class="flex justify-between">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Excluir -->
<div id="delete-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg w-full max-w-xl h-auto max-h-screen overflow-y-auto">
        <h2 class="text-xl font-semibold mb-4">Tem certeza de que deseja excluir este time?</h2>
        <form method="POST" id="delete-form" action="" class="flex gap-4 justify-between">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Sim</button>
            <button type="button" onclick="closeDeleteModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Não</button>
        </form>
    </div>
</div>
<!-- Modal de Visualização -->
<div id="view-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg w-full max-w-5xl max-h-[90vh] overflow-auto">
        <h2 class="text-xl font-semibold mb-4">Visualizar Time</h2>
        <div class="space-y-4">

            <!-- Nome do Time -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nome do Time</label>
                <input type="text" id="name" class="w-full p-2 border rounded text-gray-700 bg-gray-100" value="{{ $team->name ?? '' }}" readonly>
            </div>

            <!-- Descrição -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                <textarea
                    id="description"
                    class="w-full px-3 py-2 border rounded-lg text-gray-700 bg-gray-100"
                    rows="3"
                    readonly>{{ $team->description ?? '' }}</textarea>
            </div>

            <!-- Responsável -->
            <div>
                <label for="responsible_id" class="block text-sm font-medium text-gray-700">Responsável</label>
                <span id="responsible_id" class="block w-full px-3 py-2 border rounded text-gray-700 bg-gray-100">
                    @foreach ($users as $user)
                    {{ $user->name }}{{ !$loop->last ? ',' : '' }}
                    @endforeach
                </span>
            </div>

            <!-- Tipo de Time -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Time</label>
                <span id="type" class="block w-full px-3 py-2 border rounded text-gray-700 bg-gray-100">{{ $team->type ?? '' }}</span>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <span id="status" class="block w-full px-3 py-2 border rounded text-gray-700 bg-gray-100">{{ $team->status ?? '' }}</span>
            </div>

            <!-- Data de Início -->
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Data de Início</label>
                <input
                    type="date"
                    id="start_date"
                    class="w-full px-3 py-2 border rounded text-gray-700 bg-gray-100"
                    value="{{ $team->start_date ?? '' }}"
                    readonly>
            </div>

            <!-- Data de Fim -->
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Data de Fim</label>
                <input
                    type="date"
                    id="end_date"
                    class="w-full px-3 py-2 border rounded text-gray-700 bg-gray-100"
                    value="{{ $team->end_date ?? '' }}"
                    readonly>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" onclick="closeViewModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de filtros (se necessário) -->
<div id="filters-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-end sm:items-center hidden transition-all transform duration-300 ease-in-out">
    <div class="bg-white p-4 rounded-t-lg sm:rounded-lg w-full sm:w-96 md:w-96 lg:w-[32rem] xl:w-[40rem] max-h-[80vh] overflow-y-auto">
        <h2 class="text-xl font-semibold mb-4">Filtros</h2>

        <form action="{{ route('teams') }}" method="GET">
            <!-- Filtro de nome do time -->
            <label for="teamFilter" class="block text-sm font-medium text-gray-700">Nome do Time</label>
            <input type="text" id="teamFilter" name="name" value="{{ $filters['name'] ?? '' }}" class="w-full px-3 py-2 border rounded-lg mb-4" placeholder="Filtrar por nome do time">

            <!-- Filtro de status -->
            <label for="filter-status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="filter-status" name="status" class="w-full px-4 py-2 border rounded-lg mb-4">
                <option value="">Selecione um status</option>
                <option value="Ativo" {{ (isset($filters['status']) && $filters['status'] == 'Ativo') ? 'selected' : '' }}>Ativo</option>
                <option value="Inativo" {{ (isset($filters['status']) && $filters['status'] == 'Inativo') ? 'selected' : '' }}>Inativo</option>
            </select>

            <!-- Filtro de data de início -->
            <label for="start_date" class="block text-sm font-medium text-gray-700">Data de Início</label>
            <input type="date" id="start_date" name="start_date" value="{{ $filters['start_date'] ?? '' }}" class="w-full px-3 py-2 border rounded-lg mb-4">

            <!-- Filtro de data de término -->
            <label for="end_date" class="block text-sm font-medium text-gray-700">Data de Término</label>
            <input type="date" id="end_date" name="end_date" value="{{ $filters['end_date'] ?? '' }}" class="w-full px-3 py-2 border rounded-lg mb-4">

            <!-- Filtro de responsável -->
            <label for="responsible" class="block text-sm font-medium text-gray-700">Responsável</label>
            <input type="text" id="responsible" name="responsible" value="{{ $filters['responsible'] ?? '' }}" class="w-full px-3 py-2 border rounded-lg mb-4" placeholder="Filtrar por responsável">

            <!-- Filtro de tarefas (Exemplo: número mínimo de tarefas) -->
            <label for="min_tasks" class="block text-sm font-medium text-gray-700">Número Mínimo de Tarefas</label>
<input type="number" id="min_tasks" name="min_tasks" value="{{ $filters['min_tasks'] ?? '' }}" class="w-full px-3 py-2 border rounded-lg mb-4" placeholder="Filtrar por número de tarefas" min="0" step="1">

            <!-- Botões de filtro -->
            <div class="flex justify-between mt-6">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Aplicar</button>
                <button type="button" onclick="closeFiltersModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/teams.js') }}"></script>


@endsection
