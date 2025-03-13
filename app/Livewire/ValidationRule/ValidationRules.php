<?php

namespace App\Livewire\ValidationRule;

use App\Models\User;
use App\Models\ValidationRule;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ValidationRules extends Component
{    
    public ?string $search;
    public $showDeleteModal = false;

    public $deleteId;

    public function confirm($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true; // Show modal
    }

    public function deleteWorkFlow()
    {
        $validationRule = ValidationRule::findOrFail($this->deleteId);
        $validationRule->validationRuleColumns()->delete();
        $validationRule->delete();

        $this->showDeleteModal = false;

        return redirect()->route(route: 'vr.index')->with(['success', 'validation Rule has been deleted successfully']);

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
