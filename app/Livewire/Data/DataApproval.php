<?php

namespace App\Livewire\Data;

use App\Models\Approval;
use App\Models\DataApproval as ModelsDataApproval;
use App\Models\DataGeneration;
use App\Models\WorkFlow;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataApproval extends Component
{
    public $template;

    public $dataGeneration;

    public $errorsList = [];
    public $successMessage;

    public $approvers;
    public $approvals = [];

    public $approvalErrorList = [];
    public $approvalSuccessMessage;
    public $hasApprovedError;
    public $activeTab;

    public function mount($id)
    {
        $this->activeTab = 'dataApproval';

        $this->dataGeneration = DataGeneration::findOrFail($id);
        $this->template = $this->dataGeneration->template;

        $this->errorsList = [];
        $this->successMessage = null;

        $workFlow = WorkFlow::where('template_id', $this->template->id)->first();
        $this->approvalErrorList = [];
        $this->approvalSuccessMessage;
        $this->approvers = $workFlow?->approvalStages;
        $this->approvals = $this->dataGeneration->approvals;
        $this->hasApprovedError = null;
    }
    public function render()
    {
        return view('livewire.data.data-approval');
    }

    public function handleDataApproval($id)
    {
        $workFlow = WorkFlow::where('template_id', $this->template->id)->with('approvalStages')->first();
        $this->approvers = $workFlow->approvalStages;

        $user = Auth::user();

        $hasApproved = Approval::where('data_generation_id', $this->dataGeneration->id)->where('user_id', Auth::user()->id)->first();

        // dd($hasApproved);

        if ($hasApproved) {
            $this->hasApprovedError = 'You have already approved this data.';
            return;
        } else {
            if ($user->workFlowStages()->exists()) {
                $workflowStage = $user->workflowStages()->first();
                // dd($workflowStage);
                $approval = Approval::create([
                    'data_generation_id' => $this->dataGeneration->id,
                    'stage' => $workflowStage->stage,
                    'status' => 'approved',
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                    // 'notes',
                    'user_id' => Auth::user()->id,
                ]);
                $approval->systemLogs()->create([
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                    'status' => 'success',
                    'description' => "Successfull approval",
                    'user_id' => Auth::user()->id,
                    'loggable_type' => Approval::class,
                    'loggable_id' => $approval->id,
                ]);

                // Check if all required approvals are completed
                $totalApprovals = Approval::where('data_generation_id', $this->dataGeneration->id)
                    ->where('status', 'approved')
                    ->count();

                $totalStages = $workFlow->approvalStages->count();

                if ($totalApprovals >= $totalStages) {
                    // Update data generation approval status to "approved"
                    $this->dataGeneration->update(['approval' => 'success']);
                }
            } else {
                $approval = Approval::create([
                    'data_generation_id' => $this->dataGeneration->id,
                    // 'workflow_stage_id' => $workflowStage->id,
                    'status' => 'rejected',
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                    // 'notes',
                    'user_id' => Auth::user()->id,
                ]);
                $approval->systemLogs()->create([
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                    'status' => 'failed',
                    'description' => "Failed to approve",
                    'user_id' => Auth::user()->id,
                    'loggable_type' => Approval::class,
                    'loggable_id' => $approval->id,
                ]);

                $this->dataGeneration->update(['approval' => 'error']);
            }
        }
    }

    // public function handleDataApproval($id)
    // {
    //     $user = Auth::user();
    //     if ($user->workFlowStages()->exists()) {
    //         $workflowStage = $user->workflowStages()->first();
    //         $approval = Approval::create([
    //             'data_generation_id' => $this->dataGeneration->id,
    //             // 'workflow_stage_id' => $workflowStage->id,
    //             'status' => 'approved',
    //             'date' => now()->toDateString(),
    //             'time' => now()->toTimeString(),
    //             // 'notes',
    //             'user_id' => auth()->user()->id,
    //         ]);

    //         $approval->systemLogs()->create([
    //             'date' => now()->toDateString(),
    //             'time' => now()->toTimeString(),
    //             'status' => 'success',
    //             'description' => "Successfull approval",
    //             'user_id' => auth()->user()->id,
    //             'loggable_type' => Approval::class,
    //             'loggable_id' => $approval->id,
    //         ]);
    //     } else {
    //         $approval = Approval::create([
    //             'data_generation_id' => $this->dataGeneration->id,
    //             // 'workflow_stage_id' => $workflowStage->id,
    //             'status' => 'rejected',
    //             'date' => now()->toDateString(),
    //             'time' => now()->toTimeString(),
    //             // 'notes',
    //             'user_id' => auth()->user()->id,
    //         ]);
    //         $approval->systemLogs()->create([
    //             'date' => now()->toDateString(),
    //             'time' => now()->toTimeString(),
    //             'status' => 'failed',
    //             'description' => "Failed to approve",
    //             'user_id' => auth()->user()->id,
    //             'loggable_type' => Approval::class,
    //             'loggable_id' => $approval->id,
    //         ]);
    //         return redirect()->back()->with('error', 'You are not allowed to approve this data');
    //     }
    // }
}
