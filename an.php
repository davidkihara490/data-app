<?php

namespace App\Livewire\Templates;

use App\Models\Approval;
use App\Models\DataGeneration;
use App\Models\DataValidation;
use App\Models\SystemLog;
use App\Models\Template;
use App\Models\ValidationError;
use App\Models\ValidationRule;
use App\Models\WorkFlow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ViewTemplate extends Component
{
    public $template;
    public $dataGeneration;
    public $errorsList = [];

    public $validationErrorList = [];
    public $fetchedData = [];
    public $dataGenerationStatus;
    public $activeStage;

    public $generatedData = [];

    public $latestGeneratedData = [];

    public $dataFetchingStatus;

    public $currentDataGeneration;

    public $validationSuccessMessage;

    public $approvalErrorList = [];
    public $approvalSuccessMessage;
    public $approvers;
    public $approvals = [];

    public $hasApprovedError;

    public $activeTab = 'dataGeneration';

    public function mount($id)
    {
        $this->template = Template::findOrFail($id);
        $this->dataGenerationStatus = DataGeneration::where('template_id', $id)
            ->whereDate('date', now()->toDateString())
            ->exists();
        $this->currentDataGeneration = $this->template->latestDataGeneration;

        $this->latestGeneratedData = $this->template->latestDataGeneration->data ?? [];
        $this->dataFetchingStatus = !empty($this->latestGeneratedData);
        $this->dataGeneration = $this->template->latestDataGeneration;

        // $this->activeTab = 'dataGeneration';

        $this->generatedData = DataGeneration::where('template_id', $id)->get();
        // $this->fetchedData = DB::table($this->template->table)->get() ?? null;

        $workFlow = WorkFlow::where('template_id', $this->template->id)->first();
        $this->approvalErrorList = [];
        $this->approvalSuccessMessage;
        $this->approvers  = $workFlow?->approvalStages;
        $this->approvals = $this->dataGeneration->approvals ?? [];

        $this->hasApprovedError = '';
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function handleDataGeneration($id)
    {
        $this->setActiveTab('dataGeneration');
        try {
            $data = DB::connection('second_db')->table('customers')->get();

            if ($data->isNotEmpty()) {
                // Check if there is an existing record for today
                $dataGeneration = DataGeneration::where('template_id', $id)
                    ->whereDate('date', now()->toDateString())
                    ->first();

                if ($dataGeneration) {
                    // Update existing record
                    $dataGeneration->update([
                        'data' => $data,
                        'time' => now()->toTimeString(),
                        'status' => 'completed',
                        'user_id' => Auth::user()->id,
                    ]);

                    $dataGeneration->systemLogs()->create([
                        'date' => now()->toDateString(),
                        'time' => now()->toTimeString(),
                        'status' => 'success',
                        'description' => "Data updated successfully",
                        'user_id' => Auth::user()->id,
                        'loggable_type' => DataGeneration::class,
                        'loggable_id' => $dataGeneration->id,
                    ]);
                    $this->dataGeneration = $dataGeneration;
                } else {
                    // Create a new record
                    $dataGeneration = DataGeneration::create([
                        'template_id' => $id,
                        'date' => now()->toDateString(),
                        'time' => now()->toTimeString(),
                        'data' => $data,
                        'status' => 'completed',
                        'user_id' => Auth::user()->id,
                    ]);

                    $dataGeneration->systemLogs()->create([
                        'date' => now()->toDateString(),
                        'time' => now()->toTimeString(),
                        'status' => 'success',
                        'description' => "Fetching successful",
                        'user_id' => Auth::user()->id,
                        'loggable_type' => DataGeneration::class,
                        'loggable_id' => $dataGeneration->id,
                    ]);

                    $this->dataGeneration = $dataGeneration;
                }
            } else {
                // Check if a failed record already exists for today
                $dataGeneration = DataGeneration::where('template_id', $id)
                    ->whereDate('date', now()->toDateString())
                    ->first();

                if ($dataGeneration) {
                    // Update existing failed record
                    $dataGeneration->update([
                        'time' => now()->toTimeString(),
                        'status' => 'completed',
                        'user_id' => Auth::user()->id,
                    ]);

                    $dataGeneration->systemLogs()->create([
                        'date' => now()->toDateString(),
                        'time' => now()->toTimeString(),
                        'status' => 'success',
                        'description' => "Fetching data was not successful (Updated existing record)",
                        'user_id' => Auth::user()->id,
                        'loggable_type' => DataGeneration::class,
                        'loggable_id' => $dataGeneration->id,
                    ]);

                    $this->dataGeneration = $dataGeneration;
                } else {
                    // Create new failed record
                    $dataGeneration = DataGeneration::create([
                        'template_id' => $id,
                        'date' => now()->toDateString(),
                        'time' => now()->toTimeString(),
                        'data' => $data,
                        'status' => 'failed',
                        'user_id' => Auth::user()->id,
                    ]);

                    $dataGeneration->systemLogs()->create([
                        'date' => now()->toDateString(),
                        'time' => now()->toTimeString(),
                        'status' => 'success',
                        'description' => "Fetching data was not successful",
                        'user_id' => Auth::user()->id,
                        'loggable_type' => DataGeneration::class,
                        'loggable_id' => $dataGeneration->id,
                    ]);

                    $this->dataGeneration = $dataGeneration;
                }
            }

            $this->latestGeneratedData =  $this->template->latestDataGeneration->data ?? [];
            $this->dataFetchingStatus = !empty($this->latestGeneratedData);

            $this->generatedData = DataGeneration::where('template_id', $id)->get();
        } catch (\Throwable $th) {
            // SystemLog::create([
            //     'date' => now()->toDateString(),
            //     'time' => now()->toTimeString(),
            //     'status' => 'error',
            //     'description' => "Error during data fetching: " . $th->getMessage(),
            //     'user_id' => Auth::user()->id,
            // ]);
        }
    }

    public function handleDataValidation($id)
    {
        $this->setActiveTab('dataValidation');

        $validationRules = ValidationRule::where('template_id', $this->template->id)
            ->with('validationRuleColumns')
            ->first();

        if (!$validationRules) {
            return ['errors' => ['Validation rules not found']];
        }

        // Prepare validation rules
        $rules = [];
        foreach ($validationRules->validationRuleColumns as $ruleColumn) {
            $rules[$ruleColumn->column] = json_decode($ruleColumn->rules, true);
        }

        $errors = [];
        $data = $this->dataGeneration->data;

        foreach ($data as $index => $row) {
            $validator = Validator::make((array) $row, $rules);
            if ($validator->fails()) {
                $errors[$index] = $validator->errors()->toArray();
            }
        }

        try {
            if (!empty($errors)) {
                $dataValidation = DataValidation::create([
                    'data_generation_id' => $this->dataGeneration->id,
                    'template_id' => $this->template->id,
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                    'status' => 'failed',
                ]);

                // Store validation errors
                foreach ($errors as $index => $errorMessages) {
                    foreach ($errorMessages as $column => $messages) {
                        ValidationError::create([
                            'data_generation_id' => $this->dataGeneration->id,
                            'error' => "Row $index - Column '$column': " . implode(', ', $messages),
                        ]);
                    }
                }

                $dataValidation->systemLogs()->create([
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                    'status' => 'failed',
                    'description' => 'Validation failed with errors.',
                    'user_id' => Auth::user()->id,
                    'loggable_type' => DataValidation::class,
                    'loggable_id' => $dataValidation->id,
                ]);

                $this->validationErrorList = $errors;

                return;
            } else {
                $dataValidation = DataValidation::create([
                    'data_generation_id' => $this->dataGeneration->id,
                    'template_id' => $this->template->id,
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                    'status' => 'completed',
                ]);

                $dataValidation->systemLogs()->create([
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                    'status' => 'success',
                    'description' => 'Validated data successfully',
                    'user_id' => Auth::user()->id,
                    'loggable_type' => DataValidation::class,
                    'loggable_id' => $dataValidation->id,
                ]);


                $this->validationSuccessMessage = "Data validated successfully";
            }
        } catch (\Throwable $th) {
            $dataValidation = DataValidation::create([
                'data_generation_id' => $this->dataGeneration->id,
                'template_id' => $this->template->id,
                'date' => now()->toDateString(),
                'time' => now()->toTimeString(),
                'status' => 'failed',
            ]);

            $dataValidation->systemLogs()->create([
                'date' => now()->toDateString(),
                'time' => now()->toTimeString(),
                'status' => 'failed',
                'description' => "Error during data validation: " . $th->getMessage(),
                'user_id' => Auth::user()->id,
                'loggable_type' => DataValidation::class,
                'loggable_id' => $dataValidation->id,
            ]);

            $this->validationErrorList = $th->getMessage();
        }

        dd($this->validationErrorList);
    }
    private function saveValidData($data)
    {
        $tableName = $this->template->table;
        $fields = $data->first() ? array_keys((array) $data->first()) : [];

        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function ($table) use ($fields) {
                $table->increments('id');
                foreach ($fields as $field) {
                    $table->string($field)->nullable();
                }
                $table->timestamps();
            });
        } else {
            Schema::table($tableName, function ($table) use ($fields) {
                foreach ($fields as $field) {
                    if (!Schema::hasColumn($table->getTable(), $field)) {
                        $table->string($field)->nullable();
                    }
                }
            });
        }

        foreach ($data as $row) {
            DB::table($tableName)->insert((array) $row);
        }

        $this->fetchedData = $data->map(fn($item) => (array) $item)->toArray();
    }

    public function handleDataApproval($id)
    {
        $this->setActiveTab('dataApproval');

        $workFlow = WorkFlow::where('template_id', $id)->with('approvalStages')->first();
        $this->approvers = $workFlow->approvalStages;

        $user = Auth::user();

        $hasApproved = Approval::where('data_generation_id', $this->template->id)->where('user_id', Auth::user()->id)->first();

        if ($hasApproved) {
            $this->hasApprovedError = 'You have already approved this data.';
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
                    $this->dataGeneration->update(['status' => 'approved']);
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
            }
        }
    }

    public function handleDataIntegration($id)
    {
        $this->setActiveTab('dataIntegration');

        $submissionType = $this->template->submission_type;

        $response = [];

        if ($submissionType == 'zip') {
            $data = $this->dataGeneration->data;

            $response = Http::post('https://api.example.com/submit', [
                'data' => $data,
                'template_id' => $this->template->id,
                'submission_type' => $submissionType,
            ]);

            if ($response->successful()) {
                $this->dataGeneration->update(['status' => 'integrated']);
                // $this->integrationSuccessMessage = "Data integrated successfully";
            } else {
                // $this->integrationErrorMessage = "Data integration failed: " . $response->body();
            }
        } elseif ($submissionType == 'json') {
        } elseif ($submissionType == 'csv') {
        } else {
            return;
        }

        dd($submissionType);
    }

    public function handleDataArchival($id)
    {
        $this->setActiveTab('dataArchival');
    }
    public function render()
    {
        return view('livewire.templates.view-template');
    }

}
