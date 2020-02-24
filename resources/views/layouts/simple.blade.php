<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="{!! asset('css/app.css') !!}">
    <script src="{!! asset('js/app.js') !!}" charset="utf-8"></script>

    @yield('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <a class="navbar-brand" href="{!! route('items.index') !!}">Ryza Item</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="{!! route('items.index') !!}">Item list <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="#">Trait Transfer</a>
        </div>
    </div>
</nav>

@yield('content')

@yield('scripts')
</body>
</html>
