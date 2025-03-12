<?php
if (!function_exists('getStatusBadge')) {
    function getStatusBadge($status)
    {
        return match ($status) {
            'success' => 'badge bg-success',
            'completed' => 'badge bg-success',
            'error' => 'badge bg-danger',
            'processing' => 'badge bg-warning',
            'failed' => 'badge bg-danger',
            default => 'badge bg-warning text-dark', // Pending
        };
    }
}
