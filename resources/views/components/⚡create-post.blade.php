<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Posts;
use App\Models\Tags;

new class extends Component
{
    use WithFileUploads;

    public $text_content = '';
    public $tagsInput = '';
    public $image;
    public $file;

    protected $rules = [
        'text_content' => 'required|string|max:2000',
        'tagsInput'    => 'nullable|string',
        'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
    ];

    public function submit()
    {
        $this->validate();

        $post = new Posts();
        $post->user_id = Auth::id();
        $post->text_content = $this->text_content;

        if ($this->image) {
            $imagePath = $this->image->store('posts/images', 'public');
            $post->image = $imagePath;
        }

        $post->save();

        if (trim($this->tagsInput) !== '') {
            $tagsArray = array_unique(array_filter(explode(' ', trim($this->tagsInput))));
            $tagIds = [];

            foreach ($tagsArray as $tagName) {
                // Menghilangkan spasi, merubah ke huruf kecil, lalu menghapus tanda pagar (#)
                $cleanTag = ltrim(trim(strtolower($tagName)), '#');
                
                if ($cleanTag !== '') {
                    $tagModel = Tags::firstOrCreate(['name' => $cleanTag]);
                    $tagIds[] = $tagModel->id;
                }
            }

            // Sync untuk menempelkan tag_id dengan post_id pada table post_tag
            $post->tags()->sync($tagIds);
        }

        session()->flash('success', 'Postingan baru berhasil dibagikan!');
        return redirect('/');
    }
};
?>

<form wire:submit="submit" class="space-y-6 max-w-2xl">
    <flux:textarea wire:model="text_content" label="Apa yang sedang dipikirkan?" placeholder="Bagikan kata-katamu hari ini..." rows="5" />

    <flux:field>
        <flux:label>Gambar / Foto</flux:label>
        <div class="mt-2">
            <input type="file" wire:model="image" id="image" class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400" accept="image/*">
        </div>

        @if ($image)
            <div class="mt-4 rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                <img src="{{ $image->temporaryUrl() }}" class="max-h-64 w-full object-cover">
            </div>
        @endif

        <div wire:loading wire:target="image" class="text-xs text-zinc-500 mt-2">Memuat pratinjau...</div>
        <flux:error name="image" />
    </flux:field>

    <flux:input wire:model="tagsInput" label="Tags" placeholder="Masukkan tag yang dipisahkan dengan spasi (misalnya: #tech #coding)" />

    <div class="flex items-center gap-4 pt-4">
        <flux:button type="submit" variant="primary">Submit</flux:button>
    </div>
</form>