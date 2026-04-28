<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Posts;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $post;
    public $replyText = '';
    public $showReplyForm = false;

    public function toggleReplyForm()
    {
        $this->showReplyForm = !$this->showReplyForm;
        $this->replyText = '';
    }

    public function handleToggleReply($postId)
    {
        if ($this->post->id === $postId) {
            $this->toggleReplyForm();
        }
    }

    public function submitReply()
    {
        $this->validate([
            'replyText' => 'required|string|max:1000'
        ]);

        $newPost = new \App\Models\Posts();
        $newPost->user_id = Auth::id();
        $newPost->text_content = $this->replyText;
        
        $newPost->parent_id = $this->post->id;
        $newPost->thread_id = $this->post->thread_id ?? $this->post->id;

        $newPost->save();

        $this->showReplyForm = false;
        $this->replyText = '';

        session()->flash('success', 'Balasan berhasil dikirim!');
        
        $this->redirect(request()->header('Referer') ?? '/', navigate: true);
    }
};
?>

<div class="block py-6 px-2 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
    <div class="flex justify-between items-center mb-3">
        <a href="/profile/{{ $post->user_id }}" class="flex items-center gap-3 hover:opacity-80 transition">
            @if (optional($post->user)->photo_profile)
                <img src="{{ $post->user->photo_profile }}" class="w-10 h-10 rounded-full object-cover shrink-0" alt="{{ optional($post->user)->name }}">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode(optional($post->user)->name ?? 'User') }}&background=2c97f0&color=fff" class="w-10 h-10 rounded-full shrink-0" alt="{{ optional($post->user)->name ?? 'User' }}">
            @endif
            <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ optional($post->user)->name ?? 'Pengguna Tidak Dikenal' }}</span>
        </a>
        <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $post->created_at->diffForHumans() }}</span>
    </div>

    <a href="/post/{{ $post->id }}" class="block mb-2 hover:opacity-90 transition">
        <p class="text-base text-zinc-800 dark:text-zinc-200">
            {{ Str::words($post->text_content, 100, '...') }}
        </p>

        @if ($post->parent_id)
            <div class="mt-4 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                @if ($post->parent && !$post->parent->trashed())
                    <div class="flex items-center gap-2 mb-2">
                        <a href="/profile/{{ $post->parent->user_id }}" class="font-medium text-sm text-zinc-900 dark:text-zinc-100 hover:underline">{{ optional($post->parent->user)->name ?? 'Seseorang' }}</a>
                        <span class="text-xs text-zinc-500">{{ $post->parent->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        {{ Str::words($post->parent->text_content, 20, '...') }}
                    </p>
                @else
                    <div class="flex items-center gap-2 text-zinc-500">
                        <x-flux::icon.exclamation-circle class="w-4 h-4" />
                        <span class="text-sm italic">Postingan tidak tersedia atau telah dihapus.</span>
                    </div>
                @endif
            </div>
        @endif

        @if ($post->image)
            <div class="mt-4">
                <img src="{{ str_starts_with($post->image, '/storage') || str_starts_with($post->image, 'http') ? $post->image : Storage::url($post->image) }}" alt="Post Image" class="w-full max-h-96 object-cover rounded-xl border border-zinc-200 dark:border-zinc-700">
            </div>
        @endif
    </a>

    @if ($post->tags && $post->tags->isNotEmpty())
        <div class="mt-2 mb-4 flex flex-wrap gap-2 relative z-10">
            @foreach ($post->tags as $tag)
                <span class="text-blue-500 dark:text-blue-400 font-medium hover:underline text-sm cursor-pointer">#{{ $tag->name }}</span>
            @endforeach
        </div>
    @endif

    <livewire:post_interaction :post="$post" :key="'interaction-'.$post->id" />

    <!-- Form Komentar/Balasan -->
    @if ($showReplyForm)
        <form wire:submit="submitReply" class="mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-800 relative z-10">
            <div class="flex gap-3">
                @if (Auth::user()->photo_profile)
                    <img src="{{ Auth::user()->photo_profile }}" class="w-8 h-8 rounded-full object-cover shrink-0">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2c97f0&color=fff" class="w-8 h-8 rounded-full shrink-0">
                @endif
                <div class="flex-1">
                    <flux:textarea wire:model="replyText" rows="2" placeholder="Tulis balasanmu..." class="text-sm w-full" />
    
                    <div wire:loading wire:target="submitReply" class="text-xs text-zinc-500 mt-2">
                        Mengirim balasan...
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-3">
                <flux:button size="sm" variant="subtle" wire:click="toggleReplyForm">Batal</flux:button>
                <flux:button size="sm" variant="primary" type="submit" wire:loading.attr="disabled" wire:target="submitReply">Balas</flux:button>
            </div>
        </form>
    @endif
</div>