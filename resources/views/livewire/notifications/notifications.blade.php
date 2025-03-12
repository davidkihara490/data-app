<div class="col-12">
    <div class="card">
        <div class="card-header">
            <p class="header-title">Notifications</p>
        </div>
        <div class="card-body">
            @forelse (auth()->user()->notifications as $notification)
                <div class="card">
                    <div class="card-body">
                        <h5>{{ $notification->created_at->toDateTimeString() }}</h5>
                        <p>{{ $notification->data['message'] }}</p>

                        <a href="{{ $notification->data['link'] }}">Click to view</a>

                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <p>
                        You do not have any notifications
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>
