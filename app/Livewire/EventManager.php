<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Institution;
use App\Models\EventCategory;
use App\Models\EventSubcategory;
use Livewire\Component;

class EventManager extends Component
{
    public $events = [];
    public $showModal = false;
    public $editingEventId = null;
    public $data, $id_institution, $id_events_category, $id_subcategory, $persons_involved, $events_text;

    protected $rules = [
        'data' => 'nullable|date',
        'id_institution' => 'required|exists:institutions,id',
        'id_events_category' => 'required|exists:events_category,id',
        'id_subcategory' => 'nullable|exists:events_subcategory,id',
        'persons_involved' => 'nullable|integer|min:0',
        'events_text' => 'nullable|string',
    ];

    public function mount()
    {
        $this->loadEvents();
    }

    public function loadEvents()
    {
        try {
            $this->events = Event::with(['institution', 'category', 'subcategory'])->get();
        } catch (\Exception $e) {
            $this->events = [];
            \Log::error('Eroare la încărcarea evenimentelor: ' . $e->getMessage());
            session()->flash('error', 'Eroare la încărcarea evenimentelor: ' . $e->getMessage());
        }
    }

    public function createEvent()
    {
        try {
            $this->validate();
            Event::create([
                'data' => $this->data,
                'id_institution' => $this->id_institution,
                'id_events_category' => $this->id_events_category,
                'id_subcategory' => $this->id_subcategory,
                'persons_involved' => $this->persons_involved,
                'events_text' => $this->events_text,
            ]);
            $this->resetForm();
            $this->loadEvents();
            session()->flash('message', 'Eveniment creat cu succes!');
        } catch (\Exception $e) {
            \Log::error('Eroare la crearea evenimentului: ' . $e->getMessage());
            session()->flash('error', 'Eroare la crearea evenimentului: ' . $e->getMessage());
        }
    }

    public function editEvent($id)
    {
        try {
            $event = Event::findOrFail($id);
            $this->editingEventId = $id;
            $this->data = $event->data ? $event->data->format('Y-m-d') : null;
            $this->id_institution = $event->id_institution;
            $this->id_events_category = $event->id_events_category;
            $this->id_subcategory = $event->id_subcategory;
            $this->persons_involved = $event->persons_involved;
            $this->events_text = $event->events_text;
            $this->showModal = true;

            $this->dispatchBrowserEvent('editEvent', [
                'data' => $event->toArray(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Eroare la editarea evenimentului: ' . $e->getMessage());
            session()->flash('error', 'Eroare la editarea evenimentului: ' . $e->getMessage());
        }
    }

    public function updateEvent()
    {
        try {
            $this->validate();
            $event = Event::findOrFail($this->editingEventId);
            $event->update([
                'data' => $this->data,
                'id_institution' => $this->id_institution,
                'id_events_category' => $this->id_events_category,
                'id_subcategory' => $this->id_subcategory,
                'persons_involved' => $this->persons_involved,
                'events_text' => $this->events_text,
            ]);
            $this->resetForm();
            $this->loadEvents();
            session()->flash('message', 'Eveniment actualizat cu succes!');
        } catch (\Exception $e) {
            \Log::error('Eroare la actualizarea evenimentului: ' . $e->getMessage());
            session()->flash('error', 'Eroare la actualizarea evenimentului: ' . $e->getMessage());
        }
    }

    public function deleteEvent($id)
    {
        try {
            Event::findOrFail($id)->delete();
            $this->loadEvents();
            session()->flash('message', 'Eveniment șters cu succes!');
        } catch (\Exception $e) {
            \Log::error('Eroare la ștergerea evenimentului: ' . $e->getMessage());
            session()->flash('error', 'Eroare la ștergerea evenimentului: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->showModal = false;
        $this->editingEventId = null;
        $this->data = null;
        $this->id_institution = null;
        $this->id_events_category = null;
        $this->id_subcategory = null;
        $this->persons_involved = null;
        $this->events_text = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        try {
            return view('livewire.event-manager', [
                'institutions' => Institution::all(),
                'categories' => EventCategory::all(),
                'subcategories' => EventSubcategory::all(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Eroare la randarea componentei: ' . $e->getMessage());
            session()->flash('error', 'Eroare la încărcarea datelor: ' . $e->getMessage());
            return view('livewire.event-manager', [
                'institutions' => [],
                'categories' => [],
                'subcategories' => [],
            ]);
        }
    }
}