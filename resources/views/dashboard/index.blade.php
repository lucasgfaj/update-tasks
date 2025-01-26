@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
<section class="mt-10">
    <div class="container mx-auto">
        <h1 class="text-3xl font-extrabold mb-6 text-center text-transparent bg-clip-text bg-gradient-to-r from-purple-500 via-fuchsia-500 to-pink-500">
            Tarefas
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
                    id="addTaskBtn"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    Adicionar Tarefa
                </button>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto shadow-lg rounded-lg">
        <table id="tasks" class="display table-auto w-full border-collapse bg-white rounded-lg">
            <!-- Cabeçalho -->
            <thead>
                <tr class="bg-gradient-to-r from-blue-400 to-purple-400 text-white text-sm uppercase tracking-wide">
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Tarefa</th>
                    <th class="px-4 py-3 text-left">Time Responsável</th>
                    <th class="px-4 py-3 text-left">Prioridade</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Data Inicial</th>
                    <th class="px-4 py-3 text-left">Data Final</th>
                    <th class="px-4 py-3 text-left">Opções</th>
                </tr>
            </thead>
            <!-- Corpo -->
            <tbody>
                @foreach($tasks as $index => $task)
                <tr class="bg-gray-50 hover:bg-blue-50 transition" onclick="openViewTaskModal({{ $task->id_tasks ?? ''}})">
                    <td class="px-4 py-3 border-t border-gray-200">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 border-t border-gray-200">{{ $task->name }}</td>
                    <td class="px-4 py-3 border-t border-gray-200">
                        @foreach ($teams as $team)
                        @if ($team->id_teams == $task->team_id)
                        {{ $team->name }}
                        @endif
                        @endforeach
                    </td>
                    <td class="px-4 py-3 border-t border-gray-200">
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">{{ $task->priority }}</span>
                    </td>
                    <td class="px-4 py-3 border-t border-gray-200">
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">{{ $task->status }}</span>
                    </td>
                    <td class="px-4 py-3 border-t border-gray-200">{{ \Carbon\Carbon::parse($task->start_date)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 border-t border-gray-200">{{ \Carbon\Carbon::parse($task->end_date)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 border-t border-gray-200 flex gap-2">
                        <button
                            class="text-sm bg-blue-500 text-white px-3 py-1 rounded shadow hover:bg-blue-600"
                            onclick="openEditTaskModal({{ $task->id_tasks ?? '' }}); event.stopPropagation()">
                            Editar
                        </button>
                        <button
                            class="text-sm bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600"
                            onclick="confirmDeleteTask({{ $task->id_tasks ?? '' }}); event.stopPropagation()">
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
            Mostrando <span class="font-semibold text-gray-900 dark:text-white">{{ $tasks->firstItem() }}</span> para
            <span class="font-semibold text-gray-900 dark:text-white">{{ $tasks->lastItem() }}</span> de
            <span class="font-semibold text-gray-900 dark:text-white">{{ $tasks->total() }}</span> Entradas
        </span>

        <nav class="mt-4" aria-label="Page navigation example">
            <ul class="flex items-center -space-x-px h-8 text-sm">
                @if ($tasks->onFirstPage())
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
                    <a href="{{ $tasks->previousPageUrl() }}" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="sr-only">Previous</span>
                        <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                        </svg>
                    </a>
                </li>
                @endif

                @for ($i = 1; $i <= $tasks->lastPage(); $i++)
                    <li>
                        <a href="{{ $tasks->url($i) }}" class="flex items-center justify-center px-3 h-8 leading-tight {{ $i == $tasks->currentPage() ? 'text-white bg-blue-500 border-blue-500' : 'text-gray-500 bg-white border-gray-300' }} hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            {{ $i }}
                        </a>
                    </li>
                    @endfor

                    @if ($tasks->hasMorePages())
                    <li>
                        <a href="{{ $tasks->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
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
    id="modalAddTask"
    class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div
        class="bg-white rounded-lg shadow-lg p-6 w-full max-w-6xl h-auto relative max-h-[80vh] overflow-y-auto">
        <!-- Título do Modal -->
        <h2 class="text-xl font-bold text-gray-800">Adicionar Nova Tarefa</h2>

        <!-- Formulário -->
        <form id="addTaskForm" action="{{ route('tasks.store') }}" method="POST" class="mt-4">
            @csrf
            <!-- Nome da Tarefa -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nome da Tarefa</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
            </div>

            <!-- Responsável -->
            <div class="mb-4">
                <label for="team_id" class="block text-sm font-medium text-gray-700">Time Responsável</label>
                <select
                    id="team_id"
                    name="team_id"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="" disabled selected>Escolha um Time</option>
                    @foreach ($teams as $team)
                    <option value="{{ $team->id_teams }}">{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tipo de Tarefa -->
            <div class="mb-4">
                <label for="priority" class="block text-sm font-medium text-gray-700">Prioridade</label>
                <select
                    id="priority"
                    name="priority"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="" disabled selected>Escolha uma prioridade</option>
                    <option value="Baixa">Baixa</option>
                    <option value="Média">Média</option>
                    <option value="Alta">Alta</option>
                    <option value="Grave">Grave</option>
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
                    <option value="Aberta">Aberta</option>
                    <option value="Em Andamento">Em Andamento</option>
                    <option value="Finalizada">Finalizada</option>
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
                    id="closeAddTaskBtn"
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

<!-- Modal Editar Tarefa -->
<div id="editTaskModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg w-full sm:w-96 md:w-96 lg:w-[32rem] xl:w-[40rem] max-h-[80vh] overflow-y-auto">
        <h2 class="text-xl font-semibold mb-4">Editar Tarefa</h2>
        <form method="POST" action="{{ route('tasks.update', $task->id_tasks ?? '') }}">
            @csrf
            @method('PUT')

            <!-- Nome da Tarefa -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nome da Tarefa</label>
                <input type="text" name="name" id="name" class="w-full p-2 border rounded" value="{{ $task->name ?? '' }}" required>
            </div>

            <!-- Responsável -->
            <div class="mb-4">
                <label for="team_id" class="block text-sm font-medium text-gray-700">Responsável</label>
                <select
                    id="team_id"
                    name="team_id"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="" disabled {{ empty($task->task_id) ? 'selected' : '' }}>Escolha um time responsável</option>
                    @foreach ($teams as $team)
                    <option value="{{ $team->id_teams }}" {{ ($task->team_id ?? '') == $team->id_teams ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tipo de Prioridade -->
            <div class="mb-4">
                <label for="priority" class="block text-sm font-medium text-gray-700">Prioridade</label>
                <select
                    id="priority"
                    name="priority"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="" disabled {{ empty($task->priority) ? 'selected' : '' }}>Escolha uma prioridade</option>
                    <option value="Baixa" {{ ($task->priority ?? '') == 'Baixa' ? 'selected' : '' }}>Baixa</option>
                    <option value="Média" {{ ($task->priority ?? '') == 'Média' ? 'selected' : '' }}>Média</option>
                    <option value="Alta" {{ ($task->priority ?? '') == 'Alta' ? 'selected' : '' }}>Alta</option>
                    <option value="Grave" {{ ($task->priority ?? '') == 'Grave' ? 'selected' : '' }}>Grave</option>
                </select>
            </div>

            <!-- Descrição -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>{{ $task->description ?? '' }}</textarea>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select
                    id="status"
                    name="status"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="Aberta" {{ ($task->status ?? '') == 'Aberta' ? 'selected' : '' }}>Aberta</option>
                    <option value="Em Andamento" {{ ($task->status ?? '') == 'Em Andamento' ? 'selected' : '' }}>Em Andamento</option>
                    <option value="Finalizada" {{ ($task->status ?? '') == 'Finalizada' ? 'selected' : '' }}>Finalizada</option>
                </select>
            </div>

            <!-- Data de Início -->
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Data de Início</label>
                <input type="date" id="start_date" name="start_date" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ $task->start_date ?? '' }}" required>
            </div>

            <!-- Data de Fim -->
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">Data de Fim</label>
                <input type="date" id="end_date" name="end_date" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ $task->end_date ?? '' }}" required>
            </div>

            <!-- Botões de ação -->
            <div class="flex justify-between">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                <button type="button" onclick="closeEditTaskModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Excluir -->
<div id="delete-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg w-full max-w-xl h-auto max-h-screen overflow-y-auto">
        <h2 class="text-xl font-semibold mb-4">Tem certeza de que deseja excluir esta tarefa?</h2>
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
        <h2 class="text-xl font-semibold mb-4">Visualizar Tarefa</h2>
        <div class="space-y-4">

            <!-- Nome da Tarefa -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nome da Tarefa</label>
                <input type="text" id="name" class="w-full p-2 border rounded text-gray-700 bg-gray-100" value="{{ $task->name ?? '' }}" readonly>
            </div>

            <!-- Descrição -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                <textarea
                    id="description"
                    class="w-full px-3 py-2 border rounded-lg text-gray-700 bg-gray-100"
                    rows="3"
                    readonly>{{ $task->description ?? '' }}</textarea>
            </div>

            <!-- Responsável -->
            <div>
                <label for="team_id" class="block text-sm font-medium text-gray-700">Time Responsável</label>
                <span id="team_id" class="block w-full px-3 py-2 border rounded text-gray-700 bg-gray-100">
                    @foreach ($tasks as $task) <!-- Certifique-se de estar percorrendo as tarefas -->
                    @foreach ($teams as $team)
                    @if ($team->id_teams == $task->team_id)
                    {{ $team->name }}
                    @endif
                    @endforeach
                    @endforeach
                </span>
            </div>

            <!-- Tipo de Tarefa -->
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700">Prioridadq de Tarefa</label>
                <span id="priority" class="block w-full px-3 py-2 border rounded text-gray-700 bg-gray-100">{{ $task->priority ?? '' }}</span>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <span id="status" class="block w-full px-3 py-2 border rounded text-gray-700 bg-gray-100">{{ $task->status ?? '' }}</span>
            </div>

            <!-- Data de Início -->
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Data de Início</label>
                <input
                    type="date"
                    id="start_date"
                    class="w-full px-3 py-2 border rounded text-gray-700 bg-gray-100"
                    value="{{ $task->start_date ?? '' }}"
                    readonly>
            </div>

            <!-- Data de Fim -->
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Data de Fim</label>
                <input
                    type="date"
                    id="end_date"
                    class="w-full px-3 py-2 border rounded text-gray-700 bg-gray-100"
                    value="{{ $task->end_date ?? '' }}"
                    readonly>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" onclick="closeViewModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de filtros -->
<div id="filters-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-end sm:items-center hidden transition-transform duration-300 ease-in-out">
    <div class="bg-white p-6 rounded-t-lg sm:rounded-lg w-full sm:w-96 md:w-[28rem] lg:w-[32rem] xl:w-[40rem] max-h-[80vh] overflow-y-auto shadow-lg">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Filtros</h2>

        <form action="{{ route('dashboard') }}" method="GET" class="space-y-4">
            <!-- Filtro por Nome da Tarefa -->
            <div>
                <label for="taskFilter" class="block text-sm font-medium text-gray-700 mb-1">Nome da Tarefa</label>
                <input type="text" id="taskFilter" name="name"
                    class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                    value="{{ $filters['name'] ?? '' }}" placeholder="Digite o nome da tarefa">
            </div>

            <!-- Filtro por Status -->
            <div>
                <label for="filter-status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="filter-status" name="status"
                    class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                    <option value="">Selecione um status</option>
                    <option value="Aberta" {{ isset($filters['status']) && $filters['status'] == 'Aberta' ? 'selected' : '' }}>Aberta</option>
                    <option value="Em Andamento" {{ isset($filters['status']) && $filters['status'] == 'Em Andamento' ? 'selected' : '' }}>Em Andamento</option>
                    <option value="Finalizada" {{ isset($filters['status']) && $filters['status'] == 'Finalizada' ? 'selected' : '' }}>Finalizada</option>
                </select>
            </div>

            <!-- Filtro por Data de Início -->
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Data de Início</label>
                <input type="date" id="start_date" name="start_date"
                    class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                    value="{{ $filters['start_date'] ?? '' }}">
            </div>

            <!-- Filtro por Data de Término -->
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Data de Término</label>
                <input type="date" id="end_date" name="end_date"
                    class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                    value="{{ $filters['end_date'] ?? '' }}">
            </div>

            <!-- Filtro por Time Responsável -->
            <div>
                <label for="team_id" class="block text-sm font-medium text-gray-700 mb-1">Time Responsável</label>
                <select id="team_id" name="team_id" class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                    <option value="">Selecione um Time</option> <!-- Opcional: caso não selecione nenhum time -->
                    @foreach ($teams as $team)
                    <option value="{{ $team->id_teams }}" {{ (isset($filters['team_id']) && $filters['team_id'] == $team->id_teams) ? 'selected' : '' }}>
                        {{ $team->name }}
                    </option>
                    @endforeach
                </select>
            </div>


            <!-- Filtro por Tipo de Tarefa -->
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Tarefa</label>
                <select id="priority" name="priority"
                    class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                    <option value="">Selecione um tipo</option>
                    <option value="Baixa" {{ isset($filters['priority']) && $filters['priority'] == 'Baixa' ? 'selected' : '' }}>Baixa</option>
                    <option value="Média" {{ isset($filters['priority']) && $filters['priority'] == 'Média' ? 'selected' : '' }}>Média</option>
                    <option value="Alta" {{ isset($filters['priority']) && $filters['priority'] == 'Alta' ? 'selected' : '' }}>Alta</option>
                    <option value="Grave" {{ isset($filters['priority']) && $filters['priority'] == 'Grave' ? 'selected' : '' }}>Grave</option>
                </select>
            </div>

            <!-- Botões de filtro -->
            <div class="flex justify-between items-center pt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg font-medium transition">Aplicar</button>
                <button type="button" onclick="closeFiltersModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg font-medium transition">Cancelar</button>
            </div>
        </form>
    </div>
</div>


<script src="{{ asset('js/tasks.js') }}"></script>


@endsection
