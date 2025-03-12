<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    @role('super-admin')
                        <div class="col-6">
                            <h4 class="header-title">Approvals History</h4>
                            <h4 class="header-title">Approval Status :
                                {{ $approvals ? $approvals->count() : 0 }} / {{ $approvers ? $approvers->count() : 0 }}
                            </h4>
                        </div>
                    @endrole
                    <div class="col-6">
                        <button type="button" class="float-end btn btn-success btn-sm"
                            wire:click="handleDataApproval({{ $dataGeneration ? $dataGeneration->id : 'null' }})"
                            wire:loading.attr="disabled" wire:loading.class="bg-info">
                            <span wire:loading.remove>Approve Data</span>
                            <span wire:loading>Approving...</span>
                        </button>
                    </div>
                </div>

            </div>
            <div class="card-body">
                @if (!empty($approvalErrorList))
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($approvalErrorList as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if ($approvalSuccessMessage)
                    <div class="alert alert-success mt-3">
                        <ul>
                            <li>{{ $approvalSuccessMessage }}</li>
                        </ul>
                    </div>
                @endif
                @if ($hasApprovedError)
                    <div class="alert alert-danger mt-3">
                        <ul>
                            <li>{{ $hasApprovedError }}</li>
                        </ul>
                    </div>
                @endif

                @role('super-admin')
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>#</th>
                                <th>User</th>
                                <th>Stage</th>
                                <th>Status</th>
                                <th>Date</th>
                            </thead>
                            <tbody>
                                @foreach ($approvals as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->user->name }}</td>
                                        <td>{{ $row->stage }}</td>
                                        <td>{{ $row->status }}</td>
                                        <td>{{ $row->date }} : {{ $row->time }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endrole
            </div>
        </div>
    </div>
</div>
