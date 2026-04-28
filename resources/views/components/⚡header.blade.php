<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    <flux:header class="lg:hidden min-w-screen py-4">
        <flux:sidebar.toggle class="lg:hidden scale-125 origin-left" icon="bars-2" inset="left" />
        
        <flux:spacer />

        @auth
            <flux:dropdown position="bottom" align="end">
                <flux:profile class="scale-110 origin-right" :chevron="false" avatar="{{ auth()->user()->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=2c97f0&color=fff' }}"/>

                <flux:menu class="space-y-1">
                    <form method="POST" action="/logout" x-ref="logoutHeaderForm" class="w-full">
                        @csrf
                        <flux:menu.item href="/me" icon="user" class="text-lg py-3">Profil</flux:menu.item>
                        <flux:menu.item x-on:click="$refs.logoutForm.submit()" icon="arrow-right-start-on-rectangle" class="text-lg py-3" x-on:click="$refs.logoutHeaderForm.submit()">Logout</flux:menu.item>
                    </form>
                </flux:menu>

            </flux:dropdown>
        @endauth
        
        @guest
            <div class="flex items-center gap-3">
                <flux:button href="/login" variant="primary" class="px-6 py-2 text-sm">Login</flux:button>
                <flux:button href="/register" variant="subtle" class="px-6 py-2 text-sm">Register</flux:button>
            </div>
        @endguest
        
    </flux:header>
</div>