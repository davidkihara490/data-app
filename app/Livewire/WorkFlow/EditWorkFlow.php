<?php

namespace App\Livewire\WorkFlow;

use App\Models\Template;
use App\Models\User;
use App\Models\WorkFlow;
use App\Models\WorkFlowStage;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;

class EditWorkFlow extends Component
{
    public $name;
    public $template_id;
    public $stages;
    public $fields = [];
    public $workFlow;
    public $templates = [];
    public $users = [];

    public function mount(?int $id = null)
    {
        $this->workFlow = $id ? WorkFlow::findOrFail($id) : new WorkFlow;
        $this->name = $this->workFlow->name;
        $this->template_id = $this->workFlow->template_id;
        $this->stages = $this->workFlow->stages;

        $this->templates = Template::all();
        $this->users = User::whereHas('roles.permissions', function ($query) {
            $query->where('name', 'approve_data');
        })->get();

        $new_field = [
            ['id' => null, 'user_id' => '', 'stage' => '', 'uuid' => strval(Str::uuid())],
        ];
        $this->fields =
            count($this->workFlow->approvalStages) > 0
            ? $this->workFlow->approvalStages
            ->map(
                fn(WorkFlowStage $workFlowStage) => [
                    'id' => $workFlowStage->id,
                    'user_id' => $workFlowStage->user_id,
                    'stage' => $workFlowStage->stage,
                    'uuid' => strval(Str::uuid()),
                ],
            )
            ->toArray()
            : $new_field;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'template_id' => 'required|integer|unique:templates,id',
            'stages' => 'required|integer|min:1',
            'fields' => 'required|array',
            'fields.*.stage' => 'required|integer',

            'fields.*.user_id' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'template_id.required' => 'Template is required',
            'template_id.unique' => 'This template exists. Consider editing.',
            'stages.required' => 'Number of stages is required',
            'fields.*.stage.required' => 'Select a stage',

            'fields.*.user_id.required' => 'Select a user',
        ];
    }

    public function save()
    {
        // $this->validate();
        try {
            DB::beginTransaction();
            $this->workFlow->name = $this->name;
            $this->workFlow->template_id = $this->template_id;
            $this->workFlow->stages = $this->stages;
            $this->workFlow->save();

            $this->workFlow->approvalStages()->delete();
            $this->workFlow->approvalStages()->createMany($this->fields);
            DB::commit();

            return redirect()->route('workflows.index')->with(['success' => 'Workflow updated successfully.']);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function addField(): void
    {
        $this->fields[] = ['id' => null, 'user_id' => '', 'stage' => '', 'uuid' => strval(Str::uuid())];
    }

    public function removeField(int $id): void
    {
        array_splice($this->fields, $id, 1);
    }

    // public function updated($property)
    // {
    //     if ($property == 'stages') {
    //         // $this->approvalStages = [];
    //         // for ($i = 1; $i <= $this->stages; $i++) {
    //         //     $this->approvalStages[] = $i;
    //         // }
    //         $this->fields = $this->stages;
    //     }
    // }

    // public function updatedStages()
    // {
    //     $newFields = [];

    //     for ($i = 0; $i < $this->stages; $i++) {
    //         $newFields[] = [
    //             'id' => null,
    //             'user_id' => '',
    //             'stage' => $i + 1, // Auto-numbering stages
    //             'uuid' => strval(Str::uuid()),
    //         ];
    //     }

    //     $this->fields = $newFields;
    // }

    public function updatedStages()
    {
        // Ensure stages is always at least 1
        $this->stages = max(1, (int) $this->stages);
    }
    public function render()
    {
        return view('livewire.work-flow.edit-work-flow');
    }
}
