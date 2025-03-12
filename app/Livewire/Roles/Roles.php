<?php

namespace App\Livewire\Roles;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    public $roleId;
    public $showDeleteModal = false; // Livewire variable to control modal visibility

    public function confirm($id)
    {
        $this->roleId = $id;
        $this->showDeleteModal = true; // Show modal
    }
    public function deleteRole()
    {
        if ($this->roleId) {
            $role = Role::findOrFail($this->roleId);

            // Disassociate users from this role before deletion
            $users = User::role($role->name)->get();
            foreach ($users as $user) {
                $user->removeRole($role);
            }

            // Delete the role
            $role->delete();

            session()->flash('message', 'Role deleted and users disassociated successfully.');
        }

        $this->showDeleteModal = false; // Hide modal after deletion
    }
    public function closeModal()
    {
        $this->showDeleteModal = false;
    }
    public function render()
    {
        $roles = Role::all();
        return view('livewire.roles.roles', [
            'roles' => $roles
        ]);
    }
}
