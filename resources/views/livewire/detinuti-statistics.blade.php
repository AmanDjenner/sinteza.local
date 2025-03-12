<div>
    <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Statistici Deținuți</h1>

    <div class="mb-4 flex justify-between items-center">
        <div>
            <label for="selected-date" class="block mb-1 text-gray-900 dark:text-white">Alege data:</label>
            <input type="date" id="selected-date" wire:model.live="selectedDate" 
                   class="w-48 border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="flex space-x-2">
            <button onclick="printTable()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Printează
            </button>
            <button onclick="downloadPDF()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Descarcă PDF
            </button>
        </div>
    </div>

    @if (session()->has('error'))
        <div class="mb-4 text-red-500">{{ session('error') }}</div>
    @endif

    @if (session()->has('message'))
        <div class="mb-4 text-yellow-500">{{ session('message') }}</div>
    @endif

    @if ($selectedDate && count($statistics) > 0)
        <div id="statistics-table" class="overflow-x-auto">
            <h2 class="text-xl font-bold text-center mb-4 hidden print:block" id="print-title">
                Statistica deținuți 24 ore pentru data de {{ Carbon\Carbon::parse($selectedDate)->format('d-m-Y') }}
            </h2>
            <table class="w-full bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-sm">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-center">Nr.</th>
                        <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-left">Indicatori</th>
                        @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 18] as $i)
                            <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-center">P{{ $i }}</th>
                        @endforeach
                        <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($indicators as $key => $label)
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-center">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-left">{{ $label }}</td>
                            @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 18] as $i)
                                <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-center">
                                    {{ $statistics[$i][$key] ?? 0 }}
                                </td>
                            @endforeach
                            <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-center font-bold">
                                {{ array_sum(array_column($statistics, $key)) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif ($selectedDate)
        <p class="text-gray-900 dark:text-white text-center">Nu există date pentru data selectată.</p>
    @else
        <p class="text-gray-900 dark:text-white text-center">Selectați o dată pentru a afișa statisticile.</p>
    @endif

    <!-- Biblioteca jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <!-- Biblioteca jsPDF-AutoTable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.3/jspdf.plugin.autotable.min.js"></script>
    <!-- Font Roboto (adaugă fișierul generat) -->
    <script src="{{ asset('js/roboto.js') }}"></script>

    <script>
        const indicators = @json($indicators);
        const institutionIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 18];

        function printTable() {
            window.print();
        }

        function downloadPDF() {
            try {
                // console.log('Începe generarea PDF...');

                const selectedDateInput = document.getElementById('selected-date').value;
                if (!selectedDateInput) {
                    throw new Error('Vă rugăm să selectați o dată.');
                }
                const formattedDate = selectedDateInput.split('-').reverse().join('-');

                const table = document.querySelector('#statistics-table table');
                if (!table) {
                    throw new Error('Tabelul nu este disponibil.');
                }

                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: 'a4'
                });

                doc.addFileToVFS('Roboto-Regular.ttf', robotoFont); 
                doc.addFont('Roboto-Regular.ttf', 'Roboto', 'regular');
                doc.setFont('Roboto');

                doc.setFontSize(16);
                const title = `Statistica detinuti 24 ore pentru data de ${formattedDate}`;
                // console.log('Titlu trimis către PDF:', title);
                doc.text(title, 148.5, 20, { align: 'center' });

                const headers = ['Nr.', 'Indicatori'].concat(institutionIds.map(id => `P${id}`), ['Total']);
                const body = [];

                const rows = table.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const rowData = Array.from(cells).map(cell => {
                        const text = cell.textContent.trim();
                        // console.log('Text celulă:', text);
                        return text;
                    });
                    body.push(rowData);
                });

                doc.autoTable({
                    head: [headers],
                    body: body,
                    startY: 30,
                    styles: { 
                        font: 'Roboto', 
                        fontSize: 8, 
                        cellPadding: 2,
                        overflow: 'linebreak',
                        halign: 'center' 
                    },
                    headStyles: { 
                        font: 'Roboto', 
                        fillColor: [100, 100, 100], 
                        textColor: [255, 255, 255], 
                        fontStyle: 'bold',
                        halign: 'center'
                    },
                    columnStyles: {
                        0: { cellWidth: 10 }, // Nr.
                        1: { cellWidth: 40, halign: 'left' } 
                    },
                    margin: { top: 10, left: 10, right: 10, bottom: 10 },
                    didDrawPage: (data) => {
                        // console.log('Tabel generat pe pagina:', data.pageNumber);
                    }
                });

                // console.log('PDF generat.');
                doc.save(`Sinteza pentru data de ${formattedDate}.pdf`);
                // console.log('PDF salvat cu succes.');

            } catch (error) {
                console.error('Eroare la generarea PDF-ului:', error);
                alert(error.message || 'A apărut o eroare la generarea PDF-ului. Verificați consola pentru detalii.');
            }
        }
    </script>

    <style>
        @media screen {
            .text-left {
                text-align: left !important;
            }
            .text-center {
                text-align: center !important;
            }
        }
        @media print {
            body * {
                visibility: hidden;
            }
            #statistics-table, #statistics-table * {
                visibility: visible;
            }
            #statistics-table {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            #print-title {
                display: block !important;
                margin-bottom: 10px;
            }
            table {
                font-size: 10pt;
                width: 100%;
            }
            th, td {
                padding: 5px;
            }
            .text-left {
                text-align: left !important;
            }
            .text-center {
                text-align: center !important;
            }
        }
    </style>
</div>