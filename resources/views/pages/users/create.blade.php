@extends('components.layouts.master')
@section('page-title')
    {{ __('New/ Edit User') }}
@endsection()
@section('content')
    <div>
        <livewire:users.edit-user />
    </div>
@endsection