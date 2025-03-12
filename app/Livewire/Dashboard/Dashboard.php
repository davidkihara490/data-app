<?php

namespace App\Livewire\Dashboard;

use App\Models\Template;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class Dashboard extends Component
{

    public $selectedDate;

    public function mount(){
        $this->selectedDate = now()->toDateString();
    }

    public function render()
    {
        $templates = Template::query()
            // ->when(
            //     !empty($this->selectedDate),
            //     fn(Builder $q) => $q->whereHas('latestDataGeneration', function ($query) {
            //         $query->whereDate('created_at', $this->selectedDate);
            //     })
            // )
            ->with([
                'latestDataGeneration',
                'latestValidation',
                'latestApproval',
                'latestIntegration',
                'latestArchival'
            ])->get();

            // dd($templates);



        // $templates = Template::query()
        //     // ->orderByDesc('id')
        //     ->when(
        //         ! empty($this->search),
        //         fn(Builder $q) => $q->where('created_at', 'like', "%{$this->selectedDate}%")
        //     )->with([
        //         'latestDataGeneration',
        //         'latestValidation',
        //         'latestApproval',
        //         'latestIntegration',
        //         'latestArchival'
        //     ])->get();
        return view('livewire.dashboard.dashboard',  [
            'templates' => $templates
        ]);
    }
}
