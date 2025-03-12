<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a class="float-end btn btn-success btn-sm" href="{{ route('roles.create') }}">New</a>
            </div>
            <div class="card-body">
                <table class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Permissions</th>

                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->permissions->count() }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('roles.edit', $role->id) }}">
                                        Edit
                                    </a>

                                    <button wire:click="confirm({{ $role->id }})" class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                    <!-- Delete Confirmation Modal -->
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
                                                        Are you sure you want to delete this role?
                                                        Deleting this role will dissassociate all users with this role!
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            wire:click="closeModal">Cancel</button>
                                                        <button type="button" class="btn btn-danger"
                                                            wire:click="deleteRole">Delete</button>
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
        </div>
    </div>
</div>
