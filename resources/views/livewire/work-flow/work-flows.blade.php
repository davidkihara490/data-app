<div class="col-12">
    <div class="card">
        <div class="card-header">
            <a class="float-end btn btn-success btn-sm" href="{{ route('workflows.create') }}">New</a>
        </div>
        <div class="card-body">
            <x-alerts.alerts />
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
                    @forelse ($workFlows as $workFlow)
                        <tr>
                            <td>{{ $workFlow->id }}</td>
                            <td>{{ $workFlow->name }}</td>
                            <td>{{ $workFlow->template->name }}</td>
                            <td>{{ $workFlow->stages }}</td>
                            <td class="text-end">
                                <a class="btn btn-info btn-sm"
                                    href="{{ route('workflows.edit', $workFlow->id) }}">Edit</a>
                                <button wire:click="confirm({{ $workFlow->id }})"
                                    class="btn btn-danger btn-sm">Delete</button>
                                @if ($showDeleteModal)
                                    <x-modals.delete :title="'Delete WorkFlow'" :message="'Are you sure you want to delete this work flow? Deleting this workflow  will disassociate all templetes with this workflow.'" :confirmMethod="'deleteWorkFlow'" />
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No workflows found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
