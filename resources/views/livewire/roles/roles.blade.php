<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a class="float-end btn btn-success btn-sm" href="{{ route('roles.create') }}">New</a>
            </div>
            <div class="card-body">
                <x-alerts.alerts />
                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
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
                                        <x-modals.delete :title="'Delete Role'" :message="'Are you sure you want to delete this role? Deleting this role will disassociate all users with this role.'" :confirmMethod="'deleteRole'" />
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
