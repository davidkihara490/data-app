<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4 class="header-title">{{ $template->name }}</h4>
                <div class="d-flex flex-column align-items-center">
                    <input type="date" wire:model.live.debounce.750ms="selectedDate" class="form-control"
                        value="{{ now()->format('Y-m-d') }}">
                </div>
                <p class="header-title">Frequency - {{ ucfirst($template->frequency) }}</p>
            </div>

            @if ($errorsList)
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errorsList as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-4">Data Process</h4>

                    {{-- Tabs Navigation --}}
                    <ul class="nav nav-pills navtab-bg nav-justified">
                        @can('generate_data')
                            <li class="nav-item">
                                <a wire:click="setActiveTab('dataGeneration')" href="#"
                                    class="nav-link {{ $activeTab === 'dataGeneration' ? 'active' : '' }}">Generate</a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a wire:click="setActiveTab('data')" href="#"
                                class="nav-link {{ $activeTab === 'data' ? 'active' : '' }}">Data</a>
                        </li>
                        @can('validate_data')
                            <li class="nav-item">
                                <a wire:click="setActiveTab('dataValidation')" href="#"
                                    class="nav-link {{ $activeTab === 'dataValidation' ? 'active' : '' }} {{ !$dataGeneration || $dataGeneration->status !== 'completed' ? 'disabled text-muted' : '' }}">Validate</a>
                            </li>
                        @endcan
                        @can('approve_data')
                            <li class="nav-item">
                                <a wire:click="setActiveTab('dataApproval')" href="#"
                                    class="nav-link {{ $activeTab === 'dataApproval' ? 'active' : '' }}">Approve</a>
                            </li>
                        @endcan
                        @can('integrate_data')
                            <li class="nav-item">
                                <a wire:click="setActiveTab('dataIntegration')" href="#"
                                    class="nav-link {{ $activeTab === 'dataIntegration' ? 'active' : '' }}">Integrate</a>
                            </li>
                        @endcan
                        @can('archive_data')
                            <li class="nav-item">
                                <a wire:click="setActiveTab('dataArchival')" href="#"
                                    class="nav-link {{ $activeTab === 'dataArchival' ? 'active' : '' }}">Archive</a>
                            </li>
                        @endcan
                    </ul>

                    {{-- Tabs Content --}}
                    <div class="tab-content">
                        @switch($activeTab)
                            @case('dataGeneration')
                                <div class="tab-pane active">
                                    <button type="button" class="float-start btn btn-success btn-sm" wire:key="generate"
                                        wire:click="handleDataGeneration({{ $template->id }})" wire:loading.attr="disabled"
                                        wire:loading.class="bg-info">
                                        <span wire:loading.remove>Fetch Data</span>
                                        <span wire:loading>Fetching data...</span>
                                    </button>
                                    <button type="button" class="float-start btn btn-danger btn-sm" wire:key="reset"
                                        wire:click="resetData({{ $template->id }})" wire:loading.attr="disabled"
                                        wire:loading.class="bg-info">
                                        <span wire:loading.remove>Reset Data</span>
                                        <span wire:loading>Resetting data...</span>
                                    </button>
                                    <br>

                                    <div class=" mt-4 alert {{ $dataFetchingStatus ? 'alert-success' : 'alert-danger' }}">
                                        <p class="text-center">
                                            {{ $dataFetchingStatus ? 'Data was fetched. You can view it in the Data tab' : 'Data has not been fetched' }}
                                        </p>
                                    </div>
                                </div>
                            @break

                            @case('data')
                                <div class="tab-pane active">
                                    @if ($latestGeneratedData)
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h4 class="header-title">Fetched Data</h4>
                                                <p class="sub-header">Number of Rows: {{ count($latestGeneratedData) }}</p>
                                            </div>
                                            <div class="card-body table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            @foreach (array_keys((array) $latestGeneratedData[0]) as $header)
                                                                <th>{{ ucfirst(str_replace('_', ' ', $header)) }}</th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($latestGeneratedData as $row)
                                                            <tr>
                                                                @foreach ($row as $value)
                                                                    <td>{{ $value }}</td>
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-info">No data has been generated for today.</div>
                                    @endif
                                </div>
                            @break

                            @case('dataValidation')
                                <div class="tab-pane active">
                                    @if ($latestGeneratedData)
                                        <div class="card mt-3">
                                            <livewire:data.data-validation :id="$dataGeneration->id" />
                                        </div>
                                    @else
                                        <div class="alert alert-info">No data has been generated for today.</div>
                                    @endif
                                </div>
                            @break

                            @case('dataApproval')
                                <div class="tab-pane active">
                                    @if ($latestGeneratedData)
                                        <div class="card mt-3">
                                            <livewire:data.data-approval :id="$dataGeneration->id" />
                                        </div>
                                    @else
                                        <div class="alert alert-info">No data has been generated for today.</div>
                                    @endif
                                </div>
                            @break

                            @case('dataIntegration')
                                <div class="tab-pane active">
                                    @if ($latestGeneratedData)
                                        <div class="card mt-3">
                                            <livewire:data.data-integration :id="$dataGeneration->id" />
                                        </div>
                                    @else
                                        <div class="alert alert-info">No data has been generated for today.</div>
                                    @endif
                                </div>
                            @break

                            @case('dataArchival')
                                <div class="tab-pane active">
                                    @if ($latestGeneratedData)
                                        <div class="card mt-3">
                                            <livewire:data.data-archival :id="$dataGeneration->id" />
                                        </div>
                                    @else
                                        <div class="alert alert-info">No data has been generated for today.</div>
                                    @endif
                                </div>
                            @break

                        @endswitch
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
