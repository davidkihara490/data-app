<?php

namespace App\Livewire\Data;

use App\Mail\ApprovalRequest;
use App\Models\DataGeneration;
use App\Models\DataValidation as ModelsDataValidation;
use App\Models\User;
use App\Models\ValidationRule;
use App\Models\ValidationError;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DataValidation extends Component
{
    public $template;
    public $dataGeneration;
    public $errorsList = [];
    public $successMessage;
    public $currentDataGeneration;
    public $validationErrorList = [];
    public $validationSuccessMessage;
    public $activeTab;

    public function mount($id)
    {
        $this->dataGeneration = DataGeneration::findOrFail($id);
        $this->template = $this->dataGeneration->template;
        $this->errorsList = $this->dataGeneration->validationErrors;
        $this->successMessage = null;

        $this->activeTab = 'dataValidation';

        $this->currentDataGeneration = $this->template->latestDataGeneration;

        $this->validationErrorList = $this->dataGeneration->validationErrors;
    }

    public function render()
    {
        return view('livewire.data.data-validation');
    }
    public function handleDataValidation($id)
    {

       $validationRules = ValidationRule::where('template_id', $this->template->id)
            ->with('validationRuleColumns')
            ->first();

        if (!$validationRules) {
            return ['errors' => ['Validation rules not found']];
        }

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
                $dataValidation = ModelsDataValidation::create([
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
                $this->dataGeneration->update(['validation' => 'error']);

                return;
            } else {
                $dataValidation = ModelsDataValidation::create([
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
                $this->dataGeneration->update(['validation', 'success']);


                $permissions = ['approve_data'];
                $usersWithPermission = User::permission($permissions)->get();

                foreach ($usersWithPermission as $user) {
                    Mail::to($user->email)->send(new ApprovalRequest($user));
                    $user->notify(new \App\Notifications\ApprovalRequest($this->template));
                }
            }
        } catch (\Throwable $th) {
            $dataValidation = ModelsDataValidation::create([
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
                'loggable_type' => ModelsDataValidation::class,
                'loggable_id' => $dataValidation->id,
            ]);

            $this->validationErrorList = $th->getMessage();
            $this->dataGeneration->update(['validation' => 'error']);
        }
    }
}
