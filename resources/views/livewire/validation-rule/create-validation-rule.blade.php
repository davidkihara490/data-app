<div class="col-12">
    <form wire:submit.prevent="saveValidationRule">
        <div class="card">
            <div class="card-body">
                <x-alerts.alerts />
                <div>
                    <div class="mb-3">
                        <label class="form-label">Select Template</label>
                        <select class="form-control" wire:model="template_id">
                            <option>--Select an option--</option>
                            @foreach ($templates as $template)
                                <option value="{{ $template->id }}">{{ $template->name }}</option>
                            @endforeach
                        </select>
                        @error('template_id')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <label class="form-label">Add validation rules for each column of the template</label>
                    @foreach ($fields as $index => $field)
                        <div class="row mb-3 border p-3 rounded align-items-center" wire:key="{{ $index }}">
                            <div class="col-md-4">
                                <label for="column_name_{{ $index }}" class="form-label">Column Name:</label>
                                <input type="text" id="column_name_{{ $index }}" class="form-control"
                                    wire:model="fields.{{ $index }}.column">
                                @error("fields.{{ $index }}.column")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Validation Rules:</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach (['required', 'string', 'integer', 'min', 'max', 'email', 'array', 'in'] as $rule)
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input"
                                                wire:model.live.debounce.750ms="fields.{{ $index }}.rules"
                                                value="{{ $rule }}"
                                                wire:click="$dispatch('toggle-rule-values', {{ $index }})">
                                            {{ $rule }}
                                        </label>
                                    @endforeach
                                </div>
                                @error("fields.$index.rules")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Input for "in" rule --}}
                            @if (in_array('in', $fields[$index]['rules'] ?? []))
                                <div class="col-md-6 mt-2">
                                    <label for="in_values_{{ $index }}" class="form-label">Allowed Values (comma-separated):</label>
                                    <input type="text" id="in_values_{{ $index }}" class="form-control" wire:model="fields.{{ $index }}.in_values">
                                    @error("fields.$index.in_values")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            {{-- Input for "min" rule --}}
                            @if (in_array('min', $fields[$index]['rules'] ?? []))
                                <div class="col-md-6 mt-2">
                                    <label for="min_value_{{ $index }}" class="form-label">Minimum Value:</label>
                                    <input type="number" id="min_value_{{ $index }}" class="form-control" wire:model="fields.{{ $index }}.min_value">
                                    @error("fields.$index.min_value")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            {{-- Input for "max" rule --}}
                            @if (in_array('max', $fields[$index]['rules'] ?? []))
                                <div class="col-md-6 mt-2">
                                    <label for="max_value_{{ $index }}" class="form-label">Maximum Value:</label>
                                    <input type="number" id="max_value_{{ $index }}" class="form-control" wire:model="fields.{{ $index }}.max_value">
                                    @error("fields.$index.max_value")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <div class="col-md-2 d-flex justify-content-end">
                                <button wire:click.prevent="removeColumn({{ $index }})"
                                    class="btn btn-danger mt-4">
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                    <button type="button" wire:click.prevent="addColumn" class="btn btn-primary mt-3">
                        Add Field
                    </button>
                    <button class="btn btn-success mt-3">
                        Save Validation Rules
                    </button>
                    @if (session()->has('message'))
                        <div class="mt-3 text-success">{{ session('message') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
