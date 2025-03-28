@extends('layouts.app')

@section('content')
    @livewire('dashboard.' . $type)
@endsection
