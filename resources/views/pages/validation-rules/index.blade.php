@extends('components.layouts.master')
@section('page-title')
    {{ __('Users') }}
@endsection()
@section('content')
    <div>
        <livewire:validation-rule.validation-rules/>
    </div>
@endsection