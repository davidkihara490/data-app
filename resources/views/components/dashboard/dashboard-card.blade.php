<div class="col-lg-6 col-xl-3">
    <a href="{{ $url }}" class="card h-100 text-decoration-none" style="color: inherit;">
        <div class="card-body p-4">
            {{-- Upper Section (2/3) --}}
            <div class="mb-4 row" style="height: 66%;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-3">
                        <h6 class="text-uppercase font-size-12 text-muted">{{ $title }}</h6>
                    </div>
                    <div>
                        <span
                            class="badge {{ $change < 0 ? 'bg-danger bg-opacity-10 text-danger' : 'bg-success bg-opacity-10 text-success' }}">
                            {{ $change }}%
                        </span>
                    </div>
                </div>
            </div>

            {{-- Lower Section (1/3) with Progress Steps --}}
            <div style="height: 34%;">
                <div class="d-flex justify-content-between">
                    @foreach (['G', 'V', 'AP', 'I' , 'AR'] as $step)
                        <div class="text-center">
                            <div class="d-flex justify-content-center mb-1">
                                <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                                    style="width: 24px; height: 24px;">
                                    <span class="text-muted font-bold"
                                        style="font-size: 11px;">{{ substr($step, 0, 1) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </a>
</div>
