<x-layouts::app>
    <x-slot:title>
        Profil Kamu
    </x-slot:title>

    <flux:main>
        <div class="flex items-start justify-between mb-6">
            <div class="flex items-start gap-4">
                @if ($user->photo_profile)
                    <img src="{{ $user->photo_profile }}" class="w-16 h-16 rounded-full object-cover shrink-0" alt="Avatar">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2c97f0&color=fff" class="w-16 h-16 rounded-full shrink-0" alt="Avatar">
                @endif
                
                <div class="pt-1">
                    <flux:heading size="xl" level="1">{{ $user->name }}</flux:heading>
                    <flux:text class="mt-1">Profil Pengguna</flux:text>
                </div>
            </div>
            
            <div class="flex items-center gap-2 shrink-0">
                <flux:button href="/me/edit" icon="pencil">Edit Profil</flux:button>
                <flux:button href="/new" variant="primary" icon="pencil-square">Tambah Post</flux:button>
            </div>
        </div>

        @if ($user->bio)
            <div class="mb-8">
                <flux:text class="text-base whitespace-pre-wrap">{{ $user->bio }}</flux:text>
            </div>
        @endif

        <flux:heading size="lg" class="mb-4">Postingan Anda</flux:heading>
        <flux:separator variant="subtle" />

        <div class="flex flex-col">
            @forelse ($posts as $post)
                <livewire:post_card :post="$post" :key="'me-post-'.$post->id" />
                
                @if (!$loop->last)
                    <flux:separator variant="subtle" />
                @endif
            @empty
                <div class="py-12 flex flex-col items-center justify-center text-zinc-500">
                    <flux:text class="text-lg">Belum ada postingan.</flux:text>
                    <flux:text class="text-sm mt-2">Mulai bagikan kata-katamu hari ini!</flux:text>
                </div>
            @endforelse
        </div>
    </flux:main>
</x-layouts::app>
