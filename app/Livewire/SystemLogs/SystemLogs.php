<?php

namespace App\Livewire\SystemLogs;

use App\Models\SystemLog;
use Livewire\Component;

class SystemLogs extends Component
{
    public function render()
    {
        $logs = SystemLog::orderBy("created_at", "desc")->get();
        return view('livewire.system-logs.system-logs', [
            'logs'=> $logs
        ]);
    }
}
