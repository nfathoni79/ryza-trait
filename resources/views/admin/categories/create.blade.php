@extends('layouts.sb-admin')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Create Category</h1>

        @include('includes.breadcrumb', [
            'data' => [
                ['name' => 'Categories', 'link' => route('admin.categories.index')],
                ['name' => 'Create Category'],
            ]
        ])

        @include('includes.form-error')

        {!! Form::open(['route' => 'admin.categories.store']) !!}
        <div class="form-group">
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        {!! Form::submit('Create Category', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
@endsection
