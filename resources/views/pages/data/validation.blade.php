@extends('components.layouts.master')
@section('page-title')
    {{ __('Data Validation') }}
@endsection()
@section('content')
    <div>
        <livewire:data.data-validation  :id="$id"/>
    </div>
@endsection