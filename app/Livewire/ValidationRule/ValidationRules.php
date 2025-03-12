<?php

namespace App\Livewire\ValidationRule;

use App\Models\ValidationRule;
use Livewire\Component;
use Livewire\WithPagination;
class ValidationRules extends Component
{    use WithPagination;

    public ?string $search;
    public $showDeleteModal = false;

    public $deleteId;

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

    // public function confirmDelete($id)
    // {
    //     $this->deleteId = $id;
    // }
    public function delete()
    {
        $validationRule = ValidationRule::findOrFail($this->deleteId);
        $validationRule->delete();
        return redirect()->route('validation-rules.index')->with(['success', 'Validation Rule has been deleted successfully']);
    }
    public function render()
    {
        $validationRules = ValidationRule::all();

        return view('livewire.validation-rule.validation-rules' , [
            'validationRules'=> $validationRules
        ]);
    }
}
