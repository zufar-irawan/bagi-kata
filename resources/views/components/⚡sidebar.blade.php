<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    <flux:sidebar sticky collapsible class="min-h-screen bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.header>
            <flux:sidebar.brand
                href="/"    
                logo="{{ asset('img/logo.png') }}"
                name="Bagi Kata"
            />

            <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
        </flux:sidebar.header>

        <flux:sidebar.nav class="space-y-2">
            <flux:sidebar.item icon="home" href="/" class="text-lg py-3">Home</flux:sidebar.item>
            <flux:sidebar.item icon="pencil" href="/new" class="text-lg py-3">Tulis sesuatu</flux:sidebar.item>
            <flux:sidebar.item icon="star" href="/favorit" class="text-lg py-3">Favorit</flux:sidebar.item>
            <flux:sidebar.item icon="user" href="/me" class="text-lg py-3">Profil</flux:sidebar.item>
        </flux:sidebar.nav>

        <flux:sidebar.spacer />

        <flux:sidebar.nav class="space-y-2">
            <flux:dropdown position="top" align="start">
                <flux:sidebar.item icon="swatch" chevron class="text-lg py-3">Theme</flux:sidebar.item>

                <flux:menu x-data>
                    <flux:menu.radio.group x-model="$flux.appearance">
                        <flux:menu.radio value="light" icon="sun">Light</flux:menu.radio>
                        <flux:menu.radio value="dark" icon="moon">Dark</flux:menu.radio>
                        <flux:menu.radio value="system" icon="computer-desktop">System</flux:menu.radio>
                    </flux:menu.radio.group>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar.nav>

        @auth
            <flux:dropdown position="top" align="start" class="max-lg:hidden">
                <flux:sidebar.profile avatar="{{ auth()->user()->photo_profile ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=2c97f0&color=fff' }}" name="{{ auth()->user()->name }}"/>
                <flux:menu>
                    <form method="POST" action="/logout" x-ref="logoutForm" class="w-full">
                        @csrf
                        <flux:menu.item icon="arrow-right-start-on-rectangle" x-on:click="$refs.logoutForm.submit()">Logout</flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        @endauth

        @guest
            <div class="flex flex-col gap-3 pb-4 max-lg:hidden">
                <flux:button href="/login" variant="primary" class="w-full justify-center">Login</flux:button>
                <flux:button href="/register" variant="subtle" class="w-full justify-center">Register</flux:button>
            </div>
        @endguest
    </flux:sidebar>


</div>