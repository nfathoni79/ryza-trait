@extends('layouts.simple')

@section('styles')
    <style>
        button.dropdown-toggle {
            border-color: #cad0d5;
        }

        .jumbotron {
            background-color: #D3E6E5EE;
        }

        .card {
            background-color: #FFFE;
        }

        #result {
            padding-top: 70px;
        }

        div.dropdown-menu {
            z-index: 9999 !important;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="jumbotron">
            <h1 class="display-4">{{ $title }}</h1>
            <p class="lead">
                Helps you transfer one or more traits from an item
                to another item by finding the possible transfer routes.
            </p>
            <hr class="my-4">
            <p>
                This function assumes all effects "Add (category)" are unlocked
                and all traits are transferable, so you may need to unlock the
                required effects and try one ore more routes until you found the
                right one. Please wait while the process is running.
            </p>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title">Select "Start Item" you want to transfer its trait(s) to "Final Item"</h3>

                @include('includes.form-error')

                {!! Form::open(['route' => 'transfer.find', 'method' => 'post']) !!}

                <div class="form-row">
                    <div class="form-group col-md-6">
                        {!! Form::label('startItem', 'Start Item:') !!}
                        {!! Form::select('startItem', $items, $startItem ? $startItem->id : null, [
                            'class' => 'form-control selectpicker',
                            'title' => 'Select one...',
                            'data-live-search' => 'true',])
                        !!}
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('finalItem', 'Final Item:') !!}
                        {!! Form::select('finalItem', $itemsWithMaterial, $finalItem ? $finalItem->id : null, [
                            'class' => 'form-control selectpicker',
                            'title' => 'Select one...',
                            'data-live-search' => 'true'])
                        !!}
                    </div>
                </div>

                {!! Form::submit('Find Transfer Route', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>

        @if ($transferRoutes)
            <div id=resultCard class="card mb-3">
                <div class="card-body">
                    <h1 id="result" class="card-title">
                        Trait Transfer Routes from
                        <a href="#" class="item-link" data-id="{{ $startItem->id }}"
                        data-toggle="modal" data-target="#itemModal">
                            {{ $startItem->name }}
                        </a>
                        to
                        <a href="#" class="item-link" data-id="{{ $finalItem->id }}"
                        data-toggle="modal" data-target="#itemModal">
                            {{ $finalItem->name }}
                        </a>
                    </h1>

                    {!! Form::open(['url' => '#']) !!}

                    <div class="form-row mb-3">
                        <div class="form-group col-md-3">
                            {!! Form::label('sortSelect', 'Sort by:') !!}
                            {!! Form::select('sortSelect',
                                ['1' => 'Route Number', '2' => 'Shortest Route'],
                                null,
                                ['class' => 'form-control selectpicker'])
                            !!}
                        </div>
                    </div>

                    {!! Form::close() !!}

                    <div class="route-container">
                        @for ($i = 0; $i < count($transferRoutes); $i++)
                            <div class="route-component"
                            data-number="{{ $i + 1 }}"
                            data-length="{{ count($transferRoutes[$i]->materialSequence) }}">

                                <h3>Route {{ $i + 1 }}</h3>

                                <ol>
                                    @for ($j = 0; $j < count($transferRoutes[$i]->materialSequence); $j++)
                                        <li>
                                            Synthesize
                                            <a href="#" class="item-link"
                                            data-id="{{ $transferRoutes[$i]->itemSequence[$j + 1]->id }}"
                                            data-toggle="modal" data-target="#itemModal">
                                                {{ $transferRoutes[$i]->itemSequence[$j + 1]->name }}
                                            </a>
                                            by adding
                                            <a href="#" class="item-link"
                                            data-id="{{ $transferRoutes[$i]->itemSequence[$j]->id }}"
                                            data-toggle="modal" data-target="#itemModal">
                                                {{ $transferRoutes[$i]->itemSequence[$j]->name }}
                                            </a>
                                            in
                                            <a href="{!! route('items.filter', [0, $transferRoutes[$i]->materialSequence[$j]]) !!}" target="_blank">
                                                {{ $transferRoutes[$i]->materialSequence[$j]->materialable->name }}
                                            </a>
                                            material loop
                                        </li>
                                    @endfor
                                </ol>
                            </div>
                        @endfor
                    </div>
                </div>
                </div>
        @endif
    </div>

    @include('includes.modal-item')
    @include('includes.back-to-top')
@endsection

@section('scripts')
    <script>
    // Inject route parameter in JS
    function routeReplace(fakeRoute, fakeParam, trueParam) {
        let trueRoute = fakeRoute.replace(fakeParam, trueParam);
        return trueRoute;
    }

    $(function () {
        // Go to result if exists
        if ($('#result').length) {
            location.hash = '#result';
        }

        // Sort by route number or shortest route
        $('#sortSelect').on('change', function () {
            let container = $('.route-container');
            let components = container.children('.route-component');

            if ($(this).val() == 1) {
                components.sort(function (a, b) {
                    let aNumber = $(a).data('number');
                    let bNumber = $(b).data('number');

                    if (aNumber < bNumber) {
                        return -1;
                    }

                    if (aNumber > bNumber) {
                        return 1;
                    }

                    return 0;
                }).appendTo(container);
            }

            if ($(this).val() == 2) {
                components.sort(function (a, b) {
                    let aLength = $(a).data('length');
                    let bLength = $(b).data('length');

                    if (aLength < bLength) {
                        return -1;
                    }

                    if (aLength > bLength) {
                        return 1;
                    }

                    return 0;
                }).appendTo(container);
            }
        });

        // Get and display item to modal
        $('.item-link').on('click', function () {
            $('#itemModalTitle').text('Loading...');
            $('#itemCategories').html('Loading...');
            $('#itemMaterials').html('Loading...');

            let route = routeReplace(
                '{!! route("api.items.show", ":id") !!}',
                ':id',
                $(this).data('id')
            );

            $.get(route, function (data) {
                $('#itemModalTitle').text(data.name);

                let categoryHtml = '';

                for (var category of data.categories) {
                    let categoryRoute = routeReplace(
                        '{!! route("items.filter", [":id", 0]) !!}',
                        ':id',
                        category.id
                    );

                    categoryHtml += '<li>' + '<a href="' + categoryRoute + '">' + category.name + '</a>';
                }

                $('#itemCategories').html(categoryHtml);

                let materialHtml = '';

                for (var material of data.materials) {
                    let materialRoute = routeReplace(
                        '{!! route("items.filter", [0, ":id"]) !!}',
                        ':id',
                        material.id
                    );

                    materialHtml += '<li>' + '<a href="' + materialRoute + '">' + material.materialable.name + '</a>';
                }

                if (materialHtml) {
                    $('#itemMaterials').html(materialHtml);
                } else {
                    $('#itemMaterials').html('No Material');
                }
            });
        });
    });
    </script>
@endsection
