@extends('layouts.simple')

@section('content')
    @include('includes.simple-navbar', [
        'items' => [
            ['name' => 'Item List', 'link' => route('items.index'), 'active' => true],
            ['name' => 'Trait Transfer', 'link' => route('transfer.index'), 'active' => false],
        ]
    ])

    <div class="container">
        <h1>{{ $title }}</h1>

        <h4>
            All items (gather items, sythesis items, battle items, equipments) in Atelier Ryza.
            You can filter by a category or a material.
        </h4>

        {!! Form::open(['url' => '#', 'method' => 'get', 'class' => 'form-inline']) !!}

        {!! Form::label('category', 'Category:', ['class' => 'mr-2']) !!}
        {!! Form::select('category', $categories, (Request::segment(2) == 'category') ? Request::segment(3) : null, [
            'class' => 'form-control selectpicker mr-3',
            'title' => 'Select one...',
            'data-live-search' => 'true'])
        !!}

        {!! Form::label('material', 'Material:', ['class' => 'mr-2']) !!}
        {!! Form::select('material', $materials, (Request::segment(2) == 'material') ? Request::segment(3) : null, [
            'class' => 'form-control selectpicker mr-3',
            'title' => 'Select one...',
            'data-live-search' => 'true'])
        !!}

        {!! Form::close() !!}

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td>
                                <a href="{!! route('items.show', $item) !!}">{{ $item->name }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
    $(function () {
        $('#category').on('change', function () {
            let id = $(this).val();
            let route = '{!! route("items.index.category", ":id") !!}';
            route = route.replace(':id', id);

            window.location.replace(route);
        });

        $('#material').on('change', function () {
            let id = $(this).val();
            let route = '{!! route("items.index.material", ":id") !!}';
            route = route.replace(':id', id);

            window.location.replace(route);
        });
    });
    </script>
@endsection
