<?php

namespace App\Livewire\ValidationRule;

use App\Models\Template;
use App\Models\ValidationRule;
use App\Models\ValidationRuleColumn;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;

class CreateValidationRule extends Component
{
    public ValidationRule $validationRule;
    public $template_id;
    public $fields = [];
    public $templates = [];

    public function mount()
    {
        $this->validationRule = $validationRule ?? new ValidationRule();
        $this->template_id = $this->validationRule->template_id;
        $this->templates = Template::all();
        $this->fields = $this->validationRule->validationRuleColumns->map(fn($column) => [
            'id' => $column->id,
            'column' => $column->column,
            'rules' => json_decode($column->rules, true),
            'in_values' => '',
            'uuid' => (string) Str::uuid(),
        ])->toArray();
    }

    public function addColumn()
    {
        $this->fields[] = [
            'id' => null,
            'column' => '',
            'rules' => [],
            'in_values' => '',
            'uuid' => (string) Str::uuid()
        ];
    }

    public function removeColumn($index)
    {
        unset($this->fields[$index]);
        $this->fields = array_values($this->fields); // Re-index array
    }

    public function saveValidationRule()
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

            $validationRule = ValidationRule::create([
                'template_id' => $this->template_id,
            ]);

            $columns = array_map(function ($field) {
                $rules = $field['rules'];

                // Append "in" values
                if (in_array('in', $rules) && !empty($field['in_values'])) {
                    $rules = array_filter($rules, fn($rule) => $rule !== 'in'); // Remove plain "in"
                    $rules[] = 'in:' . $field['in_values'];
                }

                // Append "min" values
                if (in_array('min', $rules) && isset($field['min_value'])) {
                    $rules = array_filter($rules, fn($rule) => $rule !== 'min'); // Remove plain "min"
                    $rules[] = 'min:' . $field['min_value'];
                }

                // Append "max" values
                if (in_array('max', $rules) && isset($field['max_value'])) {
                    $rules = array_filter($rules, fn($rule) => $rule !== 'max'); // Remove plain "max"
                    $rules[] = 'max:' . $field['max_value'];
                }

                return [
                    'column' => $field['column'],
                    'rules' => json_encode(array_values($rules)), // Ensure unique rules
                ];
            }, $this->fields);

            $validationRule->validationRuleColumns()->createMany($columns);

            DB::commit();

            return redirect()->route('vr.index')->with('success', 'Validation rule saved successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
    public function render()
    {
        return view('livewire.validation-rule.create-validation-rule');
    }
}
