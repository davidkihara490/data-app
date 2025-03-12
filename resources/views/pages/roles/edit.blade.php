@extends('components.layouts.master')
@section('page-title')
    {{ __('Dashboard') }}
@endsection()
@section('content')
    <div>
        <livewire:roles.edit-role :id="$id" />
    </div>
@endsection
