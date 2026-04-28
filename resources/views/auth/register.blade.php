<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bagi Kata</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @fluxAppearance
</head>
<body class="min-h-screen flex items-center justify-center bg-zinc-50 dark:bg-zinc-950 font-sans py-12">
    <div class="w-full max-w-md px-6">
        <div class="flex flex-col items-center mb-8">
            <a href="/">
                <img src="{{ asset('img/logo.png') }}" alt="Bagi Kata" class="w-12 h-12 mb-4">
            </a>
            <flux:heading size="xl">Buat Akun Baru</flux:heading>
            <flux:text class="text-center">Bergabunglah dan mulai bagi kata-katamu</flux:text>
        </div>

        <flux:card>
            <form method="POST" action="/register" class="space-y-6">
                @csrf
                
                <flux:input label="Nama Lengkap" id="name" name="name" value="{{ old('name') }}" required />
                
                <flux:input label="Username" id="username" name="username" value="{{ old('username') }}" required />
                
                <flux:input label="Email" id="email" name="email" type="email" value="{{ old('email') }}" required />
                
                <flux:input label="Password" id="password" name="password" type="password" required />
                
                <flux:input label="Konfirmasi Password" id="password_confirmation" name="password_confirmation" type="password" required />

                <flux:button type="submit" variant="primary" class="w-full">Daftar Akun</flux:button>
            </form>
        </flux:card>

        <div class="mt-6 text-center text-sm text-zinc-500">
            Sudah punya akun? <flux:link href="/login">Masuk di sini</flux:link>
        </div>
    </div>

    @livewireScripts
    @fluxScripts
</body>
</html>
