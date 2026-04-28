<?php

use Livewire\Component;
use App\Models\Posts;
use App\Models\Tags;
use Illuminate\Support\Str;

new class extends Component
{
    public $search = '';

    public function setSearch($tag)
    {
        $this->search = '#' . $tag;
    }

    public function with()
    {
        $query = Posts::query();
        
        $searchTerm = trim($this->search);
        
        if ($searchTerm !== '') {
            if (Str::startsWith($searchTerm, '#')) {
                // Cari berdasarkan Tag jika diawali '#'
                $tagName = ltrim($searchTerm, '#');
                $query->whereHas('tags', function($q) use ($tagName) {
                    $q->where('name', 'like', '%' . $tagName . '%');
                });
            } else {
                // Cari berdasarkan text_content atau Nama Pengguna
                $query->where(function($q) use ($searchTerm) {
                    $q->where('text_content', 'like', '%' . $searchTerm . '%')
                      ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                          $userQuery->where('name', 'like', '%' . $searchTerm . '%');
                      });
                });
            }
        } else {
            // Jika tidak mencari, tampilkan postingan terbaru
            $query->whereNull('parent_id');
        }

        return [
            'posts' => $query->latest()->get(),
            'popularTags' => Tags::withCount('posts')->orderByDesc('posts_count')->take(12)->get()
        ];
    }
};
?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <div>
            <flux:heading size="xl" level="1">Halo, {{ auth()->check() ? \Illuminate\Support\Str::before(auth()->user()->name, ' ') : 'Tamu' }}</flux:heading>
            <flux:text class="mt-2 mb-6 text-base">Postingan yang lagi hangat hari ini</flux:text>
        </div>
        
        <div class="w-full relative">
            <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="Cari postingan, #tag, atau pengguna..." class="w-full" />
            <div wire:loading wire:target="search" class="absolute right-3 top-2.5">
                <x-flux::icon.arrow-path class="w-5 h-5 text-zinc-400 animate-spin" />
            </div>
        </div>

        <flux:separator variant="subtle" />

        <div class="flex flex-col border border-zinc-100 dark:border-zinc-800 rounded-xl overflow-hidden bg-white dark:bg-zinc-900/40">
            @forelse ($posts as $post)
                <livewire:post_card :post="$post" :key="'home-post-'.$post->id" />
            @empty
                <div class="py-12 text-center text-zinc-500">
                    <x-flux::icon.magnifying-glass class="w-12 h-12 mx-auto mb-3 opacity-20" />
                    Tidak ada postingan atau tag yang ditemukan.
                </div>
            @endforelse
        </div>
    </div>

    <div class="lg:col-span-1 hidden lg:block">
        <div class="sticky top-8">
            <flux:heading size="lg" class="mb-4">Tag popular belakangan ini</flux:heading>
            
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5">
                @if ($popularTags->isEmpty())
                    <p class="text-sm text-zinc-500">Belum ada tag yang tersedia.</p>
                @else
                    <div class="flex flex-wrap gap-2">
                        @foreach ($popularTags as $tag)
                            <button wire:click="setSearch('{{ $tag->name }}')" class="inline-flex items-center px-3 py-1.5 bg-zinc-100 hover:bg-blue-50 dark:bg-zinc-800 dark:hover:bg-blue-900/30 text-zinc-700 hover:text-blue-600 dark:text-zinc-300 dark:hover:text-blue-400 rounded-lg text-sm font-medium transition cursor-pointer">
                                #{{ $tag->name }}
                                @if($tag->posts_count > 0)
                                    <span class="text-xs text-zinc-400 dark:text-zinc-500 ml-1.5">{{ $tag->posts_count }}</span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
