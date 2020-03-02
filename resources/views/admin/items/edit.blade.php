@extends('layouts.sb-admin')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Edit Item</h1>

        @include('includes.breadcrumb', [
            'data' => [
                ['name' => 'Items', 'link' => route('admin.items.index')],
                ['name' => 'Edit Item'],
            ]
        ])

        @include('includes.form-error')

        {!! Form::model($item, ['route' => ['admin.items.update', $item], 'method' => 'put']) !!}
        <div class="form-group">
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('categories[]', 'Categories:') !!}
            {!! Form::select('categories[]', $categories, null, [
                'class' => 'form-control selectpicker',
                'multiple' => true,
                'data-live-search' => 'true'])
            !!}
        </div>

        <div class="form-group">
            {!! Form::label('materials[]', 'Materials:') !!}
            {!! Form::select('materials[]', $materials, null, [
                'class' => 'form-control selectpicker',
                'multiple' => true,
                'data-live-search' => 'true'])
            !!}
        </div>

        {!! Form::submit('Edit Item', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
@endsection
