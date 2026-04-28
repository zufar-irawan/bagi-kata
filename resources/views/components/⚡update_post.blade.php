<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Posts;
use App\Models\Tags;

new class extends Component
{
    use WithFileUploads;

    public Posts $post;
    public $text_content = '';
    public $tagsInput = '';
    public $image;
    public $existing_image;

    protected function rules()
    {
        return [
            'text_content' => 'required|string|max:2000',
            'tagsInput'    => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ];
    }

    public function mount(Posts $post)
    {
        $this->post = $post;
        $this->text_content = $post->text_content;
        
        $tagsArray = [];
        if ($post->tags) {
            foreach ($post->tags as $tag) {
                $tagsArray[] = '#' . $tag->name;
            }
        }
        $this->tagsInput = implode(' ', $tagsArray);
        
        $this->existing_image = $post->image;
    }

    public function submit()
    {
        $this->validate();

        $this->post->text_content = $this->text_content;

        if ($this->image) {
            // Hapus gambar lama
            if ($this->existing_image && !str_starts_with($this->existing_image, 'http')) {
                Storage::disk('public')->delete($this->existing_image);
            }
            
            $imagePath = $this->image->store('posts/images', 'public');
            $this->post->image = $imagePath;
        }

        $this->post->save();

        $tagIds = [];
        if (trim($this->tagsInput) !== '') {
            $tagsArray = array_unique(array_filter(explode(' ', trim($this->tagsInput))));

            foreach ($tagsArray as $tagName) {
                $cleanTag = ltrim(trim(strtolower($tagName)), '#');
                if ($cleanTag !== '') {
                    $tagModel = Tags::firstOrCreate(['name' => $cleanTag]);
                    $tagIds[] = $tagModel->id;
                }
            }
        }
        $this->post->tags()->sync($tagIds);

        session()->flash('success', 'Postingan berhasil diperbarui!');
        return redirect('/post/' . $this->post->id);
    }
};
?>

<form wire:submit="submit" class="space-y-6">
    <flux:textarea wire:model="text_content" label="Apa yang sedang dipikirkan?" placeholder="Bagikan kata-katamu hari ini..." rows="5" />

    <flux:field>
        <flux:label>Gambar / Foto</flux:label>
        <div class="mt-2">
            <input type="file" wire:model="image" id="image" class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400" accept="image/*">
        </div>

        @if ($image)
            <div class="mt-4 rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 relative">
                <span class="absolute top-2 left-2 bg-blue-500 text-white text-xs font-semibold px-2 py-1 rounded">Gambar Baru</span>
                <img src="{{ $image->temporaryUrl() }}" class="max-h-64 w-full object-cover">
            </div>
        @elseif ($existing_image)
            <div class="mt-4 rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 relative">
                <span class="absolute top-2 left-2 bg-zinc-800/80 backdrop-blur-sm text-white text-xs font-semibold px-2 py-1 rounded">Gambar Saat Ini</span>
                <img src="{{ str_starts_with($existing_image, '/storage') || str_starts_with($existing_image, 'http') ? $existing_image : Storage::url($existing_image) }}" class="max-h-64 w-full object-cover">
            </div>
        @endif
        <div wire:loading wire:target="image" class="text-xs text-zinc-500 mt-2">Memuat pratinjau...</div>
        <flux:error name="image" />
    </flux:field>

    <flux:input wire:model="tagsInput" label="Tags" placeholder="Masukkan tag yang dipisahkan dengan spasi (misalnya: #tech #coding)" />

    <div class="flex items-center gap-4 pt-4">
        <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="submit">Simpan Perubahan</flux:button>
        <div wire:loading wire:target="submit" class="text-sm text-blue-500 font-medium">Menyimpan...</div>
    </div>
</form>