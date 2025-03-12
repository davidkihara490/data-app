@extends('components.layouts.master')
@section('page-title')
    {{ __('Create Role') }}
@endsection()
@section('content')
    <div>
        <livewire:roles.create-role />
    </div>
@endsection
