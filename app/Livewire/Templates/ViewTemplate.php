<?php

namespace App\Livewire\Templates;

use App\Models\{DataGeneration, SystemLog, Template};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;

class ViewTemplate extends Component
{
    public $selectedDate;
    public $activeTab = 'dataGeneration';
    public $template;
    public $dataGeneration;
    public $latestGeneratedData = [];
    public $errorsList = [];
    public $approvalErrorList = [];
    public $approvalSuccessMessage;
    public $dataFetchingStatus = false;
    public $dataGenerationStatus = false;
    public $hasApprovedError;
    public function mount($id)
    {
        $this->selectedDate = Carbon::now()->toDateString();
        $this->template = Template::findOrFail($id);
        $this->dataGeneration = DataGeneration::where('template_id', $id)
            ->whereDate('date', $this->selectedDate)
            ->first();
        $this->latestGeneratedData = $this->dataGeneration->data ?? [];
        $this->dataFetchingStatus = !empty($this->latestGeneratedData);
        $this->dataGenerationStatus = DataGeneration::where('template_id', $id)
            ->whereDate('date', now()->toDateString())->exists();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function handleDataGeneration($id)
    {
        $this->setActiveTab('dataGeneration');
        try {
            DB::connection('second_db')->table("{$this->template->table}")->where('processing_date', $this->selectedDate)->update([
                'processing_status' => 'processing'
            ]);

            $data = DB::connection('second_db')->table("{$this->template->table}")->where('processing_date', operator: $this->selectedDate)->get();
            $dataExists = DataGeneration::where('template_id', $id)->whereDate('date', $this->selectedDate)->first();

            
            if ($dataExists) {
                $dataExists->update([
                    'data' => $data,
                    'time' => now()->toTimeString(),
                    'status' => $data->isNotEmpty() ? 'completed' : 'failed',
                    'user_id' => Auth::id(),
                ]);
            } else {
                DataGeneration::create([
                    'template_id' => $id,
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                    'data' => $data,
                    'status' => $data->isNotEmpty() ? 'completed' : 'failed',
                    'user_id' => Auth::id()
                ]);
            }

            $fetchedData = DataGeneration::where('template_id', $id)->whereDate('date', $this->selectedDate)->first();

            if ($fetchedData) {
                $this->dataFetchingStatus = true;
            }

            // TODO::uncomment this later

            $this->dataGeneration->systemLogs()->create([
                'date' => now()->toDateString(),
                'time' => now()->toTimeString(),
                'status' => $data->isNotEmpty() ? 'success' : 'failed',
                'description' => $data->isNotEmpty() ? "Data fetched successfully" : "Fetching data failed",
                'user_id' => Auth::id(),
                'loggable_type' => DataGeneration::class,
                'loggable_id' => $this->dataGeneration->id,
            ]);

            $this->latestGeneratedData = $this->dataGeneration->data ?? [];
            $this->dataFetchingStatus = !empty($this->latestGeneratedData);
        } catch (\Throwable $th) {
            // dd($th);
            // TODO::uncomment this later

            // SystemLog::create([
            //     'date' => now()->toDateString(),
            //     'time' => now()->toTimeString(),
            //     'status' => 'failed',
            //     'description' => "Error during data fetching: " . $th->getMessage(),
            //     'user_id' => Auth::id(),
            //     'loggable_type' => DataGeneration::class,
            //     'loggable_id' => $this->dataGeneration->id,
            // ]);
        }
    }

    public function resetData($id)
    {
        try {
            DB::connection('second_db')->table("{$this->template->table}")->where('processing_date', $this->selectedDate)->update([
                'processing_status' => null
            ]);

            $this->dataGeneration = DataGeneration::where('template_id', $id)
                ->whereDate('date', $this->selectedDate)->first()
                ->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }

        $this->dataFetchingStatus = false;
    }

    public function render()
    {
        return view('livewire.templates.view-template');
    }
}
