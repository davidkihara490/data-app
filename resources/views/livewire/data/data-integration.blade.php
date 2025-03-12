<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <button type="button" class="float-end btn btn-success btn-sm"
                            wire:click="handleDataIntegration({{ $dataGeneration ? $dataGeneration->id : 'null' }})"
                            wire:loading.attr="disabled" wire:loading.class="bg-info">
                            <span wire:loading.remove>Integrate Data</span>
                            <span wire:loading>Please wait...</span>
                        </button>
                    </div>
                </div>

            </div>
            <div class="card-body">
                @if ($integrationSuccessMessage)
                    <div class="alert alert-success mt-3">
                        <ul>
                            <li>{{ $approvalSuccessMessage }}</li>
                        </ul>
                    </div>
                @endif
                @if ($integrationErrorMessage)
                    <div class="alert alert-danger mt-3">
                        <ul>
                            <li>{{ $integrationErrorMessage }}</li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
