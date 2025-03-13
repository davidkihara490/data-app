<div class="modal fade show d-block" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">{{ $title }}</h5>
                <button type="button" class="close float-end" wire:click="closeModal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $message }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModal">Cancel</button>
                <button type="button" class="btn btn-danger" wire:click="{{ $confirmMethod }}">Delete</button>
            </div>
        </div>
    </div>
</div>
