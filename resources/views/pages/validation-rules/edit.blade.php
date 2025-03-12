@extends('components.layouts.master')
@section('page-title')
    {{ __('Create / Update Validation Rule') }}
@endsection()
@section('content')
    <div>
        <livewire:validation-rule.edit-validation-rule  :id="$id"/>
    </div>
@endsection