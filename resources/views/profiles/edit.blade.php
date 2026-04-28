<x-layouts::app>
    <x-slot:title>
        Edit profil
    </x-slot:title>

    <flux:main>
        <flux:heading size="xl" level="1">Edit Profil</flux:heading>
        <flux:text class="mb-6">Perbarui informasi profil Anda di bawah ini.</flux:text>
        <flux:separator variant="subtle" class="mb-6" />

        <livewire:edit-profile />

    </flux:main>
</x-layouts::app>
