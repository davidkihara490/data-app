@extends('components.layouts.master')
@section('page-title')
    {{ __('Edit Template') }}
@endsection()
@section('content')
    <div>
        <livewire:templates.edit-template :id="$id" />
    </div>
@endsection
