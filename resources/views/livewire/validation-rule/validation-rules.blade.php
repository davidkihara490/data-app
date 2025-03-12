<div class="col-12">
    <div class="card">
        <div class="card-header">
            <a class="float-end btn btn-success btn-sm" href="{{ route('vr.create') }}">New</a>
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
                        <th>Template</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($validationRules as $validationRule)
                        <tr>
                            <td>{{ $validationRule->id }}</td>
                            <td>{{ $validationRule->template->name }}</td>
                            <td class="text-end">
                                <a class="btn btn-info btn-sm"
                                    href="{{ route('vr.edit', $validationRule->id) }}">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="confirmDelete({{ $validationRule->id }})" data-bs-toggle="modal"
                                    data-bs-target="#deleteValidationRule">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                No rules were found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <x-layouts.modal id="deleteValidationRule" title="Are you sure you want to delete this validation rule?">
        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Cancel</button>
        <button type="button" wire:click="delete" class="btn btn-info waves-effect waves-light">Delete</button>
    </x-layouts.modal>
</div>
