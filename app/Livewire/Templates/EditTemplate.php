<?php

namespace App\Livewire\Templates;

use Livewire\Component;
use App\Models\Template;

class EditTemplate extends Component
{
    public $template;
    public $name;
    public $frequency;
    public $table;
    public $submission_type;

    public function mount(?int $id = null)
    {
        $this->template = $id ? Template::findOrFail($id) : new Template;
        $this->name = $this->template->name;
        $this->frequency = $this->template->frequency;
        $this->table = $this->template->table;
        $this->submission_type = $this->template->submission_type;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'frequency' => 'required|string',
            'table' => 'required|string',
            'submission_type' => 'nullable|in:zip,json,csv'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'frequency.required' => 'Frequency is required',
            'table.required' => 'Table is required',
            'submission_type.in' => 'The submission type must be one of the following: zip, json, csv',
        ];
    }
    public function submit()
    {
        try {
            $this->validate();
            $this->template->name = $this->name;
            $this->template->frequency = $this->frequency;
            $this->template->table = $this->table;
            $this->template->submission_type = $this->submission_type;
            $this->template->save();
            return redirect()->route('templates.index')->with(['success' => 'Template saved successfully.']);
        } catch (\Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.templates.edit-template');
    }
}
