@extends('components.layouts.master')
@section('page-title')
    {{ __('Notifications') }}
@endsection()
@section('content')
    <div>
        <livewire:notifications.notifications />
    </div>
@endsection
