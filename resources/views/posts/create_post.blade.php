<x-layouts::app>
    <x-slot:title>
        Buat postingan baru
    </x-slot:title>

    <flux:main>
        <div class="mb-6 flex items-center gap-4">
            <flux:button href="{{ url()->previous() }}" icon="arrow-left" variant="subtle" size="sm">Kembali</flux:button>
            <flux:heading size="xl" level="1">Buat Postingan Baru</flux:heading>
        </div>
        
        <flux:separator variant="subtle" class="mb-6" />

        @if (session('success'))
            <div class="p-4 mb-6 rounded-lg bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        <livewire:create-post />
    </flux:main>
</x-layouts::app>
