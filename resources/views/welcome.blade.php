@extends('layouts.app')


@section('content')
<div class="container-lg mt-3">
    <div class="row">
        <div class="col-12 col-md-10 col-lg-8 mx-auto border rounded-3 bg-light p-5">
            <h1 class="display-3">{{ __('messages.Page analyzer') }}</h1>
            <p class="lead">{{ __('messages.Check for free if sites can be used for SEO') }}</p>
            <form action="{{ route('urls.store') }}" method="post" class="d-flex justify-content-center">
                @csrf

                <input type="text" name="url[name]" value="" class="form-control form-control-lg" placeholder="{{ __('messages.Site empty address') }}">
                <input type="submit" class="btn btn-primary btn-lg ms-3 px-5 text-uppercase mx-3" value="{{ __('messages.Check') }}">
            </form>
        </div>
    </div>
</div>
@endsection
