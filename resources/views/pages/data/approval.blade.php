@extends('components.layouts.master')
@section('page-title')
    {{ __('Data Approval') }}
@endsection()
@section('content')
    <div>
        <livewire:data.data-approval  :id="$id"/>
    </div>
@endsection