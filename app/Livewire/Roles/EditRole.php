<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class EditRole extends Component
{
    public $role;
    public $permissions = [];
    public $name;
    public $current_permissions;
    public $roleId;
    public $selectedPermissions = [];
    public function mount($id)
    {
        $this->role = Role::findOrFail($id);
        $this->roleId = $this->role->id;
        $this->name = $this->role->name;
        $this->permissions = Permission::all()->pluck('name', 'id')->toArray();
        $this->selectedPermissions = $this->role->permissions->pluck('name')->toArray(); // Use names instead of IDs
    }

    public function render()
    {
        return view('livewire.roles.edit-role');
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $this->roleId,
            'selectedPermissions' => 'array',
        ]);

        try {
            DB::beginTransaction();

            $role = Role::findOrFail($this->roleId);
            $role->update(['name' => $this->name]);
            $role->syncPermissions($this->selectedPermissions);

            DB::commit();
            session()->flash('success', 'Role updated successfully.');
            return redirect()->route('roles');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Failed to update role.');
            throw $th;
        }
    }
}
