<?php

namespace App\Livewire\Roles;

use App\Models\User;
use Illuminate\Support\Facades\DB;
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
            DB::beginTransaction();
            try {
                $role = Role::findOrFail($this->roleId);
                if ($role->name === 'super-admin') {
                    return redirect()->route('roles')->with(['error' => 'Cannot delete the super-admin role.']);
                }

                // Disassociate users from this role before deletion
                $users = User::role($role->name)->get();
                foreach ($users as $user) {
                    $user->removeRole($role);
                }

                // Delete the role
                $role->delete();

                DB::commit();
                return redirect()->route('roles')->with(['success' => 'Role has been deleted successfully.']);
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('roles')->with(['error' => 'Failed to delete the role:'. $e->getMessage()]);
            }
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
