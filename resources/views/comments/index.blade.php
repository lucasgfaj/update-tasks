@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/comments.css') }}">
<section class="mt-10">
    <div class="container mx-auto">
        <h1 class="text-3xl font-extrabold mb-6 text-center text-transparent bg-clip-text bg-gradient-to-r from-purple-500 via-fuchsia-500 to-pink-500">
            Comentários
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
                    id="addCommentBtn"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    Adicionar Comentário
                </button>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto shadow-lg rounded-lg">
        <table id="comments" class="display table-auto w-full border-collapse bg-white rounded-lg">
            <!-- Cabeçalho -->
            <thead>
                <tr class="bg-gradient-to-r from-blue-400 to-purple-400 text-white text-sm uppercase tracking-wide">
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Tipo</th>
                    <th class="px-4 py-3 text-left">Tarefa</th>
                    <th class="px-4 py-3 text-left">Usuário</th>
                    <th class="px-4 py-3 text-left">Time</th>
                    <th class="px-4 py-3 text-left">Data de Criação</th>
                    <th class="px-4 py-3 text-left">Opções</th>
                </tr>
            </thead>
            <!-- Corpo -->
            <tbody>
                @foreach($comments as $index => $comment)
                <tr class="bg-gray-50 hover:bg-blue-50 transition" onclick="openViewCommentModal({{ $comment->id_comments ?? ''}})">
                    <td class="px-4 py-3 border-t border-gray-200">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 border-t border-gray-200">{{ $comment->type ?? '' }}</td>
                    <td class="px-4 py-3 border-t border-gray-200">
                        @foreach ($tasks as $task)
                        @if ($task->id_tasks == $comment->task_id)
                        {{ $task->name }}
                        @endif
                        @endforeach
                    </td>
                    <td class="px-4 py-3 border-t border-gray-200">
                        @foreach ($users as $user)
                        @if ($user->id_user == $comment->user_id)
                        {{ $user->name }}
                        @endif
                        @endforeach
                    </td>
                    <td class="px-4 py-3 border-t border-gray-200">
                        @foreach ($teams as $team)
                        @if ($team->id_teams == $comment->team_id)
                        {{ $team->name }}
                        @endif
                        @endforeach
                    </td>
                    <td class="px-4 py-3 border-t border-gray-200">{{ \Carbon\Carbon::parse($comment->created_at)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 border-t border-gray-200 flex gap-2">
                        <button
                            class="text-sm bg-blue-500 text-white px-3 py-1 rounded shadow hover:bg-blue-600"
                            onclick="openEditCommentModal({{ $comment->id_comments ?? '' }}); event.stopPropagation()">
                            Editar
                        </button>
                        <button
                            class="text-sm bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600"
                            onclick="confirmDeleteComment({{ $comment->id_comments ?? '' }}); event.stopPropagation()">
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
            Mostrando <span class="font-semibold text-gray-900 dark:text-white">{{ $comments->firstItem() }}</span> para
            <span class="font-semibold text-gray-900 dark:text-white">{{ $comments->lastItem() }}</span> de
            <span class="font-semibold text-gray-900 dark:text-white">{{ $comments->total() }}</span> Entradas
        </span>

        <nav class="mt-4" aria-label="Page navigation example">
            <ul class="flex items-center -space-x-px h-8 text-sm">
                @if ($comments->onFirstPage())
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
                    <a href="{{ $comments->previousPageUrl() }}" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="sr-only">Previous</span>
                        <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                        </svg>
                    </a>
                </li>
                @endif

                @for ($i = 1; $i <= $comments->lastPage(); $i++)
                    <li>
                        <a href="{{ $comments->url($i) }}" class="flex items-center justify-center px-3 h-8 leading-tight {{ $i == $comments->currentPage() ? 'text-white bg-blue-500 border-blue-500' : 'text-gray-500 bg-white border-gray-300' }} hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            {{ $i }}
                        </a>
                    </li>
                    @endfor

                    @if ($comments->hasMorePages())
                    <li>
                        <a href="{{ $comments->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
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
    id="modalAddComment"
    class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div
        class="bg-white rounded-lg shadow-lg p-6 w-full max-w-6xl h-auto relative max-h-[80vh] overflow-y-auto">
        <!-- Título do Modal -->
        <h2 class="text-xl font-bold text-gray-800">Adicionar Novo Comentário</h2>

        <!-- Formulário -->
        <form id="addCommentForm" action="{{ route('comments.store') }}" method="POST" class="mt-4">
            @csrf
            <!-- Tipo de Comentário -->
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Comentário</label>
                <input
                    type="text"
                    id="type"
                    name="type"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
            </div>

            <!-- Tarefa -->
            <div class="mb-4">
                <label for="task_id" class="block text-sm font-medium text-gray-700">Tarefa</label>
                <select
                    id="task_id"
                    name="task_id"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="" disabled selected>Escolha uma Tarefa</option>
                    @foreach ($tasks as $task)
                    <option value="{{ $task->id_tasks }}">{{ $task->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Usuário -->
            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700">Usuário</label>
                <select
                    id="user_id"
                    name="user_id"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="" disabled selected>Escolha um Usuário</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id_user }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Time -->
            <div class="mb-4">
                <label for="team_id" class="block text-sm font-medium text-gray-700">Time</label>
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

            <!-- Botões -->
            <div class="flex justify-end mt-6 gap-3">
                <button
                    id="closeAddCommentBtn"
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

<!-- Modal Editar Comentário -->
<div id="editCommentModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg w-full sm:w-96 md:w-96 lg:w-[32rem] xl:w-[40rem] max-h-[80vh] overflow-y-auto">
        <h2 class="text-xl font-semibold mb-4">Editar Comentário</h2>
        <form method="POST" action="{{ route('comments.update', $comment->id_comments ?? '') }}">
            @csrf
            @method('PUT')

            <!-- Tipo de Comentário -->
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Comentário</label>
                <input type="text" name="type" id="type" class="w-full p-2 border rounded" value="{{ $comment->type ?? '' }}" required>
            </div>

            <!-- Tarefa -->
            <div class="mb-4">
                <label for="task_id" class="block text-sm font-medium text-gray-700">Tarefa</label>
                <select
                    id="task_id"
                    name="task_id"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="" disabled {{ empty($comment->task_id) ? 'selected' : '' }}>Escolha uma Tarefa</option>
                    @foreach ($tasks as $task)
                    <option value="{{ $task->id_tasks }}" {{ ($comment->task_id ?? '') == $task->id_tasks ? 'selected' : '' }}>{{ $task->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Usuário -->
            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700">Usuário</label>
                <select
                    id="user_id"
                    name="user_id"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="" disabled {{ empty($comment->user_id) ? 'selected' : '' }}>Escolha um Usuário</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id_user }}" {{ ($comment->user_id ?? '') == $user->id_user ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Time -->
            <div class="mb-4">
                <label for="team_id" class="block text-sm font-medium text-gray-700">Time</label>
                <select
                    id="team_id"
                    name="team_id"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="" disabled {{ empty($comment->team_id) ? 'selected' : '' }}>Escolha um Time</option>
                    @foreach ($teams as $team)
                    <option value="{{ $team->id_teams }}" {{ ($comment->team_id ?? '') == $team->id_teams ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Descrição -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>{{ $comment->description ?? '' }}</textarea>
            </div>

            <!-- Botões de ação -->
            <div class="flex justify-between">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                <button type="button" onclick="closeEditCommentModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Excluir Comentário -->
<div id="deleteCommentModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg w-full max-w-xl h-auto max-h-screen overflow-y-auto">
        <h2 class="text-xl font-semibold mb-4">Tem certeza de que deseja excluir este comentário?</h2>
        <form method="POST" id="deleteCommentForm" action="" class="flex gap-4 justify-between">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Sim</button>
            <button type="button" onclick="closeDeleteCommentModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Não</button>
        </form>
    </div>
</div>

<!-- Modal de Visualização de Tarefa -->
<div id="viewCommentModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg w-full max-w-5xl max-h-[90vh] overflow-auto">
        <h2 class="text-xl font-semibold mb-4">Visualizar Comentário</h2>
        <div class="space-y-4">

            <!-- Nome da Tarefa -->
            <div>
                <label for="commentType" class="block text-sm font-medium text-gray-700">Tipo</label>
                <input type="text" id="commentType" class="w-full p-2 border rounded text-gray-700 bg-gray-100" value="{{ $comment->type ?? '' }}" readonly>
            </div>

            <!-- Descrição -->
            <div>
                <label for="commentDescription" class="block text-sm font-medium text-gray-700">Descrição</label>
                <textarea id="commentDescription" class="w-full px-3 py-2 border rounded-lg text-gray-700 bg-gray-100" rows="3" readonly>{{ $comment->description ?? '' }}</textarea>
            </div>

            <!-- Time Responsável -->
             <div>
                <label for="commentTeam" class="block text-sm font-medium text-gray-700">Time Responsável</label>
                <span id="commentTeam" class="block w-full px-3 py-2 border rounded text-gray-700 bg-gray-100">
                @if(isset($comment))
            @foreach ($teams as $team)
                @if ($team->id_teams == $comment->team_id)
                    {{ $team->name }}
                @endif
            @endforeach
        @else
            <!-- Caso não haja comentário, pode exibir um valor padrão ou em branco -->
            Nenhum time responsável
        @endif
    </span>
</div>
                </span>
            </div>

            <!-- Usuário Responsável -->
             <div>
                <label for="user-id" class="block text-sm font-medium text-gray-700">Criador do Comentário</label>
                <span id="user_id" class="block w-full px-3 py-2 border rounded text-gray-700 bg-gray-100">
                @foreach ($users as $user)
                    {{ $user->name }}{{ !$loop->last ? ',' : '' }}
                @endforeach
                </span>
            </div>

            <!-- Tarefa -->
             <div>
                <label for="commentTeam" class="block text-sm font-medium text-gray-700">Tarefa</label>
                <span id="commentTeam" class="block w-full px-3 py-2 border rounded text-gray-700 bg-gray-100">
                    @if(isset($comment))
            @foreach ($tasks as $task)
                @if ($task->id_tasks == $comment->task_id)
                    {{ $task->name }}
                @endif
            @endforeach
        @else
            <!-- Caso não haja comentário, pode exibir um valor padrão ou em branco -->
            Nenhuma tarefa atribuída
        @endif
                </span>
            </div>

            <!-- Data de Criação -->
            <div>
    <label for="commentCreatedAt" class="block text-sm font-medium text-gray-700">Data de Criação</label>
    <input type="text" id="commentCreatedAt" class="w-full p-2 border rounded text-gray-700 bg-gray-100"
        value="{{ isset($comment) && $comment->created_at ? \Carbon\Carbon::parse($comment->created_at)->format('d/m/Y') : '' }}"
        readonly>
</div>
            <div class="flex justify-end mt-6">
                <button type="button" onclick="closeViewCommentModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de filtros -->
<div id="filters-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-end sm:items-center hidden transition-all transform duration-300 ease-in-out">
    <div class="bg-white p-4 rounded-t-lg sm:rounded-lg w-full sm:w-96 md:w-96 lg:w-[32rem] xl:w-[40rem] max-h-[80vh] overflow-y-auto">
        <h2 class="text-xl font-semibold mb-4">Filtros</h2>

        <form action="{{ route('comments') }}" method="GET">
            <!-- Filtro de tipo de comentário -->
            <label for="typeFilter" class="block text-sm font-medium text-gray-700">Tipo de Comentário</label>
            <input type="text" id="typeFilter" name="type" value="{{ $filters['type'] ?? '' }}" class="w-full px-3 py-2 border rounded-lg mb-4" placeholder="Filtrar por tipo de comentário">

            <!-- Filtro de tarefa -->
            <label for="taskFilter" class="block text-sm font-medium text-gray-700">Tarefa</label>
            <select id="taskFilter" name="task" class="w-full px-3 py-2 border rounded-lg mb-4">
                <option value="" disabled selected>Escolha uma Tarefa</option>
                @foreach ($tasks as $task)
                <option value="{{ $task->id_tasks }}">{{ $task->name }}</option>
                @endforeach
            </select>

            <!-- Filtro de usuário -->
            <label for="userFilter" class="block text-sm font-medium text-gray-700">Usuário</label>
            <select id="userFilter" name="user" class="w-full px-3 py-2 border rounded-lg mb-4">
                <option value="" disabled selected>Escolha um Usuário</option>
                @foreach ($users as $user)
                <option value="{{ $user->id_user }}">{{ $user->name }}</option>
                @endforeach
            </select>

            <!-- Filtro de time -->
            <label for="teamFilter" class="block text-sm font-medium text-gray-700">Time</label>
            <select id="teamFilter" name="team" class="w-full px-3 py-2 border rounded-lg mb-4">
                <option value="" disabled selected>Escolha um Time</option>
                @foreach ($teams as $team)
                <option value="{{ $team->id_teams }}">{{ $team->name }}</option>
                @endforeach
            </select>

            <!-- Filtro de data de criação -->
            <label for="created_at" class="block text-sm font-medium text-gray-700">Data de Criação</label>
            <input type="date" id="created_at" name="created_at" value="{{ $filters['created_at'] ?? '' }}" class="w-full px-3 py-2 border rounded-lg mb-4">

            <!-- Botões de filtro -->
            <div class="flex justify-between mt-6">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Aplicar</button>
                <button type="button" onclick="closeFiltersModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/comments.js') }}"></script>

@endsection
