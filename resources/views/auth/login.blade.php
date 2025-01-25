<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Update-Tasks') }}</title>
    <link href="{{ asset('build/assets/app-DYy13L-S.css') }}" rel="stylesheet">

</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <form action="{{ route('auth.login') }}" method="POST" class="bg-white p-6 rounded shadow-md w-full max-w-sm">
        @csrf
        <h1 class="text-xl font-bold mb-4">Login</h1>

        <!-- Mensagem de erro -->
        @if($errors->any())
            <div class="mb-4 text-red-500">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium">Email</label>
            <input type="email" id="email" name="email" class="w-full border rounded p-2 mt-1" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium">Senha</label>
            <input type="password" id="password" name="password" class="w-full border rounded p-2 mt-1" required>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded mb-4">Login</button>

        <!-- Link para registro -->
        <p class="text-center text-sm">
            Não tem uma conta?
            <a href="{{ route('auth.register') }}" class="text-blue-500 hover:underline">Registrar-se</a>
        </p>
    </form>
    <script src="{{ asset('build/assets/app-Xaw6OIO1.js') }}" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
