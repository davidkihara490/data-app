@extends('components.layouts.master')
@section('page-title')
    {{ __('Users') }}
@endsection()
@section('content')
    <div>
        <livewire:users.users/>
    </div>
@endsection