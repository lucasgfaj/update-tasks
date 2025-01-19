<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <form action="{{ route('register') }}" method="POST" class="bg-white p-6 rounded shadow-md w-full max-w-sm">
        @csrf
        <h1 class="text-xl font-bold mb-4">Register</h1>

        <!-- Mensagem de erro geral -->
        @if ($errors->any())
            <div class="mb-4 text-red-500">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium">Nome</label>
            <input type="text" id="name" name="name" class="w-full border rounded p-2 mt-1" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium">Email</label>
            <input type="email" id="email" name="email" class="w-full border rounded p-2 mt-1" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium">Senha</label>
            <input type="password" id="password" name="password" class="w-full border rounded p-2 mt-1" required>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium">Confirm Senha</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full border rounded p-2 mt-1" required>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded mb-4">Register</button>

        <!-- Link para login -->
        <p class="text-center text-sm">
            Já tem uma conta?
            <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
        </p>
    </form>
</body>
</html>
