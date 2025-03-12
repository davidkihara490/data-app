<div class="col-12">
    <div class="card">
        <div class="card-header">
            <a class="float-end btn btn-success btn-sm" href="{{ route('workflows.create') }}">New</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Template</th>
                        <th>Stages</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workFlows as $workFlow)
                        <tr>
                            <td>{{ $workFlow->id }}</td>
                            <td>{{ $workFlow->name }}</td>
                            <td>{{ $workFlow->template->name }}</td>
                            <td>{{ $workFlow->stages }}</td>
                            <td class="text-end">
                                <a class="btn btn-info btn-sm"
                                    href="{{ route('workflows.edit', $workFlow->id) }}">Edit</a>
                                <button wire:click="confirm({{ $workFlow->id }})" class="btn btn-danger btn-sm">
                                    Delete
                                </button>

                                @if ($showDeleteModal)
                                    <div class="modal fade show d-block" tabindex="-1" role="dialog"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true"
                                        style="background: rgba(0,0,0,0.5);">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete
                                                    </h5>
                                                    <button type="button" class="close" wire:click="closeModal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this approval wokflow?
                                                    When deleted, you can't access the associated template!!
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        wire:click="closeModal">Cancel</button>
                                                    <button type="button" class="btn btn-danger"
                                                        wire:click="deleteWorkFlow">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- {{ $users->links() }} --}}
    </div>
</div>
