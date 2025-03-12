<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Edit Role</h4>

                @if (session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form wire:submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label">Role Name</label>
                        <input class="form-control" type="text" wire:model="name">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <h5>Select Permissions</h5>
                        <div class="row g-3">
                            @foreach ($permissions as $id => $permission)
                                <div class="col-md-4">
                                    <label class="custom_check">
                                        <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission }}">
                                        <span class="checkmark"></span>
                                        {{ $permission }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('selectedPermissions') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submit">Update Role</span>
                            <span wire:loading wire:target="submit">Updating...</span>
                        </button>
                        <a href="{{ route('roles') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

