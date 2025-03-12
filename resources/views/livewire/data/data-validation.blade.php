<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="float-end btn btn-success btn-sm"
                    wire:click="handleDataValidation({{ $currentDataGeneration ? $currentDataGeneration->id : 'null' }})"
                    wire:loading.attr="disabled" wire:loading.class="bg-info">
                    <span wire:loading.remove>Validate Data</span>
                    <span wire:loading>validating...</span>
                </button>
            </div>
            <div class="card-body">
                @if (!empty($validationErrorList) && is_array($validationErrorList))
                    <ul>
                        @foreach ($validationErrorList as $rowIndex => $rowErrors)
                            @if (is_array($rowErrors))
                                @foreach ($rowErrors as $columnName => $messages)
                                    @if (is_array($messages))
                                        @foreach ($messages as $message)
                                            <li class="alert alert-danger">Row {{ $rowIndex + 1 }} -
                                                {{ ucfirst($columnName) }}:
                                                {{ $message }}</li>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                @else
                    <p class="text-danger">No validation errors found.</p>
                @endif
                @if ($validationSuccessMessage)
                    <div class="alert alert-success mt-3">
                        <ul>
                            <li>{{ $validationSuccessMessage }}</li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
