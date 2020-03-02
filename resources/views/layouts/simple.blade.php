<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>

    <link rel="icon" href="{!! asset('puni-jelly.png') !!}">
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}">
    <script src="{!! asset('js/app.js') !!}" charset="utf-8"></script>

    <style>
        body {
            padding-top: 70px;
            background: url("{!! asset('ryza-wallpaper.jpg') !!}") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            background-size: cover;
            -o-background-size: cover;
        }

        footer {
            background-color: #00ACFFEE;
        }
    </style>

    @yield('styles')
</head>
<body>

@include('includes.simple-navbar', [
    'navbarItems' => $navbarItems
])

@yield('content')

<footer class="py-4">
    <div class="container">
        <p class="m-0 text-center text-white">
            <i class="fas fa-code"></i> with <i class="fas fa-heart"></i> by NN
        </p>
    </div>
</footer>

@yield('scripts')
</body>
</html>
