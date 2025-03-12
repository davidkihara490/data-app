@extends('components.layouts.master')
@section('page-title')
    {{ __('Templates') }}
@endsection()
@section('content')
    <div>
        <livewire:templates.templates/>
    </div>
@endsection