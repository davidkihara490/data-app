<div class="row g-4">

    <div class="overflow-x-auto">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <h4 class="header-title">{{ \Carbon\Carbon::now()->format('l, F j, Y') }} </h4>
                                <p class="sub-header">{{ count($templates) }} Templates</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg rounded-lg overflow-hidden">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="px-4 py-2">Template Name</th>
                                        <th class="px-4 py-2">Data Generation</th>
                                        <th class="px-4 py-2">Validation</th>
                                        <th class="px-4 py-2">Approval</th>
                                        <th class="px-4 py-2">Integration</th>
                                        <th class="px-4 py-2">Archival</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($templates as $template)
                                        <tr>
                                            <td class="px-4 py-2">
                                                @if ($template->workFlow && $template->validationRule)
                                                    <a href="{{ route('templates.view', $template->id) }}"
                                                        class="fw-bold text-primary text-decoration-none">
                                                        {{ $template->name }}
                                                    </a>
                                                @else
                                                    <span class="fw-bold text-muted" style="cursor: pointer;"
                                                        data-bs-toggle="modal" data-bs-target="#errorModal">
                                                        {{ $template->name }}
                                                    </span>
                                                @endif

                                                <!-- Error Modal -->
                                                <div class="modal fade" id="errorModal" tabindex="-1"
                                                    aria-labelledby="errorModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                No workflow or validation rule found for this template.
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            <td class="px-4 py-2">
                                                <span
                                                    class="{{ getStatusBadge($template->latestDataGeneration->status ?? null) }}">
                                                    {{ ucfirst($template->latestDataGeneration->status ?? 'pending') }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-2">
                                                <span
                                                    class="{{ getStatusBadge($template->latestDataGeneration->validation ?? null) }}">
                                                    {{ ucfirst($template->latestDataGeneration->validation ?? 'pending') }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-2">
                                                <span
                                                    class="{{ getStatusBadge($template->latestDataGeneration->approval ?? null) }}">
                                                    {{ ucfirst($template->latestDataGeneration->approval ?? 'pending') }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-2">
                                                <span
                                                    class="{{ getStatusBadge($template->latestDataGeneration->integration ?? null) }}">
                                                    {{ ucfirst($template->latestDataGeneration->integration ?? 'pending') }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-2">
                                                <span
                                                    class="{{ getStatusBadge($template->latestDataGeneration->archival ?? null) }}">
                                                    {{ ucfirst($template->latestDataGeneration->archival ?? 'pending') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
