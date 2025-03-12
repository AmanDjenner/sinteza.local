<div>
    <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Manager Deținuți</h1>

    <div class="mb-4">
        @can('create detinuti')
            <button wire:click="$set('showModal', true)" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Adaugă înregistrare
            </button>
        @endcan
    </div>

    <div class="flex justify-center">
        <table class="w-[80%] bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Data</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Instituție</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Total</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Deținuți reali</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">În căutare</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Detenție preventivă</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Condiții inițiale</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Pe viață</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Femei</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Minori</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Sector deschis</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Fără escortă</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Brățări monitorizare</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Grevă foame</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Izolator disciplinar</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Internați spitale</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Angajați IP spitale</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Angajați DDS spitale</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Muncă exterior</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Angajați IP exterior</th>
                    <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($detinuti as $detinut)
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->data ? $detinut->data->format('d-m-Y') : '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->institution->name ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->total ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->real_inmates ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->in_search ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->pretrial_detention ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->initial_conditions ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->life ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->female ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->minors ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->open_sector ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->no_escort ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->monitoring_bracelets ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->hunger_strike ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->disciplinary_insulator ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->admitted_to_hospitals ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->employed_ip_in_hospitals ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->employed_dds_in_hospitals ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->work_outside ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $detinut->employed_ip_work_outside ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700">
                            @can('edit detinuti')
                                <button wire:click="editDetinut({{ $detinut->id }})" 
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded">Editează</button>
                            @endcan
                            @can('delete detinuti')
                                <button wire:click="deleteDetinut({{ $detinut->id }})" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">Șterge</button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="21" class="py-2 px-4 text-center text-gray-900 dark:text-white">Nicio înregistrare găsită.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center" wire:ignore.self>
            <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg w-1/2 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-700">
                <h2 class="text-xl mb-4">{{ $editingDetinutId ? 'Editează înregistrare' : 'Crează înregistrare' }}</h2>
                <form wire:submit.prevent="{{ $editingDetinutId ? 'updateDetinut' : 'createDetinut' }}">
                    <div class="mb-4">
                        <label class="block mb-1">Data</label>
                        <input type="date" wire:model="data" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('data') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Instituție</label>
                        <select wire:model="id_institution" 
                                class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Selectează o instituție</option>
                            @foreach ($institutions as $institution)
                                <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                            @endforeach
                        </select>
                        @error('id_institution') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Total</label>
                        <input type="number" wire:model="total" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('total') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Deținuți reali</label>
                        <input type="number" wire:model="real_inmates" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('real_inmates') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">În căutare</label>
                        <input type="number" wire:model="in_search" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('in_search') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Detenție preventivă</label>
                        <input type="number" wire:model="pretrial_detention" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('pretrial_detention') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Condiții inițiale</label>
                        <input type="number" wire:model="initial_conditions" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('initial_conditions') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Pe viață</label>
                        <input type="number" wire:model="life" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('life') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Femei</label>
                        <input type="number" wire:model="female" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('female') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Minori</label>
                        <input type="number" wire:model="minors" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('minors') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Sector deschis</label>
                        <input type="number" wire:model="open_sector" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('open_sector') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Fără escortă</label>
                        <input type="number" wire:model="no_escort" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('no_escort') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Brățări monitorizare</label>
                        <input type="number" wire:model="monitoring_bracelets" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('monitoring_bracelets') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Grevă foame</label>
                        <input type="number" wire:model="hunger_strike" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('hunger_strike') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Izolator disciplinar</label>
                        <input type="number" wire:model="disciplinary_insulator" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('disciplinary_insulator') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Internați spitale</label>
                        <input type="number" wire:model="admitted_to_hospitals" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('admitted_to_hospitals') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Angajați IP spitale</label>
                        <input type="number" wire:model="employed_ip_in_hospitals" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('employed_ip_in_hospitals') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Angajați DDS spitale</label>
                        <input type="number" wire:model="employed_dds_in_hospitals" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('employed_dds_in_hospitals') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Muncă exterior</label>
                        <input type="number" wire:model="work_outside" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('work_outside') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Angajați IP exterior</label>
                       .pprint<input type="number" wire:model="employed_ip_work_outside" min="0" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('employed_ip_work_outside') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="button" wire:click="resetForm" 
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded mr-2">Anulează</button>
                        <button type="submit" 
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                            {{ $editingDetinutId ? 'Actualizează' : 'Crează' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>