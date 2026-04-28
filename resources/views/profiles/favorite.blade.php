<x-layouts::app>
    <x-slot:title>
        Favorit kamu
    </x-slot:title>

    <flux:main class="max-w-[120dvh]">
        <div class="mb-6 flex items-center gap-4">
            <flux:heading size="xl" level="1">Kata-kata favorit kamu</flux:heading>
        </div>

        <flux:separator variant="subtle" class="mb-4" />

        <div class="flex flex-col">
            @forelse ($posts as $post)
                <livewire:post_card :post="$post" :key="'favorite-post-'.$post->id" />
                
                @if (!$loop->last)
                    <flux:separator variant="subtle" />
                @endif
            @empty
                <div class="py-12 flex flex-col items-center justify-center text-zinc-500">
                    <x-flux::icon.star class="w-12 h-12 mb-3 mx-auto opacity-20" />
                    <flux:text class="text-lg">Belum ada postingan favorit.</flux:text>
                    <flux:text class="text-sm mt-2">Masih kosong nih. Mulai beri bintang pada postingan yang kamu suka!</flux:text>
                </div>
            @endforelse
        </div>
    </flux:main>
</x-layouts::app>