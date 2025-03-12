<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">System Logs</h4>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>User</th>
                        </thead>
                        <tbody>
                            @foreach ($logs as $row)
                                <tr>
                                    <td>{{ $row->loggable_type }}</td>
                                    <td>{{ $row->date }} {{ $row->time }}</td>
                                    <td>{{ $row->status }}</td>
                                    <td>{{ $row->description }}</td>
                                    <td>{{ $row->user->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
