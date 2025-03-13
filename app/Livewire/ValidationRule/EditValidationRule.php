<?php

namespace App\Livewire\ValidationRule;

use App\Models\Template;
use App\Models\ValidationRule;
use App\Models\ValidationRuleColumn;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;

class EditValidationRule extends Component
{
    public $validationRule;
    public $template_id;
    public $fields = [];
    public $templates = [];

    public function mount($id)
    {
        $this->validationRule = ValidationRule::findOrFail($id);
        $this->template_id = $this->validationRule->template_id;
        $this->templates = Template::all();
        $this->fields = $this->validationRule->validationRuleColumns->map(fn($column) => [
            'id' => $column->id,
            'column' => $column->column,
            'rules' => json_decode($column->rules, true),
            'in_values' => '',
            'min_value' => '',
            'max_value' => '',
            'uuid' => (string) Str::uuid(),
        ])->toArray();
    }

    public function updateValidationRule()
    {
        $this->validate([
            'template_id' => 'required|exists:templates,id',
            'fields.*.column' => 'required|string',
            'fields.*.rules' => 'array|min:1',
            'fields.*.in_values' => 'nullable|string',
            'fields.*.min_value' => 'nullable|integer',
            'fields.*.max_value' => 'nullable|integer',
        ]);

        try {
            DB::beginTransaction();

            $this->validationRule->update(['template_id' => $this->template_id]);
            $this->validationRule->validationRuleColumns()->delete();

            $columns = array_map(function ($field) {
                $rules = $field['rules'];

                if (in_array('in', $rules) && !empty($field['in_values'])) {
                    $rules = array_filter($rules, fn($rule) => $rule !== 'in');
                    $rules[] = 'in:' . $field['in_values'];
                }
                if (in_array('min', $rules) && isset($field['min_value'])) {
                    $rules = array_filter($rules, fn($rule) => $rule !== 'min');
                    $rules[] = 'min:' . $field['min_value'];
                }
                if (in_array('max', $rules) && isset($field['max_value'])) {
                    $rules = array_filter($rules, fn($rule) => $rule !== 'max');
                    $rules[] = 'max:' . $field['max_value'];
                }

                return [
                    'column' => $field['column'],
                    'rules' => json_encode(array_values($rules)),
                ];
            }, $this->fields);

            $this->validationRule->validationRuleColumns()->createMany($columns);

            DB::commit();
            return redirect()->route(route: 'vr.index')->with('success', 'Validation rule updated successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route(route: 'vr.create')->with('error', 'Error updating validation rule: ' . $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.validation-rule.edit-validation-rule');
    }
}
