@extends('layouts.sb-admin')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Items</h1>

        @include('includes.breadcrumb', [
            'data' => [
                ['name' => 'Items'],
            ]
        ])

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (session('statusError'))
            <div class="alert alert-danger">
                {{ session('statusError') }}
            </div>
        @endif

        <div class="mb-3">
            <a href="{!! route('admin.items.create') !!}" class="btn btn-success">Create Item</a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Updated at</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->created_at->diffForHumans() }}</td>
                            <td>{{ $item->updated_at->diffForHumans() }}</td>
                            <td>
                                <a href="{!! route('admin.items.edit', $item) !!}" class="btn btn-sm btn-info">Edit</a>
                                <button class="btn btn-sm btn-danger btn-del-item" data-toggle="modal" data-target="#itemDeleteModal" data-id="{{ $item->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('includes.modal-confirm', [
        'modalId' => 'itemDeleteModal',
        'modalTitle' => 'Delete Confirmation',
        'modalMessage' => 'Are you sure to delete?',
        'modalFormOpen' => ['method' => 'delete', 'id' => 'formConfirm']
    ])
@endsection

@section('scripts')
    <script>
    $(function () {
        $('.btn-del-item').on('click', function () {
            let id = $(this).data('id');
            let route = '{!! route("admin.items.destroy", ":id") !!}'
            route = route.replace(':id', id);

            $('#formConfirm').prop('action', route);
        });
    });
    </script>
@endsection
