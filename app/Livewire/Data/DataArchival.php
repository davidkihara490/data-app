<?php

namespace App\Livewire\Data;

use App\Models\DataArchival as ModelsDataArchival;
use App\Models\DataGeneration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class DataArchival extends Component
{

    public $template;

    public $dataGeneration;

    public $errorsList = [];
    public $successMessage;

    public $activeTab;

    public function mount($id)
    {
        $this->dataGeneration = DataGeneration::findOrFail($id);

        $this->template = $this->dataGeneration->template;

        $this->errorsList = [];
        $this->successMessage = null;
    }
    public function render()
    {
        return view('livewire.data.data-archival');
    }

    public function handleDataArchival($id)
    {
        try {

            $this->saveValidData($this->dataGeneration->data);
            $dataArchival = ModelsDataArchival::create([
                'data_generation_id' => $this->dataGeneration->id,
                'template_id' => $this->template->id,
                'date' => now()->toDateString(),
                'time'  => now()->toTimeString(),
                'status' => 'completed',
            ]);

            $dataArchival->systemLogs()->create([
                'date' => now()->toDateString(),
                'time' => now()->toTimeString(),
                'status' => 'success',
                'description' => "Data was archived successfully",
                'user_id' => auth()->user()->id,
                'loggable_type' => ModelsDataArchival::class,
                'loggable_id' => $dataArchival->id,
            ]);
            $this->successMessage = "Data archived successfully";
            $this->dataGeneration->update(['archival' => 'success']);
        } catch (\Throwable $th) {
            $dataArchival = ModelsDataArchival::create([
                'data_generation_id' => $this->dataGeneration->id,
                'template_id' => $this->template->id,
                'date'  => now()->toDateString(),
                'time'  => now()->toTimeString(),
                'status' => 'failed',
            ]);

            $dataArchival->systemLogs()->create([
                'date' => now()->toDateString(),
                'time' => now()->toTimeString(),
                'status' => 'failed',
                'description' => "Error during data archiving: " . $th->getMessage(),
                'user_id' => auth()->user()->id,
                'loggable_type' => ModelsDataArchival::class,
                'loggable_id' => $dataArchival->id,
            ]);
            $this->errorsList = $th->getMessage();
            $this->dataGeneration->update(['archival' => 'error']);
        }
    }

    private function saveValidData($data)
    {
        // Check if $data is an array or object
        if (!is_array($data) && !is_object($data)) {
            throw new \InvalidArgumentException('Expected data to be an array or object, received ' . gettype($data));
        }

        $tableName = $this->template->table;
        $fields = is_array($data) && count($data) > 0 ? array_keys((array) $data[0]) : [];

        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function ($table) use ($fields) {
                $table->increments('id');
                // Add dynamic fields
                foreach ($fields as $field) {
                    $table->string($field)->nullable();
                }
                // Explicitly add created_at and updated_at columns
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });
        } else {
            Schema::table($tableName, function ($table) use ($fields) {
                foreach ($fields as $field) {
                    if (!Schema::hasColumn($table->getTable(), $field)) {
                        $table->string($field)->nullable();
                    }
                }
                // Ensure created_at and updated_at columns exist
                if (!Schema::hasColumn($table->getTable(), 'created_at')) {
                    $table->timestamp('created_at')->nullable();
                }
                if (!Schema::hasColumn($table->getTable(), 'updated_at')) {
                    $table->timestamp('updated_at')->nullable();
                }
            });
        }

        // If $data is an array of objects, iterate over it
        foreach ($data as $row) {
            DB::table($tableName)->insert(array_merge((array) $row, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}