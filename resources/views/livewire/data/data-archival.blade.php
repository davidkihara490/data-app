<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <button type="button" class="float-end btn btn-success btn-sm "
                    wire:click="handleDataArchival({{ $dataGeneration->id }})" wire:loading.attr="disabled"
                    wire:loading.class="bg-info">
                    <span wire:loading.remove>Archive Data</span>
                    <span wire:loading>Archiving...</span>
                </button>

                @if (!empty($errorsList))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errorsList as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($dataGeneration->dataArchival->count() == 0)
                    <div class="alert alert-danger">
                        <ul>
                            <li>This data has not been archived.</li>
                        </ul>
                    </div>
                @endif

                @if ($successMessage)
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ $successMessage }}</li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
