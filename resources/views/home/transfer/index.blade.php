@extends('layouts.simple')

@section('content')
    @include('includes.simple-navbar', [
        'items' => [
            ['name' => 'Item List', 'link' => route('items.index'), 'active' => false],
            ['name' => 'Trait Transfer', 'link' => route('transfer.index'), 'active' => true],
        ]
    ])

    <div class="container">
        <h1>{{ $title }}</h1>
        <h4>
            This functionality assumes all traits are transferable, so you might
            try one ore more routes until you found the right one.
            Also, you might unlock all effects of the needed items, especially the "Add (category)" effects.
        </h4>

        @include('includes.form-error')

        <div class="mb-3">
            {!! Form::open(['route' => 'transfer.search', 'method' => 'post']) !!}

            <div class="form-group">
                {!! Form::label('fromItem', 'Item with specific trait to transfer:') !!}
                {!! Form::select('fromItem', $items, null, [
                    'class' => 'form-control selectpicker',
                    'title' => 'Select one...',
                    'data-live-search' => 'true'])
                !!}
            </div>

            <div class="form-group">
                {!! Form::label('toItem', 'Target item:') !!}
                {!! Form::select('toItem', $items, null, [
                    'class' => 'form-control selectpicker',
                    'title' => 'Select one...',
                    'data-live-search' => 'true'])
                !!}
            </div>

            {!! Form::submit('Search Transfer Route', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>

        @if (session('fullRoutes'))
            {{-- <div class="">
                @for ($i = 0; $i < count($fullRoutes); $i++)
                    <h3>Route {{ $i + 1 }}</h3>

                    <ol>
                        @for ($j = 0; $j < count($fullRoutes[$i][1]); $j++)
                            <li>{{ Item::find($fullRoutes[$i][0][$j])->name }}</li>
                            <li>*{{ Material::find($fullRoutes[$i][1][$j])->materialable->name }}</li>
                        @endfor

                        <li>{{ Item::find(count($fullRoutes[$i][0]) - 1)->name }}</li>
                    </ol>
                @endfor
            </div> --}}

            <div class="">
                <button id="sortButton" class="btn btn-secondary mb-3">Sort in reverse order</button>

                <div class="route-container">
                    @for ($i = 0; $i < count(session('fullRoutes')); $i++)
                        <div class="route-component">
                            <h3>Route {{ $i + 1 }}</h3>

                            <ol>
                                @for ($j = 0; $j < count(session('fullRoutes')[$i][1]); $j++)

                                    <li>
                                        Synthesize
                                        <a href="{!! route('items.show', session('fullRoutes')[$i][0][$j + 1]) !!}">
                                            {{ session('fullRoutes')[$i][0][$j + 1]->name }}
                                        </a>
                                        by adding
                                        <a href="{!! route('items.show', session('fullRoutes')[$i][0][$j]) !!}">
                                            {{ session('fullRoutes')[$i][0][$j]->name }}
                                        </a>
                                        in
                                        <a href="{!! route('items.index.material', session('fullRoutes')[$i][1][$j]) !!}">
                                            {{ session('fullRoutes')[$i][1][$j]->materialable->name }}
                                        </a>
                                        loop
                                    </li>
                                @endfor
                            </ol>
                        </div>
                    @endfor
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
    $(function () {
        $('#sortButton').on('click', function () {
            var container = $('.route-container');
            var components = container.children('.route-component');
            container.append(components.get().reverse());
        });
    });
    </script>
@endsection
