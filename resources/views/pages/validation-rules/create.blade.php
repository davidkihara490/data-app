@extends('components.layouts.master')
@section('page-title')
    {{ __('Create Validation Rule') }}
@endsection()
@section('content')
    <div>
        <livewire:validation-rule.create-validation-rule />
    </div>
@endsection