@extends('components.layouts.master')
@section('page-title')
    {{ __('Data Archival') }}
@endsection()
@section('content')
    <div>
        <livewire:data.data-archival  :id="$id"/>
    </div>
@endsection