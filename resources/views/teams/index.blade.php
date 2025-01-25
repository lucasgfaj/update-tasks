@extends('layouts.app')

@section('content')
<section class="mt-10">
    <div class="container mx-auto">
        <h1 class="text-3xl font-extrabold mb-6 text-center text-transparent bg-clip-text bg-gradient-to-r from-purple-500 via-fuchsia-500 to-pink-500">
            Time de Projetos
        </h1>
        <div>
            <div class="mb-4 flex justify-between">
                <input
                    type="text"
                    id="taskFilter"
                    placeholder="Filtrar por nome da tarefa"
                    class="w-1/2 px-3 py-2 border rounded-lg">
                <button
                    id="addTaskBtn"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    Adicionar Time
                </button>
            </div>
        </div>
        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table id="task" class="display table-auto w-full border-collapse bg-white rounded-lg">
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
                    @foreach($teams as $team)
                    <tr class="bg-gray-50 hover:bg-blue-50 transition">
                        <td class="px-4 py-3 border-t border-gray-200">{{ $team->id_teams }}</td>
                        <td class="px-4 py-3 border-t border-gray-200">{{ $team->name }}</td>
                        <!-- <td class="px-4 py-3 border-t border-gray-200">{{ $team->description }}</td> -->
                        <td class="px-4 py-3 border-t border-gray-200">{{ $team->responsible_id }}</td>
                        <td class="px-4 py-3 border-t border-gray-200">
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">{{ $team->type }}</span>
                        </td>
                        <td class="px-4 py-3 border-t border-gray-200">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">{{ $team->status }}</span>
                        </td>
                        <td class="px-4 py-3 border-t border-gray-200">{{ $team->start_date }}</td>
                        <td class="px-4 py-3 border-t border-gray-200">{{ $team->end_date }}</td>
                        <!-- <td class="px-4 py-3 border-t border-gray-200">{{ $team->created_at }}</td> -->
                        <td class="px-4 py-3 border-t border-gray-200 flex gap-2">
                            <button
                                class="text-sm bg-blue-500 text-white px-3 py-1 rounded shadow hover:bg-blue-600"
                                onclick="openEditModal({{ $team->id_teams }})">
                                Editar
                            </button>
                            <button class="text-sm bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600"
                                onclick="confirmDelete({{ $team->id_teams }})">
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
                Showing <span class="font-semibold text-gray-900 dark:text-white">1</span> to <span class="font-semibold text-gray-900 dark:text-white">10</span> of <span class="font-semibold text-gray-900 dark:text-white">100</span> Entries
            </span>
            <nav class="mt-4" aria-label="Page navigation example">
                <ul class="flex items-center -space-x-px h-8 text-sm">
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Previous</span>
                            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                    </li>
                    <li>
                        <a href="#" aria-current="page" class="z-10 flex items-center justify-center px-3 h-8 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">4</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">5</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Next</span>
                            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav>


        </div>
</section>

<!-- Modal para adicionar um novo time -->
<div
    id="modalAddTeam"
    class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3 relative">
        <!-- Título do Modal -->
        <h2 class="text-lg font-bold text-gray-800">Adicionar Novo Time</h2>

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
                    <option value="desenvolvimento">Desenvolvimento</option>
                    <option value="infraestrutura">Infraestrutura</option>
                    <option value="suporte">Suporte</option>
                    <option value="seguranca">Segurança</option>
                    <option value="qualidade">Qualidade</option>
                    <option value="devops">DevOps</option>
                    <option value="dados">Dados</option>
                    <option value="produto">Produto</option>
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
</div>

<!-- Modal Editar -->
<!-- <div id="edit-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg w-96">
        <h2 class="text-xl font-semibold mb-4">Editar Time</h2>
        <form method="POST" action="{{ route('teams.update', $team->id_teams) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-sm text-gray-700">Nome do Time</label>
                <input type="text" name="name" id="name" class="w-full p-2 border rounded" value="{{ $team->name }}" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm text-gray-700">Descrição</label>
                <input type="text" name="description" id="description" class="w-full p-2 border rounded" value="{{ $team->description }}" required>
            </div> -->
         <!--   < Adicione aqui outros campos para editar o time (status, start_date, etc) -->
           <!-- <div class="flex justify-between">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
            </div>
        </form>
    </div>
</div> -->

<div id="delete-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg w-96">
        <h2 class="text-xl font-semibold mb-4">Tem certeza de que deseja excluir este time?</h2>
        <form method="POST" id="delete-form" action="" class="flex gap-4 justify-between">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Sim</button>
            <button type="button" onclick="closeDeleteModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Não</button>
        </form>
    </div>
</div>

<script src="{{ asset('js/teams.js') }}"></script>


@endsection
