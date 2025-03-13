<div class="col-12">
    <div class="card">
        <div class="card-header">
            <a class="float-end btn btn-success btn-sm" href="{{ route('vr.create') }}">New</a>
        </div>
        <div class="card-body">
            <x-alerts.alerts />
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
                                    wire:click="confirm({{ $validationRule->id }})">Delete</button>

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
        @if ($showDeleteModal)
            <x-modals.delete :title="'Delete Validation Rule'" :message="'Are you sure you want to delete this rule? Deleting this rule will disassociate all templates with this rule.'" :confirmMethod="'deleteWorkFlow'" />
        @endif
    </div>
</div>
