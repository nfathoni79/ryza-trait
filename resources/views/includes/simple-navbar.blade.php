<nav class="navbar navbar-expand-lg navbar-dark mb-3 fixed-top" style="background-color:#00ACFF">
    <a class="navbar-brand" href="/">
        <img src="{!! asset('puni-jelly.png') !!}" width="30" height="30" class="d-inline-block align-top" alt="">
        <span class="">{{ $navbarTitle ?? 'Ryza Trait Transfer' }}</span>
    </a>

    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ml-auto">
            @foreach ($navbarItems as $item)
                <a class="nav-item nav-link ml-auto {{ $item['active'] ? 'active' : '' }}" href="{{ $item['link'] }}">
                    {{ $item['name'] }}
                </a>
            @endforeach
        </div>
    </div>
</nav>
