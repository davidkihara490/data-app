@extends('components.layouts.master')
@section('page-title')
    {{ __('Create / Update WorkFlow') }}
@endsection()
@section('content')
    <div>
        <livewire:work-flow.edit-work-flow :id="$id" />
    </div>
@endsection
