<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="min-vh-100 d-flex flex-column">
<header class="flex-shrink-0">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="{{ route('home') }}">{{ __('messages.Page analyzer')  }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('urls.index') ? ' active' : '' }}" href="{{ route('home') }}">{{ __('messages.Main') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('urls.index') ? ' active' : '' }}" href="{{ route('urls.index') }}">{{ __('messages.Sites') }}</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<main class="flex-grow-1">
    @include('flash::message')
    @yield('content')
</main>

<footer class="border-top py-3 mt-5 flex-shrink-0">
    <div class="container-lg">
        <div class="text-center">
            <a href="https://hexlet.io/pages/about" target="_blank">{{ __('messages.Name brand') }}</a>
        </div>
    </div>
</footer>

</body>
</html>
