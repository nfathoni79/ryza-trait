@extends('layouts.simple')

@section('styles')
    <style media="screen">
        .btn-light {
            border-color: #cad0d5;
        }

        .jumbotron {
            background-color: #D3E6E5EE;
        }

        .card {
            background-color: #FFFE;
        }

        div.dropdown-menu {
            z-index: 9999 !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Item List</h1>
            <p class="lead">
                All items (gathering items, synthesis items, battle items, equipments) in Atelier Ryza.
            </p>
            <hr class="my-4">
            <p>
                You can search and filter by category and material.
                All categories in each items are unlocked and can be filtered.
            </p>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h1 class="card-title">{{ $controlTitle ?? 'All Items' }}</h1>

                {!! Form::open(['url' => '#', 'method' => 'get']) !!}

                <div class="form-row">
                    <div class="form-group col-md-4">
                        {!! Form::label('search', 'Search:') !!}
                        {!! Form::text('search', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-md-4">
                        {!! Form::label('category', 'Category:') !!}
                        {!! Form::select('category', ['0' => 'All'] + $categories,
                            (Request::segment(2) == 'filter') ? Request::segment(3) : 0, [
                            'class' => 'form-control selectpicker',
                            'data-live-search' => 'true',])
                        !!}
                    </div>

                    <div class="form-group col-md-4">
                        {!! Form::label('material', 'Material:') !!}
                        {!! Form::select('material', ['0' => 'All'] + $materials,
                            (Request::segment(2) == 'filter') ? Request::segment(4) : 0, [
                            'class' => 'form-control selectpicker',
                            'data-live-search' => 'true',])
                        !!}
                    </div>
                </div>

                {!! Form::close() !!}

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="table-responsive">
                            <table id="itemsTable" class="table">
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
                                                <a href="#" class="item-link" data-toggle="modal" data-target="#itemModal" data-id="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('includes.modal-item')
    @include('includes.back-to-top')
@endsection

@section('scripts')
    <script>
    function routeReplace(fakeRoute, fakeParam, trueParam) {
        let trueRoute = fakeRoute.replace(fakeParam, trueParam);
        return trueRoute;
    }

    $(function () {
        $('#category, #material').on('change', function () {
            let categoryId = $('#category').val();
            let materialId = $('#material').val();
            let route = '{!! route("items.filter", [":categoryId", ":materialId"]) !!}';

            route = routeReplace(route, ':categoryId', categoryId);
            route = routeReplace(route, ':materialId', materialId);

            window.location.replace(route);
        });

        $("#search").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#itemsTable tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

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
