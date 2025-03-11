<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <!-- Eliminăm Summernote CSS -->
        <style>
            /* Eliminăm stilurile legate de Summernote, deoarece nu mai sunt necesare */
        </style>
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <div class="flex min-h-screen">
            <flux:sidebar sticky stashable class="w-64 border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
                <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                    <x-app-logo />
                </a>
                <flux:navlist variant="outline">
                    <flux:navlist.group heading="Platform" class="grid">
                        <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    </flux:navlist.group>
                    <flux:navlist.group heading="Administrare" class="grid">
                        <flux:navlist.item icon="users" :href="url('/admin/manager')" :current="request()->query('tab') === 'users' || !request()->has('tab')" wire:navigate>{{ __('Utilizatori') }}</flux:navlist.item>
                        <flux:navlist.item icon="shield-check" :href="url('/admin/manager') . '?tab=roles'" :current="request()->query('tab') === 'roles'" wire:navigate>{{ __('Roluri') }}</flux:navlist.item>
                        <flux:navlist.item icon="lock-closed" :href="url('/admin/manager') . '?tab=permissions'" :current="request()->query('tab') === 'permissions'" wire:navigate>{{ __('Permisiuni') }}</flux:navlist.item>
                        <flux:navlist.item icon="building-office" :href="url('/admin/manager') . '?tab=institutions'" :current="request()->query('tab') === 'institutions'" wire:navigate>{{ __('Instituții') }}</flux:navlist.item>
                        <flux:navlist.item icon="tag" :href="url('/admin/manager') . '?tab=event-categories'" :current="request()->query('tab') === 'event-categories'" wire:navigate>{{ __('Categorii Evenimente') }}</flux:navlist.item>
                        <flux:navlist.item icon="heart" :href="url('/admin/manager') . '?tab=injury-categories'" :current="request()->query('tab') === 'injury-categories'" wire:navigate>{{ __('Categorii Leziuni') }}</flux:navlist.item>
                        <flux:navlist.item icon="exclamation-circle" :href="url('/admin/manager') . '?tab=injuries'" :current="request()->query('tab') === 'injuries'" wire:navigate>{{ __('Leziuni') }}</flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>
                <flux:spacer />
                <flux:navlist variant="outline">
                    <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                        {{ __('Repository') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits" target="_blank">
                        {{ __('Documentation') }}
                    </flux:navlist.item>
                </flux:navlist>
                <flux:dropdown position="bottom" align="start">
                    <flux:profile
                        :name="auth()->user()->name"
                        :initials="auth()->user()->initials()"
                        icon-trailing="chevrons-up-down"
                    />
                    <flux:menu class="w-[220px]">
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>
                                    <div class="grid flex-1 text-left text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>
                        <flux:menu.separator />
                        <flux:menu.radio.group>
                            <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                        </flux:menu.radio.group>
                        <flux:menu.separator />
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </flux:sidebar>

            <div class="flex-1 p-6 overflow-y-auto">
                {{ $slot }}
            </div>
        </div>

        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <flux:spacer />
            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />
                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>
                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>
                    <flux:menu.separator />
                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Settings</flux:menu.item>
                    </flux:menu.radio.group>
                    <flux:menu.separator />
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Eliminăm Summernote JS -->

        @livewireScripts
        @stack('scripts')
        @fluxScripts
    </body>
</html>