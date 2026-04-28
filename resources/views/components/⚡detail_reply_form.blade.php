<?php

use Livewire\Component;
use App\Models\Posts;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $post;
    public $replyText = '';

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

        $this->replyText = '';

        session()->flash('success', 'Komentar berhasil ditambahkan!');
        
        $this->redirect('/post/' . $this->post->id, navigate: true);
    }
};
?>

<form wire:submit="submitReply" class="mt-6 mb-8 relative z-10 w-full">
    <div class="flex gap-4">
        @if (Auth::user()->photo_profile)
            <img src="{{ Auth::user()->photo_profile }}" class="w-10 h-10 rounded-full object-cover shrink-0">
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2c97f0&color=fff" class="w-10 h-10 rounded-full shrink-0">
        @endif
        <div class="flex-1">
            <flux:textarea wire:model="replyText" rows="3" placeholder="Tambahkan komentar atau balasan Anda..." class="text-sm w-full bg-white dark:bg-zinc-900" />

            <div wire:loading wire:target="submitReply" class="text-xs text-blue-500 mt-2 font-medium">
                Mengirim Komentar...
            </div>
            
            <div class="flex justify-end gap-2 mt-3">
                <flux:button size="sm" variant="primary" type="submit" wire:loading.attr="disabled" wire:target="submitReply">Kirim Komentar</flux:button>
            </div>
        </div>
    </div>
</form>
