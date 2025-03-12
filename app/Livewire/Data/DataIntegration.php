<?php

namespace App\Livewire\Data;

use App\Models\DataGeneration;
use App\Models\DataIntegration as ModelsDataIntegration;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use ZipArchive;

class DataIntegration extends Component
{

    public $template;

    public $dataGeneration;

    public $errorsList = [];
    public $successMessage;

    public $activeTab;
    public $integrationSuccessMessage;
    public $integrationErrorMessage;

    public function mount($id)
    {
        $this->activeTab = 'dataIntegration';

        $this->dataGeneration = DataGeneration::findOrFail($id);

        $this->template = $this->dataGeneration->template;

        $this->errorsList = [];
        $this->successMessage = null;

        $this->integrationSuccessMessage = null;
        $this->integrationErrorMessage = null;
    }
    public function render()
    {
        return view('livewire.data.data-integration');
    }


    public function handleDataIntegration($id)
{
    $submissionType = $this->template->submission_type;
    $templateName = str_replace(' ', '_', $this->template->name); // Remove spaces from template name
    $date = now()->format('Ymd'); // Format date as YYYYMMDD
    $response = [];
    $data = $this->dataGeneration->data;

    try {
        if ($submissionType == 'zip') {
            try {
                $zipFilePath = storage_path("app/public/files/{$templateName}_{$date}.zip");
                $this->ensureDirectoryExists(storage_path('app/public/files'));

                // Delete existing file
                if (file_exists($zipFilePath)) {
                    unlink($zipFilePath);
                }

                $this->createZipFromData($data, $zipFilePath);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            $response = $this->postZipToApi($zipFilePath);

        } elseif ($submissionType == 'json') {
            $jsonFilePath = storage_path("app/public/files/{$templateName}_{$date}.json");
            $this->ensureDirectoryExists(storage_path('app/public/files'));

            // Delete existing file
            if (file_exists($jsonFilePath)) {
                unlink($jsonFilePath);
            }

            file_put_contents($jsonFilePath, json_encode($data, JSON_PRETTY_PRINT));

            $response = Http::attach(
                'file',
                fopen($jsonFilePath, 'r'),
                basename($jsonFilePath)
            )->post(env('API_URL') . '/send_data_as_json');

        } elseif ($submissionType == 'csv') {
            $csvFilePath = storage_path("app/public/files/{$templateName}_{$date}.csv");
            $this->ensureDirectoryExists(storage_path('app/public/files'));

            // Delete existing file
            if (file_exists($csvFilePath)) {
                unlink($csvFilePath);
            }

            file_put_contents($csvFilePath, $this->convertDataToCsv($data));

            $response = Http::attach(
                'file',
                fopen($csvFilePath, 'r'),
                basename($csvFilePath)
            )->post(env('API_URL') . '/send_data_as_csv');
        }

        // dd($response);

        if ($response) {
            $this->dataGeneration->update(['integration' => 'success']);
            $this->integrationSuccessMessage = "Data integrated successfully";
        } else {
            $this->dataGeneration->update(['integration' => 'error']);
            // $this->integrationErrorMessage = "Data integration failed: " . $response->body();
            $this->integrationErrorMessage = "Data integration failed. Please check the data and extention type. ";
        }


    } catch (\Throwable $th) {
        $this->dataGeneration->update(['integration' => 'error']);
        $this->integrationErrorMessage = "Data integration failed: " . $th->getMessage();
    }
}

public function createZipFromData($data, $zipFilePath)
{
    $zip = new ZipArchive();
    if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
        $zip->addFromString('data.json', json_encode($data));
        $zip->close();
    } else {
        throw new \Exception('Failed to create ZIP file');
    }
}

    // public function handleDataIntegration($id)
    // {
    //     $submissionType = $this->template->submission_type;
    //     $response = [];
    //     $data = $this->dataGeneration->data;

    //     try {
    //         if ($submissionType == 'zip') {
    //             try {
    //                 $zipFilePath = storage_path('app/public/files/data.zip');
    //                 // Ensure the directory exists
    //                 $this->ensureDirectoryExists(storage_path('app/public/files'));

