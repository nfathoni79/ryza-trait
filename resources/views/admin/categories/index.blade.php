@extends('layouts.sb-admin')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Categories</h1>

        @include('includes.breadcrumb', [
            'data' => [
                ['name' => 'Categories'],
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
            <a href="{!! route('admin.categories.create') !!}" class="btn btn-success">Create Category</a>
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
                    @foreach ($categories as $category)
                        <tr>
                            <th scope="row">{{ $category->id }}</th>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->created_at->diffForHumans() }}</td>
                            <td>{{ $category->updated_at->diffForHumans() }}</td>
                            <td>
                                <a href="{!! route('admin.categories.edit', $category) !!}" class="btn btn-sm btn-info">Edit</a>
                                <button class="btn btn-sm btn-danger btn-del-category" data-toggle="modal" data-target="#categoryDeleteModal" data-id="{{ $category->id }}">
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
        'modalId' => 'categoryDeleteModal',
        'modalTitle' => 'Delete Confirmation',
        'modalMessage' => 'Are you sure to delete?',
        'modalFormOpen' => ['method' => 'delete', 'id' => 'formConfirm']
    ])
@endsection

@section('scripts')
    <script>
    $(function () {
        $('.btn-del-category').on('click', function () {
            let id = $(this).data('id');
            let route = '{!! route("admin.categories.destroy", ":id") !!}'
            route = route.replace(':id', id);

            $('#formConfirm').prop('action', route);
        });
    });
    </script>
@endsection
