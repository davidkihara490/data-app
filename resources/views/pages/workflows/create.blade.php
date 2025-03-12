@extends('components.layouts.master')
@section('page-title')
    {{ __('Create / Update WorkFlow') }}
@endsection()
@section('content')
    <div>
        <livewire:work-flow.create-work-flow />
    </div>
@endsection
