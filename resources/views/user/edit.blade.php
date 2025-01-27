@extends('layouts.app')

@section('content')
<section class="bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Editar Usuário</h1>

        <!-- Exibir mensagens de sucesso ou erro -->
        @if(session('success'))
        <div class="mb-4 text-green-500">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="mb-4 text-red-500">{{ session('error') }}</div>
        @endif

        <!-- Formulário de edição -->
        <form action="{{ route('user.update', $user->id_user) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <!-- Nome -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('name')
                <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- E-mail -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('email')
                <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Senha -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Nova Senha (Opcional)</label>
                <input type="password" name="password" id="password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('password')
                <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirmação de Senha -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nova Senha (Opcional)</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <!-- Papel -->
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Papel</label>
                <select name="role" id="role"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    {{ auth()->user()->role !== 'Admin' ? 'disabled' : '' }}>
                    <option value="Developer" {{ $user->role == 'Developer' ? 'selected' : '' }}>Developer</option>
                    <option value="Frontend" {{ $user->role == 'Frontend' ? 'selected' : '' }}>Frontend Developer</option>
                    <option value="Backend" {{ $user->role == 'Backend' ? 'selected' : '' }}>Backend Developer</option>
                    <option value="Fullstack" {{ $user->role == 'Fullstack' ? 'selected' : '' }}>Fullstack Developer</option>
                    <option value="Mobile" {{ $user->role == 'Mobile' ? 'selected' : '' }}>Mobile Developer</option>
                    <option value="DevOps" {{ $user->role == 'DevOps' ? 'selected' : '' }}>DevOps</option>
                    <option value="Designer" {{ $user->role == 'Designer' ? 'selected' : '' }}>Designer</option>
                    <option value="QA" {{ $user->role == 'QA' ? 'selected' : '' }}>QA Engineer</option>
                    <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Administrador</option>
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
                    <option value="Junior" {{ $user->experience == 'Junior' ? 'selected' : '' }}>Júnior</option>
                    <option value="Pleno" {{ $user->experience == 'Pleno' ? 'selected' : '' }}>Pleno</option>
                    <option value="Senior" {{ $user->experience == 'Senior' ? 'selected' : '' }}>Sênior</option>
                </select>
            </div>


            <!-- Botão de Salvar -->
            <div class="mb-4">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Salvar</button>
            </div>
        </form>
    </div>
</section>
@endsection
