<div>
    <div class="border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
            <li class="me-2">
                <flux:button wire:click="setTab('users')" 
                             class="inline-flex items-center justify-center p-4 border-b-2 {{ $activeTab === 'users' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }} rounded-t-lg group"
                             icon="users"
                             variant="ghost">
                    Utilizatori
                </flux:button>
            </li>
            <li class="me-2">
                <flux:button wire:click="setTab('roles')" 
                             class="inline-flex items-center justify-center p-4 border-b-2 {{ $activeTab === 'roles' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }} rounded-t-lg group"
                             icon="shield-check"
                             variant="ghost">
                    Roluri
                </flux:button>
            </li>
            <li class="me-2">
                <flux:button wire:click="setTab('permissions')" 
                             class="inline-flex items-center justify-center p-4 border-b-2 {{ $activeTab === 'permissions' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }} rounded-t-lg group"
                             icon="lock-closed"
                             variant="ghost">
                    Permisiuni
                </flux:button>
            </li>
            <li class="me-2">
                <flux:button wire:click="setTab('institutions')" 
                             class="inline-flex items-center justify-center p-4 border-b-2 {{ $activeTab === 'institutions' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }} rounded-t-lg group"
                             icon="building-office"
                             variant="ghost">
                    Instituții
                </flux:button>
            </li>
            <li class="me-2">
                <flux:button wire:click="setTab('event-categories')" 
                             class="inline-flex items-center justify-center p-4 border-b-2 {{ $activeTab === 'event-categories' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }} rounded-t-lg group"
                             icon="tag"
                             variant="ghost">
                    Categorii Evenimente
                </flux:button>
            </li>
            <li class="me-2">
                <flux:button wire:click="setTab('injury-categories')" 
                             class="inline-flex items-center justify-center p-4 border-b-2 {{ $activeTab === 'injury-categories' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }} rounded-t-lg group"
                             icon="heart"
                             variant="ghost">
                    Categorii Leziuni
                </flux:button>
            </li>
            <li class="me-2">
                <flux:button wire:click="setTab('object-list')" 
                             class="inline-flex items-center justify-center p-4 border-b-2 {{ $activeTab === 'object-list' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }} rounded-t-lg group"
                             icon="cube"
                             variant="ghost">
                    Lista Obiecte interzise
                </flux:button>
            </li>
        </ul>
    </div>

    <!-- Conținutul tab-urilor -->
    <div class="mt-4">
        @if ($activeTab === 'users')
            <livewire:user-manager />
        @elseif ($activeTab === 'roles')
            <livewire:role-manager />
        @elseif ($activeTab === 'permissions')
            <livewire:permission-manager />
        @elseif ($activeTab === 'institutions')
            <livewire:institution-manager />
        @elseif ($activeTab === 'event-categories')
            <livewire:event-category-manager />
        @elseif ($activeTab === 'injury-categories')
            <livewire:injury-category-manager />
        @elseif ($activeTab === 'object-list')
            <livewire:object-list-manager />
        @endif
    </div>
</div>