    //                 $this->createZipFromData($data, $zipFilePath);
    //             } catch (\Exception $e) {
    //                 return response()->json(['error' => $e->getMessage()], 500);
    //             }

    //             $response = $this->postZipToApi($zipFilePath);

    //             if ($response->successful()) {
    //                 $this->dataGeneration->update(['integration' => 'success']);
    //                 $this->integrationSuccessMessage = "Data integrated successfully";
    //             } else {
    //                 $this->dataGeneration->update(['integration' => 'error']);
    //                 $this->integrationErrorMessage = "Data integration failed: " . $response->body();
    //             }
    //         } elseif ($submissionType == 'json') {
    //             $response = Http::post(env('API_URL') . '/send_data_as_json', [
    //                 'data' => json_encode($data),
    //             ]);

    //             if ($response->successful()) {
    //                 $this->dataGeneration->update(['integration' => 'success']);
    //                 $this->integrationSuccessMessage = "Data integrated successfully";
    //             } else {
    //                 $this->dataGeneration->update(['integration' => 'error']);
    //                 $this->integrationErrorMessage = "Data integration failed: " . $response->body();
    //             }
    //         } elseif ($submissionType == 'csv') {
    //             // Convert data into CSV format
    //             $csvContent = $this->convertDataToCsv($data);

    //             // Define API URL
    //             $apiUrl = env('API_URL') . '/send_data_as_csv';  // Replace with your API endpoint

    //             // Define additional headers if needed
    //             $headers = [
    //                 // 'Authorization' => 'Bearer YOUR_ACCESS_TOKEN',
    //                 'Content-Type' => 'multipart/form-data',
    //             ];

    //             $response = Http::withHeaders($headers)->attach(
    //                 'file',
    //                 $csvContent,
    //                 'data.csv'
    //             )->post($apiUrl);
                
    //             if ($response->successful()) {
    //                 $this->dataGeneration->update(['integration' => 'success']);
    //                 $this->integrationSuccessMessage = "Data integrated successfully";
    //             } else {
    //                 $this->dataGeneration->update(['integration' => 'error']);
    //                 $this->integrationErrorMessage = "Data integration failed: " . $response->body();
    //             }
    //         } else {
    //             return;
    //         }
    //     } catch (\Throwable $th) {
    //         $this->dataGeneration->update(['integration' => 'error']);
    //         $this->integrationErrorMessage = "Data integration failed: " . $th->getMessage();
    //         // throw $th;
    //     }
    // }


    public function convertDataToCsv($data)
    {
        // Open a file in memory for writing the CSV data
        $csvFile = fopen('php://temp', 'r+');

        // Add the data to the CSV file
        foreach ($data as $row) {
            fputcsv($csvFile, $row);
        }

        // Reset the pointer to the beginning of the file
        rewind($csvFile);

        // Get the CSV content as a string
        $csvContent = stream_get_contents($csvFile);

        // Close the file
        fclose($csvFile);

        return $csvContent;  // Return the CSV content
    }

    // function createZipFromData($data, $zipFilePath)
    // {
    //     $zip = new ZipArchive();
    //     if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
    //         // Add data to the zip file (for example, a JSON file)
    //         $zip->addFromString('data.json', json_encode($data));

    //         // You can add more files here if needed, for example, CSV files
    //         // $zip->addFromString('file.csv', $csvContent);

    //         // Close the zip file
    //         $zip->close();
    //     } else {
    //         throw new \Exception('Failed to create ZIP file');
    //     }
    // }

