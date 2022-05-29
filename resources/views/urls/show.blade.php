@extends('layouts.app')

@section('content')
    @include('flash::message')

    {{ $url->name }}
@endsection
