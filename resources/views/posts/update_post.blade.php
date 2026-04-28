<x-layouts::app>
    <x-slot:title>
        Edit postingan
    </x-slot:title>

    <flux:main>
        <div class="mb-6 flex items-center gap-4">
            <flux:button href="/post/{{ $post->id }}" icon="arrow-left" variant="subtle" size="sm">Kembali</flux:button>
            <flux:heading size="xl" level="1">Update Post</flux:heading>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 max-w-2xl">
            <livewire:update_post :post="$post" />
        </div>
    </flux:main>
</x-layouts::app>
