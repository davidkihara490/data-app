<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form wire:submit.prevent="save">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Fill in the details</h4>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input class="form-control" type="text" id=""
                                                    wire:model="name">
                                                @error('name')
                                                    <div style="color: red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Select Template</label> <br />
                                                <select class="form-control" wire:model="template_id">
                                                    <option>--Select an option--</option>
                                                    @foreach ($templates as $template)
                                                        <option value="{{ $template->id }}">
                                                            {{ $template->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('name')
                                                    <div style="color: red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Stages</label>
                                                <input class="form-control" type="number" id=""
                                                    wire:model.live.debounce.750ms="stages" min="1">
                                                @error('stages')
                                                    <div style="color: red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="card-body">
                                    <h4 class="header-title">Work Flow Stages</h4>
                                    @foreach ($fields as $k => $field)
                                        <div class="row" wire:key="{{ $k }}">
                                            <div class="col-lg-5">
                                                <div class="mb-3">
                                                    <label class="form-label">Stage</label>
                                                    <select class="form-control"
                                                        wire:model="fields.{{ $loop->index }}.stage"
                                                        name="fields.{{ $loop->index }}.stage">
                                                        <option>--Select stage--</option>
                                                        @foreach (range(1, $stages) as $stage)
                                                            <option value="{{ $stage }}">
                                                                {{ $stage }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('fields.{{ $loop->index }}.stage')
                                                        <div style="color: red;">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-5">
                                                <div class="mb-3">
                                                    <label class="form-label">User</label>
                                                    <select class="form-control"
                                                        wire:model.defer="fields.{{ $loop->index }}.user_id"
                                                        name="fields.{{ $loop->index }}.user_id">
                                                        <option>--Select user--</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">
                                                                {{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('fields.{{ $loop->index }}.user_id')
                                                        <div style="color: red;">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <button class="btn btn-danger mt-4" type="button"
                                                        wire:click="removeField({{ $loop->index }})">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-4">
                                                <button type="button" class="btn btn-success"
                                                    wire:click.prevent="addField">Add Field</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card-footer">
                                    <button class="btn btn-success">
                                        Save
                                    </button>
                                    {{-- <button class="btn btn-success" wire:loading.attr="disabled"> --}}
                                    {{-- <span wire:loading.remove>Save</span> --}}
                                    {{-- <span wire:loading>Saving...</span> --}}
                                    {{-- </button> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
