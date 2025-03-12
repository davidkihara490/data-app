@extends('components.layouts.master')
@section('page-title')
    {{ __('Data Integration') }}
@endsection()
@section('content')
    <div>
        <livewire:data.data-integration  :id="$id"/>
    </div>
@endsection