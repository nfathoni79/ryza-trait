@extends('layouts.sb-admin')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Edit Category</h1>

        @include('includes.breadcrumb', [
            'data' => [
                ['name' => 'Categories', 'link' => route('admin.categories.index')],
                ['name' => 'Edit Category'],
            ]
        ])

        @include('includes.form-error')

        {!! Form::model($category, ['route' => ['admin.categories.update', $category], 'method' => 'put']) !!}
        <div class="form-group">
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        {!! Form::submit('Edit Category', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
@endsection
