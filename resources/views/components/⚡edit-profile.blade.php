<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

new class extends Component
{
    use WithFileUploads;

    public $name = '';
    public $bio = '';
    public $photo_profile;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->bio = $user->bio;
    }

    public function editUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = Auth::user();
        $user->name = $this->name;
        $user->bio = $this->bio;

        if ($this->photo_profile) {
            $path = $this->photo_profile->store('profiles', 'public');
            $user->photo_profile = Storage::url($path);
        }

        $user->save();

        return redirect('/me');
    }
};
?>

<form wire:submit="editUser" class="space-y-6 max-w-2xl">
    <div class="flex flex-col gap-3">
        <flux:label>Foto Profil</flux:label>
        <div class="flex items-center gap-5">
            <label for="photoProfile" class="cursor-pointer relative group block w-24 h-24 rounded-full overflow-hidden border-2 border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 shrink-0">
                @if ($photo_profile)
                    <img src="{{ $photo_profile->temporaryUrl() }}" class="w-full h-full object-cover">
                @elseif (auth()->user()->photo_profile)
                    <img src="{{ auth()->user()->photo_profile }}" class="w-full h-full object-cover">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2c97f0&color=fff" class="w-full h-full object-cover">
                @endif
                <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="text-white text-xs font-semibold">Ubah Foto</span>
                </div>
            </label>
            <div class="flex flex-col gap-2 items-start shrink-0">
                <flux:button size="sm" onclick="document.getElementById('photoProfile').click()" type="button">Ganti Foto</flux:button>
                <div wire:loading wire:target="photo_profile" class="text-xs text-zinc-500">Memuat pratinjau...</div>
                <input type="file" id="photoProfile" wire:model="photo_profile" class="hidden" accept="image/png, image/jpeg, image/jpg, image/webp">
            </div>
        </div>
        <flux:error name="photo_profile" />
    </div>

    <flux:input wire:model="name" name="name" label="Nama Lengkap" placeholder="Masukkan nama Anda" />

    <flux:textarea wire:model="bio" name="bio" label="Bio" placeholder="Ceritakan sedikit tentang diri Anda..." rows="4" />

    <div class="flex items-center gap-4">
        <flux:button type="submit" variant="primary">Simpan Perubahan</flux:button>
        <flux:button href="/me" variant="subtle">Batal</flux:button>
    </div>
</form>