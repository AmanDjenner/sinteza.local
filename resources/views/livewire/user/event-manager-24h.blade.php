@can('view events 24h')
@push('styles')
    <style>
        .square-tabs {
            border-radius: 0 !important; /* Forțează colțuri pătrate */
        }
    </style>
@endpush
<div>
    <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">
        Manager Evenimente 24 H - {{ Auth::user()->institution ? Auth::user()->institution->name : 'N/A' }}
    </h1>

    @if (session()->has('message'))
        <div class="mb-4 text-green-500">{{ session('message') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 text-red-500">{{ session('error') }}</div>
    @endif

    <div class="border-b border-gray-200 dark:border-zinc-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
        <li class="me-2" >
    <flux:button wire:click="setTab('added-events')" 
                 class="inline-flex items-center justify-center p-4 border-b-2 {{ $activeTab === 'added-events' ? 'text-blue-600 border-blue-600 dark:text-zinc-500 dark:border-zinc-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }} group"
                 
                 icon="plus-circle"
                 style="border-radius: 0;"
                 variant="ghost">
                 
        Evenimente Adăugate
    </flux:button>
</li>
<li class="me-2">
    <flux:button wire:click="setTab('all-events')" 
                 class="inline-flex items-center justify-center p-4 border-b-2 {{ $activeTab === 'all-events' ? 'text-zinc-600 border-blue-600 dark:text-zinc-500 dark:border-zinc-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }} group"
                 
                 icon="list-bullet"
                 style="border-radius: 0;"
                 variant="ghost">
        Evenimente Toate Instituțiile
    </flux:button>
</li>
        </ul>
    </div>

    <div class="mt-4">
        @if ($activeTab === 'added-events')
            <div>
                <div class="mb-4">
                    @can('create events 24h')
                        <button wire:click="$set('showModal', true)" class="bg-blue-500 hover:bg-zinc-600 text-white px-4 py-2 rounded">
                            Adaugă eveniment
                        </button>
                    @endcan
                </div>
                <div class="overflow-y-auto max-h-[700px]" x-data="{ loading: false }" 
                     @scroll.debounce.500ms="if ($el.scrollTop + $el.clientHeight >= $el.scrollHeight - 50 && !loading) { loading = true; $wire.loadMoreEvents().then(() => loading = false); }">
                    @forelse ($events->sortKeysDesc() as $date => $dayEvents)
                        <h2 class="text-lg font-semibold mt-4 mb-2 text-gray-900 dark:text-white">
                            Evenimente din data {{ Carbon\Carbon::parse($date)->format('d.m.Y') }}
                        </h2>
                        <div class="mb-4">
                            <table class="table-fixed w-full bg-gray-100 dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 text-sm">
                                                        <thead>
                                <tr>
                                    <th class="w-1/7 py-2 px-4 border-b border-r border-gray-300 dark:border-zinc-700 text-gray-900 dark:text-white text-left">Data evenimentului</th>
                                    <th class="w-1/7 py-2 px-4 border-b border-r border-gray-300 dark:border-zinc-700 text-gray-900 dark:text-white text-left">Categoria</th>
                                    <th class="w-[57%] py-2 px-4 border-b border-gray-300 dark:border-zinc-700 text-gray-900 dark:text-white text-left">Conținut</th>
                                    <th class="w-2/7 py-2 px-4 border-b border-gray-300 dark:border-zinc-700 text-gray-900 dark:text-white text-center">Acțiuni</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @php
                                        $totalEventCount = $dayEvents->count();
                                        $groupedByCategory = $dayEvents->groupBy('id_events_category');
                                    @endphp
                                    @foreach ($groupedByCategory as $categoryId => $categoryEvents)
                                        @php
                                            $categoryEventCount = $categoryEvents->count();
                                            $categoryName = $categoryEvents->first()->category->name ?? '-';
                                        @endphp
                                        @foreach ($categoryEvents as $index => $event)
                                            <tr>
                                                @if ($index === 0 && $categoryEvents === $groupedByCategory->first())
                                                    <td class="py-2 px-4 border-b border-r border-gray-300 dark:border-zinc-700 text-gray-900 dark:text-white text-left align-top" rowspan="{{ $totalEventCount }}">
                                                        {{ Carbon\Carbon::parse($event->data)->format('d.m.Y') }}
                                                    </td>
                                                @endif
                                                @if ($index === 0)
                                                    <td class="py-2 px-4 border-b border-r border-gray-300 dark:border-zinc-700 text-gray-900 dark:text-white text-left align-top" rowspan="{{ $categoryEventCount }}">
                                                        {{ $categoryName }}
                                                    </td>
                                                @endif
                                                <td class="py-2 px-4 border-b border-gray-300 dark:border-zinc-700 text-gray-900 dark:text-white text-left">
                                                    {!! $event->events_text ?? '-' !!}
                                                </td>
                                                <td class=" py-2 px-4 border-b border-gray-300 dark:border-zinc-700 text-center">
                                                    @can('edit events 24h')
                                                        <button wire:click="editEvent({{ $event->id }})" 
                                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 my-8 rounded" style="margin-right: 3px;">Editează</button>
                                                    @endcan
                                                    @can('delete events 24h')
                                                        <button wire:click="deleteEvent({{ $event->id }})" 
                                                                class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 my-8 rounded">Șterge</button>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @empty
                        <p class="text-center text-gray-900 dark:text-white">Niciun eveniment găsit.</p>
                    @endforelse
                </div>
            </div>
        @elseif ($activeTab === 'all-events')
            <div>
                <div class="mb-4 flex justify-between items-center">
                    <div>
                        <label for="filterDate" class="mr-2 text-sm">Filtrează după dată:</label>
                        <input type="date" id="filterDate" wire:model="filterDate" wire:change="updateFilterDate"
                               class="border border-gray-300 dark:border-zinc-700 bg-gray-100 dark:bg-zinc-800 text-gray-900 dark:text-white p-2 rounded text-sm">
                    </div>
                    <div>
                        <button onclick="printTable()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">Print</button>
                        <button onclick="exportToPDF()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Export PDF</button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table id="all-events-table" class="w-full bg-gray-100 dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 text-sm">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-300 dark:border-zinc-700 text-gray-900 dark:text-white text-left">Categoria</th>
                                <th class="py-2 px-4 border-b border-gray-300 dark:border-zinc-700 text-gray-900 dark:text-white text-left">Instituția</th>
                                <th class="py-2 px-4 border-b border-gray-300 dark:border-zinc-700 text-gray-900 dark:text-white text-left">Conținut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allEvents as $categoryData)
                                <tr>
                                    <td class="py-2 px-4 border-b border-r border-gray-300 dark:border-zinc-700 text-gray-900 dark:text-white text-left align-top" rowspan="{{ $categoryData['events']->count() }}">
                                        {{ $categoryData['category_name'] }}
                                    </td>
                                    @foreach ($categoryData['events'] as $index => $event)
                                        @if ($index > 0)
                                            <tr>
                                        @endif
                                        <td class="py-2 px-4 border-b border-gray-300 dark:border-zinc-700 text-gray-900 dark:text-white text-left">
                                            {{ $event->institution ? $event->institution->name : 'N/A' }}
                                        </td>
                                        <td class="py-2 px-4 border-b border-gray-300 dark:border-zinc-700 text-gray-900 dark:text-white text-left">
                                            {!! $event->events_text ?? '-' !!}
                                        </td>
                                        </tr>
                                    @endforeach
                            @empty
                                <tr>
                                    <td colspan="3" class="py-2 px-4 text-center text-gray-900 dark:text-white">Niciun eveniment găsit pentru data selectată.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    @if ($showModal)
    <div class="fixed top-0 bottom-0 left-0 right-0 lg:left-[16rem] bg-zinc-800 bg-opacity-75 flex items-center justify-center p-4">
    <div class="bg-gray-100 dark:bg-zinc-900 p-6  w-full max-w-[calc(100vw-16rem-2rem)] lg:max-w-4xl max-h-[90vh] overflow-y-auto border border-gray-300 dark:border-zinc-700">
                <h2 class="text-lg font-bold mb-3">{{ $editingEventId ? 'Editează eveniment' : 'Crează eveniment' }}</h2>
                <form wire:submit.prevent="{{ $editingEventId ? 'updateEvent' : 'createEvent' }}">
                    <div class="mb-3 flex flex-row space-x-2">
                        <div class="flex-1 w-1/4">
                            <label class="block mb-1 text-sm">Data</label>
                            @can('schimbare data evenimente')
                                <input type="date" wire:model="data" 
                                       class="w-full border border-gray-300 dark:border-zinc-700 bg-gray-100 dark:bg-zinc-800 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-zinc-500 text-sm">
                            @else
                                <input type="text" value="{{ Carbon\Carbon::today()->format('Y-m-d') }}" readonly
                                       class="w-full border border-gray-300 dark:border-zinc-700 bg-gray-100 dark:bg-zinc-800 text-gray-900 dark:text-white p-2 rounded text-sm">
                            @endcan
                            @error('data') <span class="text-red-500 text-xs">{{ $message }}</span> @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="block mb-1 text-sm">Categorie</label>
                        <select wire:model="id_events_category" wire:change="updateSubcategories"
                                class="w-full border border-gray-300 dark:border-zinc-700 bg-gray-100 dark:bg-zinc-800 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-zinc-500 text-sm">
                            <option value="">Selectează o categorie</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('id_events_category') <span class="text-red-500 text-xs">{{ $message }}</span> @endif
                    </div>
                    @if ($subcategories->isNotEmpty())
                        <div class="mb-3">
                            <div class="flex flex-wrap gap-2">
                                @foreach ($subcategories as $subcategory)
                                    <label class="flex items-center w-1/3">
                                        <input type="checkbox" wire:model="id_subcategory" value="{{ $subcategory->id }}"
                                               class="form-checkbox h-4 w-4 text-zinc-600">
                                        <span class="ml-2 text-sm">{{ $subcategory->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('id_subcategory') <span class="text-red-500 text-xs">{{ $message }}</span> @endif
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="block mb-1 text-sm">Persoane implicate</label>
                        <input type="number" wire:model="persons_involved" min="0" 
                               class="w-full border border-gray-300 dark:border-zinc-700 bg-gray-100 dark:bg-zinc-800 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-zinc-500 text-sm">
                        @error('persons_involved') <span class="text-red-500 text-xs">{{ $message }}</span> @endif
                    </div>
                    <div class="mb-3">
                        <label class="block mb-1 text-sm">Conținut</label>
                        <textarea wire:model="events_text" 
                                  class="w-full border border-gray-300 dark:border-zinc-700 bg-gray-100 dark:bg-zinc-800 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-zinc-500 min-h-[150px] text-sm"></textarea>
                        @error('events_text') <span class="text-red-500 text-xs">{{ $message }}</span> @endif
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" wire:click="resetForm" 
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Anulează</button>
                        <button type="submit" 
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                            {{ $editingEventId ? 'Actualizează' : 'Crează' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
@else
    <div class="text-center text-gray-900 dark:text-white">
        <p>Nu aveți permisiunea de a vizualiza evenimentele.</p>
    </div>
@endcan

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let allEventsData = @json($allEvents);
            console.log('Initial allEvents:', allEventsData);

            Livewire.on('allEventsUpdated', (data) => {
                allEventsData = data;
                console.log('Updated allEvents:', allEventsData);
            });

            Livewire.on('eventsUpdated', () => {
                console.log('Events updated via lazy loading');
            });

            window.printTable = function() {
                const filterDate = document.getElementById('filterDate').value;
                const title = `Nota informativă 24H la data de ${filterDate}`;
                const table = document.getElementById('all-events-table');

                if (!table) {
                    alert('Tabelul nu a fost găsit!');
                    return;
                }

                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Print</title>
                            <style>
                                body { font-family: Arial, sans-serif; margin: 20px; background-color: #fff; }
                                h1 { font-size: 18px; text-align: center; margin-bottom: 20px; }
                                table { width: 100%; border-collapse: collapse; font-size: 12px; background-color: #f9fafb; }
                                th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
                                th { background-color: #f2f2f2; }
                                td[rowspan] { border-right: 1px solid #d1d5db; vertical-align: top; }
                            </style>
                        </head>
                        <body>
                            <h1>${title}</h1>
                            ${table.outerHTML}
                        </body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            };

            window.exportToPDF = function() {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({ orientation: 'portrait' });
                const filterDate = document.getElementById('filterDate').value;
                const title = `Nota informativă 24H la data de ${filterDate}`;

                if (!allEventsData || allEventsData.length === 0) {
                    alert('Nu există date pentru export! Verificați consola pentru detalii.');
                    console.error('allEventsData este gol sau nedefinit:', allEventsData);
                    return;
                }

                doc.setFontSize(18);
                doc.text(title, 105, 10, { align: 'center' });

                let y = 20;
                doc.setFontSize(12);

                doc.setFillColor(242, 242, 242);
                doc.rect(10, y, 50, 8, 'F');
                doc.rect(60, y, 50, 8, 'F');
                doc.rect(110, y, 80, 8, 'F');
                doc.setTextColor(0, 0, 0);
                doc.text('Categoria', 12, y + 6);
                doc.text('Instituția', 62, y + 6);
                doc.text('Conținut', 112, y + 6);
                doc.setLineWidth(0.2);
                doc.rect(10, y, 180, 8);
                y += 8;

                allEventsData.forEach(categoryData => {
                    const categoryName = categoryData.category_name || 'N/A';
                    const events = categoryData.events || [];
                    const rowSpan = events.length;

                    if (rowSpan === 0) {
                        doc.setFillColor(249, 250, 251);
                        doc.rect(10, y, 50, 8, 'F');
                        doc.rect(60, y, 50, 8, 'F');
                        doc.rect(110, y, 80, 8, 'F');
                        doc.text(categoryName, 12, y + 6);
                        doc.text('N/A', 62, y + 6);
                        doc.text('N/A', 112, y + 6);
                        doc.rect(10, y, 180, 8);
                        y += 8;
                    } else {
                        let categoryHeight = rowSpan * 8;
                        events.forEach((event, index) => {
                            const institution = event.institution ? event.institution.name : 'N/A';
                            const content = event.events_text ? event.events_text.replace(/<[^>]+>/g, '') : '-';

                            doc.setFillColor(249, 250, 251);
                            const contentLines = doc.splitTextToSize(content, 78);
                            const contentHeight = Math.max(8, contentLines.length * 5);
                            doc.rect(60, y, 50, contentHeight, 'F');
                            doc.rect(110, y, 80, contentHeight, 'F');
                            doc.text(institution.substring(0, 30), 62, y + 6);
                            doc.text(contentLines, 112, y + 6);
                            doc.rect(60, y, 50, contentHeight);
                            doc.rect(110, y, 80, contentHeight);

                            if (index === 0) {
                                doc.rect(10, y, 50, categoryHeight, 'F');
                                doc.text(categoryName, 12, y + 6);
                                doc.rect(10, y, 50, categoryHeight);
                            }

                            y += contentHeight;
                            if (y > 270) {
                                doc.addPage();
                                y = 10;
                            }
                        });
                    }

                    if (y > 270) {
                        doc.addPage();
                        y = 10;
                    }
                });

                doc.save(`nota_informativa_24h_${filterDate}.pdf`);
            };
        });
    </script>
@endpush
