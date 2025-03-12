<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class CreateRole extends Component
{
    public $permissions;
    public  $name;
    public function mount()
    {
        $this->permissions = Permission::all()->toArray();
    }
    // protected $rules = [
    //     'name' => 'required|string|max:255',
    //     'permissions' => 'required|array',
    //     'permissions.*' => 'exists:permissions,name',
    // ];

    // protected $messages = [
    //     'name.required' => 'Role name is required.',
    //     'permissions.required' => 'Choose at least one permission.',
    // ];


    public function submit()
    {
        // $this->validate();

        try {
            DB::beginTransaction();

            // Create or update the role
            $role = Role::updateOrCreate(
                ['name' => $this->name],
                ['guard_name' => 'web']
            );
            $permissions = $this->permissions;

            $permissions = array_map(function ($item) {
                return (int)$item;
            }, $permissions);
            $role->syncPermissions($permissions);

            DB::commit();

            // $notification = 'Role saved successfully.';
            // $notification = array('messege' => $notification, 'alert-type' => 'success');
            return redirect()->route('roles');
        } catch (\Throwable $th) {
            throw $th;

            // $notification = 'Failed to save role.';
            // $notification = array('messege' => $notification, 'alert-type' => 'error');
            // return redirect()->route('admin.roles.index')->with($notification);
        }
    }
    public function render()
    {
        return view('livewire.roles.create-role');
    }
}
