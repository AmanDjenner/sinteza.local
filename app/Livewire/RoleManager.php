<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleManager extends Component
{
    public $roles;
    public $permissions;
    public $name = '';
    public $selectedPermissions = [];
    public $editingRoleId = null;
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:100|unique:roles,name',
        'selectedPermissions' => 'array',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->roles = Role::with('permissions')->get();
        $this->permissions = Permission::all();
    }

    public function createRole()
    {
        $this->validate();

        $role = Role::create(['name' => $this->name]);
        $role->syncPermissions($this->selectedPermissions);

        $this->resetForm();
        $this->loadData();
    }

    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        $this->editingRoleId = $id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->showModal = true;
    }

    public function updateRole()
    {
        $this->validate([
            'name' => 'required|string|max:100|unique:roles,name,' . $this->editingRoleId,
        ]);

        $role = Role::findOrFail($this->editingRoleId);
        $role->update(['name' => $this->name]);
        $role->syncPermissions($this->selectedPermissions);

        $this->resetForm();
        $this->loadData();
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        $this->loadData();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->selectedPermissions = [];
        $this->editingRoleId = null;
        $this->showModal = false; // Închide modalul și resetează formularul
    }

    public function render()
    {
        return view('livewire.role-manager');
    }
}