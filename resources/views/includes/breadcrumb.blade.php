<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @for ($i = 0; $i < count($data); $i++)
            @if ($i == count($data) - 1)
                <li class="breadcrumb-item active" aria-current="page">{{ $data[$i]['name'] }}</li>
                @continue
            @endif

            <li class="breadcrumb-item"><a href="{!! $data[$i]['link'] !!}">{{ $data[$i]['name'] }}</a></li>
        @endfor
    </ol>
</nav>
