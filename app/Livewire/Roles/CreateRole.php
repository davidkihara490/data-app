<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class CreateRole extends Component
{
    public $permissions = [];
    public $name;
    public $selectedPermissions = [];

    public function mount()
    {
        $this->permissions = Permission::all();
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'selectedPermissions' => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            // Create or update the role
            $role = Role::updateOrCreate(
                ['name' => $this->name],
                ['guard_name' => 'web']
            );

            // Retrieve selected permissions by ID
            $permissions = Permission::whereIn('id', $this->selectedPermissions)->get();

            // Sync exact permissions
            $role->syncPermissions($permissions);

            DB::commit();

            return redirect()->route('roles')->with(['success' => 'Role has been saved successfully.']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with(['error' => 'Error saving role: ' . $th->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.roles.create-role');
    }
}
