@extends('components.layouts.master')
@section('page-title')
    {{ __('Dashboard') }}
@endsection()
@section('content')
    <div>
        <livewire:roles.roles/>
    </div>
@endsection