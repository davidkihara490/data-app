<?php

namespace App\Livewire\WorkFlow;

use App\Models\WorkFlow;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class WorkFlows extends Component
{
    public ?string $search;

    public $deleteId;
    public $showDeleteModal = false; // Livewire variable to control modal visibility


    public function confirm($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true; // Show modal

    }
    public function deleteWorkFlow()
    {
        $workFlow = WorkFlow::findOrFail($this->deleteId);
        $workFlow->delete();
        $this->showDeleteModal = false; // Hide modal after deletion

        return redirect()->route('workflows.index')->with(['success', 'Work Flow has been deleted successfully']);
    }

    public function closeModal()
    {
        $this->showDeleteModal = false;
    }
    public function render()
    {
        $workFlows = WorkFlow::query()
            ->orderByDesc('id')
            ->when(
                ! empty($this->search),
                fn(Builder $q) => $q->where('name', 'like', "%{$this->search}%")
            )
            ->get();
        // ->paginate(10);

        return view('livewire.work-flow.work-flows', [
            'workFlows' => $workFlows
        ]);
    }
}
