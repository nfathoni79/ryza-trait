<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <a class="navbar-brand" href="{!! route('items.index') !!}">Ryza Item Trait Transfer</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            @foreach ($items as $item)
                <a class="nav-item nav-link {{ $item['active'] ? 'active' : '' }}" href="{{ $item['link'] }}">{{ $item['name'] }}</a>
            @endforeach
        </div>
    </div>
</nav>
