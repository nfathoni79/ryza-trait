<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ $title }}</title>

    <link rel="icon" href="/puni-jelly.png">
    <link rel="stylesheet" href="/css/app.css">
    <script src="/js/app.js" charset="utf-8"></script>

    <style>
        html {
            position: relative;
            min-height: 100%;
        }

        body {
            padding-top: 60px;
            margin-bottom: 90px;
            background: url("/ryza-wallpaper.jpg") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            background-size: cover;
            -o-background-size: cover;
        }

        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px;
            line-height: 60px;
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

<footer>
    <div class="container">
        <p class="m-0 text-center text-white">
            <i class="fas fa-code"></i> with <i class="fas fa-heart"></i> by NN
        </p>
    </div>
</footer>

@yield('scripts')
</body>
</html>
