<div class="col-12">
    <div class="card">
        <div class="card-header">
            <a class="float-end btn btn-success btn-sm" href="{{ route('templates.edit') }}">New</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif
            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 50%;">Name</th>
                        <th style="width: 25%;">Table</th>
                        <th style="width: 10%;">Frequency</th>
                        <th style="width: 10%;">Submission Type</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($templates as $template)
                        <tr>
                            <td>{{ $template->id }}</td>
                            <td>{{ $template->name }}</td>
                            <td>{{ $template->table }}</td>
                            <td>{{ $template->frequency }}</td>
                            <td>{{ strtoupper($template->submission_type) }}</td>
                            <td class="text-end d-flex justify-content-end gap-2">
                                <a class="btn btn-info btn-sm" href="{{ route('templates.edit', $template->id) }}">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" wire:click="confirmDelete({{ $template->id }})" data-bs-toggle="modal" data-bs-target="#deleteTemplate">Delete</button>
                            </td>
                            {{-- <td class="text-end">
                                <a class="btn btn-info btn-sm"
                                    href="{{ route('templates.edit', $template->id) }}">Edit</a>
                                <a class="btn btn-secondary btn-sm"
                                    href="{{ route('templates.view', $template->id) }}">View</a>
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="confirmDelete({{ $template->id }})" data-bs-toggle="modal"
                                    data-bs-target="#deleteTemplate">Delete</button>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>

        {{-- <x-layouts.pagination>
            {{ $templates->links() }}
        </x-layouts.pagination> --}}
    </div>
</div>