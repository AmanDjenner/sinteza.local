<?php

namespace App\Livewire;

use App\Models\Detinuti;
use App\Models\Institution;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DetinutiStatistics extends Component
{
    public $selectedDate;
    public $statistics = [];
    public $institutions = [];

    protected $indicators = [
        'total' => 'Total',
        'real_inmates' => 'Deținuți reali',
        'in_search' => 'În căutare',
        'pretrial_detention' => 'Detenție preventivă',
        'initial_conditions' => 'Condiții inițiale',
        'life' => 'Pe viață',
        'female' => 'Femei',
        'minors' => 'Minori',
        'open_sector' => 'Sector deschis',
        'no_escort' => 'Fără escortă',
        'monitoring_bracelets' => 'Brățări monitorizare',
        'hunger_strike' => 'Grevă foame',
        'disciplinary_insulator' => 'Izolator disciplinar',
        'admitted_to_hospitals' => 'Internați spitale',
        'employed_ip_in_hospitals' => 'Angajați IP spitale',
        'employed_dds_in_hospitals' => 'Angajați DDS spitale',
        'work_outside' => 'Muncă exterior',
        'employed_ip_work_outside' => 'Angajați IP exterior',
    ];

    public function mount()
    {
        $this->selectedDate = Carbon::today()->format('Y-m-d');
        $this->institutions = Institution::whereIn('id', array_merge(range(1, 13), range(15, 18)))
            ->orderBy('id')
            ->get();
        $this->loadStatistics();
    }

    private function fetchStatisticsForDate($date)
    {
        try {
            if (!$date) {
                return [];
            }

            $data = Detinuti::whereDate('data', $date)
                ->whereIn('id_institution', array_merge(range(1, 13), range(15, 18)))
                ->select('id_institution')
                ->selectRaw('SUM(total) as total')
                ->selectRaw('SUM(real_inmates) as real_inmates')
                ->selectRaw('SUM(in_search) as in_search')
                ->selectRaw('SUM(pretrial_detention) as pretrial_detention')
                ->selectRaw('SUM(initial_conditions) as initial_conditions')
                ->selectRaw('SUM(life) as life')
                ->selectRaw('SUM(female) as female')
                ->selectRaw('SUM(minors) as minors')
                ->selectRaw('SUM(open_sector) as open_sector')
                ->selectRaw('SUM(no_escort) as no_escort')
                ->selectRaw('SUM(monitoring_bracelets) as monitoring_bracelets')
                ->selectRaw('SUM(hunger_strike) as hunger_strike')
                ->selectRaw('SUM(disciplinary_insulator) as disciplinary_insulator')
                ->selectRaw('SUM(admitted_to_hospitals) as admitted_to_hospitals')
                ->selectRaw('SUM(employed_ip_in_hospitals) as employed_ip_in_hospitals')
                ->selectRaw('SUM(employed_dds_in_hospitals) as employed_dds_in_hospitals')
                ->selectRaw('SUM(work_outside) as work_outside')
                ->selectRaw('SUM(employed_ip_work_outside) as employed_ip_work_outside')
                ->groupBy('id_institution')
                ->get()
                ->keyBy('id_institution');

            return $data->toArray();
        } catch (\Exception $e) {
            Log::error('Eroare la preluarea statisticilor pentru data ' . $date . ': ' . $e->getMessage());
            return [];
        }
    }

    public function loadStatistics()
    {
        try {
            if (!$this->selectedDate) {
                $this->statistics = [];
                return;
            }

            $this->statistics = $this->fetchStatisticsForDate($this->selectedDate);

            $formattedDate = Carbon::parse($this->selectedDate)->format('d-m-Y');
            if (empty($this->statistics)) {
                session()->flash('message', 'Nu există date pentru data selectată: ' . $formattedDate);
            } else {
                session()->flash('message', 'Date actualizate pentru: ' . $formattedDate);
            }
        } catch (\Exception $e) {
            Log::error('Eroare la încărcarea statisticilor deținuților: ' . $e->getMessage());
            session()->flash('error', 'A apărut o eroare la încărcarea statisticilor.');
            $this->statistics = [];
        }
    }

    public function updatedSelectedDate($value)
    {
        $this->selectedDate = $value;
        $this->loadStatistics();
    }

    public function render()
    {
        return view('livewire.detinuti-statistics', [
            'indicators' => $this->indicators,
        ]);
    }
}