<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form wire:submit="submit">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Fill in the details</h4>
                                    <div class="row">
                                        @if (session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show"
                                                role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input class="form-control" type="text" id=""
                                                        wire:model="name" placeholder="Template Name">
                                                    @error('name')
                                                        <div style="color: red;">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Table Name</label>
                                                    <input class="form-control" type="text" id=""
                                                        wire:model="table" placeholder="table_name">
                                                    @error('table')
                                                        <div style="color: red;">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Select Frequency</label> <br />
                                                <select class="form-control" wire:model="frequency">
                                                    <option>--Select an option--</option>
                                                    @foreach (['Daily', 'Weekly', 'Monthly', 'Quarterly', 'Biannually', 'Annually'] as $frequency)
                                                        <option value="{{ strtolower($frequency) }}">
                                                            {{ $frequency }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('frequency')
                                                    <div style="color: red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Select Submission Type</label> <br />
                                                <select class="form-control" wire:model="submission_type">
                                                    <option>--Select an option--</option>
                                                    @foreach (['zip', 'json', 'csv'] as $submision_type)
                                                        <option value="{{ strtolower($submision_type) }}">
                                                            {{ $submision_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('submision_type')
                                                    <div style="color: red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-success" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Save</span>
                                        <span wire:loading>Saving...</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>