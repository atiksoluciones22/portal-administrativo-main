@extends('layouts.app')

@section('content')
    @livewire('demographic-report.' . $type)
@endsection
