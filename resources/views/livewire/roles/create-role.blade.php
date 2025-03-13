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
                                    <x-alerts.alerts />
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input class="form-control" type="text" id=""
                                                    wire:model="name" name="name">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="card-body">
                                    <h5>Select permissions</h5>
                                    <div class="row g-3">
                                        {{-- @foreach ($permissions as $permission)
                                            <div class="col-md-4">
                                                <label class="custom_check">
                                                    <input type="checkbox" wire:model="selectedPermissions" />
                                                    <span class="checkmark"></span>
                                                    {{ $permission['name'] }}
                                                </label>
                                            </div>
                                        @endforeach --}}

                                        @foreach ($permissions as $permission)
                                            <div class="col-md-4">
                                                <label class="custom_check">
                                                    <input type="checkbox" wire:model="selectedPermissions"
                                                        value="{{ $permission->id }}" />
                                                    <span class="checkmark"></span>
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                    @error('selectedPermissions')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="save">Save</span>
                                        <span wire:loading wire:target="save">Saving...</span>
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
