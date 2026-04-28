<x-layouts::app>
    <x-slot:title>
        Postingan dari {{ $post->user->name }}
    </x-slot:title>

    <flux:main>
        <div class="mb-6 flex items-center gap-4">
            <flux:button href="{{ url()->previous() }}" icon="arrow-left" variant="subtle" size="sm">Kembali</flux:button>
            <flux:heading size="xl" level="1">Post</flux:heading>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl relative">
                    
                    <div class="flex justify-between items-start mb-6">
                        <a href="/profile/{{ $post->user_id }}" class="flex items-center gap-3 hover:opacity-80 transition">
                            @if (optional($post->user)->photo_profile)
                                <img src="{{ $post->user->photo_profile }}" class="w-12 h-12 rounded-full object-cover shrink-0" alt="{{ optional($post->user)->name }}">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(optional($post->user)->name ?? 'User') }}&background=2c97f0&color=fff" class="w-12 h-12 rounded-full shrink-0" alt="{{ optional($post->user)->name ?? 'User' }}">
                            @endif
                            <div>
                                <h2 class="font-semibold text-lg text-zinc-900 dark:text-zinc-100 hover:underline">{{ optional($post->user)->name ?? 'Pengguna Tidak Dikenal' }}</h2>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $post->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </a>

                        
                        @if(auth()->check() && auth()->id() === $post->user_id)
                            <div class="flex gap-2">
                                <flux:button href="/post/{{ $post->id }}/update" size="xs" variant="subtle" icon="pencil">Edit</flux:button>
                                <form action="/post/{{ $post->id }}" method="POST" onsubmit="return confirm('Yakin hapus post ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button type="submit" size="xs" variant="danger" icon="trash">Hapus</flux:button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div class="text-lg text-zinc-800 dark:text-zinc-200 mb-4 whitespace-pre-wrap">{{ $post->text_content }}</div>

                    @if ($post->tags && $post->tags->isNotEmpty())
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach ($post->tags as $tag)
                                <span class="text-blue-500 dark:text-blue-400 font-medium hover:underline text-sm cursor-pointer">#{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if ($post->image)
                        <div class="mb-6">
                            <img src="{{ str_starts_with($post->image, '/storage') || str_starts_with($post->image, 'http') ? $post->image : Storage::url($post->image) }}" alt="Post Image" class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700">
                        </div>
                    @endif

                    <flux:separator variant="subtle" class="mb-4" />

                    <livewire:post_interaction :post="$post" size="lg" :key="'interaction-detail-'.$post->id" />
                </div>

                <div class="mt-8 border-t-4 border-zinc-100 dark:border-zinc-900 pt-6">
                    
                    @if (session('success'))
                        <div class="p-4 mb-6 rounded-lg bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-400 font-medium">
                            {{ session('success') }}
                        </div>
                    @endif

                    <livewire:detail_reply_form :post="$post" />

                    <div class="flex items-center gap-2 mb-6">
                        <flux:heading size="lg">Balasan</flux:heading>
                        <span class="bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 py-0.5 px-2 rounded-full text-xs font-bold">{{ $replies->count() }}</span>
                    </div>
                    
                    @if ($replies->isEmpty())
                        <div class="py-12 text-center text-zinc-500">
                            <x-flux::icon.chat-bubble-left-ellipsis class="w-12 h-12 mx-auto mb-3 opacity-20" />
                            Belum ada balasan. Silakan merespon melalui halaman beranda!
                        </div>
                    @else
                        <div class="flex flex-col border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden bg-white dark:bg-zinc-900/50">
                            @foreach ($replies as $reply)
                                <livewire:post_card :post="$reply" :key="'reply-'.$reply->id" />
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="lg:col-span-1 hidden lg:block">
                <div class="sticky top-8">
                    <flux:heading size="lg" class="mb-4">Baru Saja</flux:heading>
                    
                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden">
                        @forelse ($recentPosts as $idx => $recent)
                            <div class="block p-4 border-b border-zinc-100 dark:border-zinc-800 last:border-0 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                                <div class="flex items-center gap-2 mb-2">
                                    <a href="/profile/{{ $recent->user_id }}" class="flex items-center gap-2 hover:opacity-80 transition">
                                        @if (optional($recent->user)->photo_profile)
                                            <img src="{{ $recent->user->photo_profile }}" class="w-6 h-6 rounded-full object-cover shrink-0">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode(optional($recent->user)->name ?? 'User') }}&background=2c97f0&color=fff" class="w-6 h-6 rounded-full shrink-0">
                                        @endif
                                        <span class="font-medium text-sm text-zinc-900 dark:text-zinc-100 hover:underline">{{ optional($recent->user)->name ?? 'User' }}</span>
                                    </a>
                                    <span class="text-xs text-zinc-500 ml-auto">{{ $recent->created_at->diffForHumans(null, true, true) }}</span>
                                </div>
                                <a href="/post/{{ $recent->id }}" class="block mt-1">
                                    <p class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ \Illuminate\Support\Str::words($recent->text_content, 12, '...') }}
                                    </p>
                                </a>
                            </div>
                        @empty
                            <div class="p-4 text-sm text-zinc-500 text-center">Belum ada postingan lain.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </flux:main>
</x-layouts::app>