    // // Ensure the directory exists before writing the file
    private function ensureDirectoryExists($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0777, true); // Create the directory with read/write/execute permissions
        }
    }
    function postZipToApi($zipFilePath)
    {
        // API endpoint
        $url = env('API_URL') . '/send_data_as_zip';

        // Prepare headers and form data
        $response = Http::withHeaders([
            // 'Authorization' => 'Bearer your-access-token',
            'Accept' => 'application/json',
        ])
            ->attach('file', fopen($zipFilePath, 'r'), basename($zipFilePath))
            ->post($url);

        // Handle the response
        return $response;
    }


    // public function handleDataIntegration($id)
    // {

    // try {
    //     $dataIntegration = ModelsDataIntegration::create([
    //         'data_generation_id' => $this->dataGeneration->id,
    //         'template_id' => $this->template->id,
    //         'date'  => now()->toDateString(),
    //         'time'  => now()->toTimeString(),
    //         'mode'  => 'api',
    //         'status' => 'completed',
    //     ]);

    //     $dataIntegration->systemLogs()->create([
    //         'date' => now()->toDateString(),
    //         'time' => now()->toTimeString(),
    //         'status' => 'success',
    //         'description' => "data was integrated successfully",
    //         'user_id' => auth()->user()->id,
    //         'loggable_type' => \App\Models\DataIntegration::class,
    //         'loggable_id' => $dataIntegration->id,
    //     ]);
    //     $this->successMessage = "Data validated successfully";
    // } catch (\Throwable $th) {
    //     $dataIntegration = ModelsDataIntegration::create([
    //         'data_generation_id' => $this->dataGeneration->id,
    //         'template_id' => $this->template->id,
    //         'date'  => now()->toDateString(),
    //         'time'  => now()->toTimeString(),
    //         'mode'  => 'api',
    //         'status' => 'failed',
    //     ]);

    //     $dataIntegration->systemLogs()->create([
    //         'date' => now()->toDateString(),
    //         'time' => now()->toTimeString(),
    //         'status' => 'failed',
    //         'description' => "Error during data integration: " . $th->getMessage(),
    //         'user_id' => auth()->user()->id,
    //         'loggable_type' => \App\Models\DataIntegration::class,
    //         'loggable_id' => $dataIntegration->id,
    //     ]);
    //     $this->errorsList = $th->getMessage();
    // }


    // try{
    //     if (!empty($errors)) {
    //         $dataValidation = ModelsDataValidation::create([
    //             'data_generation_id' => $this->dataGeneration->id,
    //             'template_id' => $this->template->id,
    //             'date' => now()->toDateString(),
    //             'time' => now()->toTimeString(),
    //             'status' => 'failed',
    //             // 'user_id' => auth()->user()->id,
    //         ]);
    //         $dataValidation->systemLogs()->create([
    //             'date' => now()->toDateString(),
    //             'time' => now()->toTimeString(),
    //             'status' => 'failed',
    //             'description' => $errors,
    //             'user_id' => auth()->user()->id,
    //             'loggable_type' => ModelsDataValidation::class,
    //             'loggable_id' => $dataValidation->id,
    //         ]);
    //         $this->errorsList = $errors;
    //         return;
    //     }else{
    //         $dataValidation = ModelsDataValidation::create([

    //             'data_generation_id' => $this->dataGeneration->id,
    //             'template_id' => $this->template->id,
    //             'date' => now()->toDateString(),
    //             'time' => now()->toTimeString(),
    //             'status' => 'completed',
    //             // 'user_id' => auth()->user()->id,
    //         ]);
    //         $dataValidation->systemLogs()->create([
    //             'date' => now()->toDateString(),
    //             'time' => now()->toTimeString(),
    //             'status' => 'failed',
    //             'description' => "Validated data successfully",
    //             'user_id' => auth()->user()->id,
    //             'loggable_type' => ModelsDataValidation::class,
    //             'loggable_id' => $dataValidation->id,
    //         ]);
    //         $this->successMessage = "Data validated successfully";
    //     }
    // }catch(\Throwable $th){
    //     $dataValidation = ModelsDataValidation::create([
    //         'data_generation_id' => $this->dataGeneration->id,
    //         'template_id' => $this->template->id,
    //         'date' => now()->toDateString(),
    //         'time' => now()->toTimeString(),
    //         'status' => 'failed',
    //         // 'user_id' => auth()->user()->id,
    //     ]);
    //     $dataValidation->systemLogs()->create([
    //         'date' => now()->toDateString(),
    //         'time' => now()->toTimeString(),
    //         'status' => 'error',
    //         'description' => "Error during data validation: " . $th->getMessage(),
    //         'user_id' => auth()->user()->id,
    //         'loggable_type' => ModelsDataValidation::class,
    //         'loggable_id' => $dataValidation->id,
    //     ]);
    //     $this->errorsList = $th->getMessage();
    // }
    // }
}
