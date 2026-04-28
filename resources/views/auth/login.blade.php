<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bagi Kata</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @fluxAppearance
</head>
<body class="min-h-screen flex items-center justify-center bg-zinc-50 dark:bg-zinc-950 font-sans">
    <div class="w-full max-w-sm px-6 py-12">
        <div class="flex flex-col items-center mb-8">
            <a href="/">
                <img src="{{ asset('img/logo.png') }}" alt="Bagi Kata" class="w-12 h-12 mb-4">
            </a>
            <flux:heading size="xl">Selamat Datang</flux:heading>
            <flux:text class="text-center">Masuk ke akun Bagi Kata Anda</flux:text>
        </div>

        <flux:card>
            <form method="POST" action="/login" class="space-y-6">
                @csrf
                
                <flux:input label="Username atau Email" id="login" name="login" value="{{ old('login') }}" required />
                
                <flux:input label="Password" id="password" name="password" type="password" required />

                <flux:button type="submit" variant="primary" class="w-full">Masuk</flux:button>
            </form>
        </flux:card>

        <div class="mt-6 text-center text-sm text-zinc-500">
            Belum punya akun? <flux:link href="/register">Daftar sekarang</flux:link>
        </div>
    </div>

    @livewireScripts
    @fluxScripts
</body>
</html>
