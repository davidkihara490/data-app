<?php

namespace App\Livewire\Templates;

use App\Models\Template;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class Templates extends Component
{
    use WithPagination;

    public ?string $search;

    public $deleteId;

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }
    public function delete()
    {
        $template = Template::findOrFail($this->deleteId);
        $template->delete();
        return redirect()->route('templates.index')->with(['success', 'Template has been deleted successfully']);
    }

    public function render()
    {
        $templates = Template::query()
            // ->orderByDesc('id')
            ->when(
                ! empty($this->search),
                fn(Builder $q) => $q->where('name', 'like', "%{$this->search}%")
            )
            ->get();
            // ->paginate(10);
        return view('livewire.templates.templates', [
            'templates' => $templates,
        ]);
    }
}
