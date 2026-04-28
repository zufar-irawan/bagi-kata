<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Likes;
use App\Models\Favorites;

new class extends Component
{
    public $post;
    public $size = 'sm';
    public $likesCount = 0;
    public $isLiked = false;
    public $isFavorited = false;

    public function mount($post, $size = 'sm')
    {
        $this->post = $post;
        $this->size = $size;
        $this->likesCount = $post->likes()->count();
        
        // cek jika user sudah menyukai atau favoritkan postingan
        if (Auth::check()) {
            $this->isLiked = $post->likes()->where('user_id', Auth::id())->exists();
            $this->isFavorited = $post->favorites()->where('user_id', Auth::id())->exists();
        }
    }

    public function toggleLike()
    {
        if (!Auth::check()) return;

        if ($this->isLiked) {
            $this->post->likes()->where('user_id', Auth::id())->delete();
            $this->isLiked = false;
            $this->likesCount--;
        } else {
            $this->post->likes()->create(['user_id' => Auth::id()]);
            $this->isLiked = true;
            $this->likesCount++;
        }
    }

    public function toggleFavorite()
    {
        if (!Auth::check()) return;

        if ($this->isFavorited) {
            $this->post->favorites()->where('user_id', Auth::id())->delete();
            $this->isFavorited = false;
        } else {
            $this->post->favorites()->create(['user_id' => Auth::id()]);
            $this->isFavorited = true;
        }
    }

    public function triggerReply()
    {
        $this->dispatch('toggle-reply', postId: $this->post->id);
    }
};
?>

@php
    $iconClass = $size === 'lg' ? 'w-6 h-6' : 'w-5 h-5';
    $textClass = $size === 'lg' ? 'text-base font-medium' : 'text-sm font-medium';
@endphp

<div class="mt-4 flex items-center gap-6 text-zinc-500 dark:text-zinc-400 relative z-10 w-full">
    <div class="flex items-center gap-2 group cursor-pointer hover:text-blue-500 transition">
        <x-flux::icon.chart-bar class="{{ $iconClass }}" />
        <span class="{{ $textClass }}">{{ $post->views ?? 0 }}</span>
    </div>

    <button wire:click="triggerReply" class="flex items-center gap-2 group cursor-pointer hover:text-emerald-500 transition outline-none">
        <x-flux::icon.chat-bubble-left class="{{ $iconClass }}" />
        <span class="{{ $textClass }}">{{ $post->replies()->count() ?? 0 }}</span>
    </button>

    <button wire:click="toggleLike" class="flex items-center gap-2 group cursor-pointer {{ $isLiked ? 'text-rose-500' : 'hover:text-rose-500' }} transition outline-none">
        <x-flux::icon.heart class="{{ $iconClass }} {{ $isLiked ? 'fill-current' : '' }}" variant="{{ $isLiked ? 'solid' : 'outline' }}" />
        <span class="{{ $textClass }}">{{ $likesCount }}</span>
    </button>

    <button wire:click="toggleFavorite" class="flex items-center group cursor-pointer ml-auto {{ $isFavorited ? 'text-amber-500' : 'hover:text-amber-500' }} transition outline-none">
        <x-flux::icon.bookmark class="{{ $iconClass }} {{ $isFavorited ? 'fill-current' : '' }}" variant="{{ $isFavorited ? 'solid' : 'outline' }}" />
    </button>
</div>
