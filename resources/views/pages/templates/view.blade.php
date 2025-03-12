@extends('components.layouts.master')
@section('page-title')
    {{ __('Users') }}
@endsection()
@section('content')
    <div>
        <livewire:templates.view-template :id="$id"/>
    </div>
@endsection