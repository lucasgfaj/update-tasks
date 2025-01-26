@section('content')
<section class="mt-10">
    <div class="container mx-auto">
        <h1 class="text-3xl font-extrabold mb-6 text-center text-transparent bg-clip-text bg-gradient-to-r from-purple-500 via-fuchsia-500 to-pink-500">
            Tarefas
        </h1>
        <div class="mb-4 flex justify-between">
            <input
                type="text"
                id="taskFilter"
                placeholder="Filtrar por nome da tarefa"
                class="w-1/2 px-3 py-2 border rounded-lg">
            <button
                id="addTaskBtn"
                class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                Adicionar Tarefa
            </button>
        </div>
    </div>
    <div class="overflow-x-auto shadow-lg rounded-lg">
        <table id="task" class="display table-auto w-full border-collapse bg-white rounded-lg">
            <!-- Cabeçalho -->
            <thead>
                <tr class="bg-gradient-to-r from-blue-400 to-purple-400 text-white text-sm uppercase tracking-wide">
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Tarefa</th>
                    <th class="px-4 py-3 text-left">Time de Projeto</th>
                    <!-- <th class="px-4 py-3 text-left">Usuários Envolvidos</th> -->
                    <!-- <th class="px-4 py-3 text-left">Descrição</th> -->
                    <th class="px-4 py-3 text-left">Prioridade</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Data de Criação</th>
                    <th class="px-4 py-3 text-left">Prazo</th>
                    <th class="px-4 py-3 text-left">Opções</th>
                </tr>
            </thead>
            <!-- Corpo -->
            <tbody>
                <tr class="bg-gray-50 hover:bg-blue-50 transition">
                    <td class="px-4 py-3 border-t border-gray-200">1</td>
                    <td class="px-4 py-3 border-t border-gray-200">Tarefa - 1</td>
                    <td class="px-4 py-3 border-t border-gray-200">DevOps</td>
                    <!-- <td class="px-4 py-3 border-t border-gray-200">Lucas Fajardo</td> -->
                    <!-- <td class="px-4 py-3 border-t border-gray-200">Ajustar Dados - SQL</td> -->
                    <td class="px-4 py-3 border-t border-gray-200">
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">Médio</span>
                    </td>
                    <td class="px-4 py-3 border-t border-gray-200">
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">Em Andamento</span>
                    </td>
                    <td class="px-4 py-3 border-t border-gray-200">18/11/2024</td>
                    <td class="px-4 py-3 border-t border-gray-200">18/02/2025</td>
                    <td class="px-4 py-3 border-t border-gray-200 flex gap-2">
                        <button class="text-sm bg-blue-500 text-white px-3 py-1 rounded shadow hover:bg-blue-600">Editar</button>
                        <button class="text-sm bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600">Excluir</button>
                    </td>
                </tr>
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
@endsection
