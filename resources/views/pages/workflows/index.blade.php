@extends('components.layouts.master')
@section('page-title')
    {{ __('WorkFlows') }}
@endsection()
@section('content')
    <div>
        <livewire:work-flow.work-flows />
    </div>
@endsection
