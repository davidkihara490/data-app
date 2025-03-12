@extends('components.layouts.master')
@section('page-title')
    {{ __('System Logs') }}
@endsection()
@section('content')
    <div>
        <livewire:system-logs.system-logs/>
    </div>
@endsection