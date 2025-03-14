<div class="col-12">
    <div class="card">
        <div class="card-header">
            <a class="float-end btn btn-success btn-sm" href="{{ route('users.create') }}">New</a>
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
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->getRoleNames()->implode(', ') }}</td>
                            <td class="text-end">
                                <a class="btn btn-info btn-sm" href="{{ route('users.edit', $user->id) }}">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="confirm({{ $user->id }})">Delete</button>
                                @if ($showDeleteModal)
                                    <x-modals.delete :title="'Delete User'" :message="'Are you sure you want to delete this user?'" :confirmMethod="'deleteUser'" />
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
