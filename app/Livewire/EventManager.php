<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\Institution;
use App\Models\EventCategory;
use App\Models\EventSubcategory;

class EventManager extends Component
{
    public $events = [];
    public $institutions;
    public $categories;
    public $subcategories = [];
    public $showModal = false;
    public $editingEventId = null;
    public $data;
    public $id_institution;
    public $id_events_category; // Schimbat din id_category
    public $id_subcategory = []; // Corect ca array
    public $persons_involved;
    public $events_text;

    protected $rules = [
        'data' => 'nullable|date',
        'id_institution' => 'required|exists:institutions,id',
        'id_events_category' => 'required|exists:events_category,id', // Schimbat din id_category
        'id_subcategory' => 'nullable|array',
        'id_subcategory.*' => 'exists:events_subcategory,id',
        'persons_involved' => 'nullable|integer|min:0',
        'events_text' => 'nullable|string',
    ];

    public function mount()
    {
        $this->institutions = Institution::all();
        $this->categories = EventCategory::all();
        $this->loadEvents();
    }

    public function loadEvents()
    {
        try {
            $this->events = Event::with(['institution', 'category', 'subcategories'])->get();
        } catch (\Exception $e) {
            $this->events = [];
            \Log::error('Eroare la încărcarea evenimentelor: ' . $e->getMessage());
            session()->flash('error', 'Eroare la încărcarea evenimentelor: ' . $e->getMessage());
        }
    }

    public function updateSubcategories()
    {
        if ($this->id_events_category) { // Schimbat din id_category
            $this->subcategories = EventSubcategory::where('id_events_category', $this->id_events_category)->get(); // Schimbat din id_category
            $this->id_subcategory = []; // Resetează selecția subcategoriilor
        } else {
            $this->subcategories = [];
            $this->id_subcategory = [];
        }
    }

    public function createEvent()
    {
        $this->validate();

        try {
            $event = Event::create([
                'data' => $this->data,
                'id_institution' => $this->id_institution,
                'id_events_category' => $this->id_events_category, // Schimbat din id_category
                'persons_involved' => $this->persons_involved,
                'events_text' => $this->events_text,
            ]);

            if (!empty($this->id_subcategory)) {
                $event->subcategories()->sync($this->id_subcategory);
            }

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
            $this->id_events_category = $event->id_events_category; // Schimbat din id_category
            $this->id_subcategory = $event->subcategories->pluck('id')->toArray();
            $this->persons_involved = $event->persons_involved;
            $this->events_text = $event->events_text;
            $this->updateSubcategories();
            $this->showModal = true;

            $this->emit('editEvent', ['data' => $event->toArray()]);
        } catch (\Exception $e) {
            \Log::error('Eroare la editarea evenimentului: ' . $e->getMessage());
            session()->flash('error', 'Eroare la editarea evenimentului: ' . $e->getMessage());
        }
    }

    public function updateEvent()
    {
        $this->validate();

        try {
            $event = Event::findOrFail($this->editingEventId);
            $event->update([
                'data' => $this->data,
                'id_institution' => $this->id_institution,
                'id_events_category' => $this->id_events_category, // Schimbat din id_category
                'persons_involved' => $this->persons_involved,
                'events_text' => $this->events_text,
            ]);

            if (!empty($this->id_subcategory)) {
                $event->subcategories()->sync($this->id_subcategory);
            } else {
                $event->subcategories()->detach();
            }

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
        $this->id_events_category = null; // Schimbat din id_category
        $this->id_subcategory = [];
        $this->persons_involved = null;
        $this->events_text = null;
        $this->subcategories = [];
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.event-manager');
    }
}