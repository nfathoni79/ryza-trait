@extends('layouts.sb-admin')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Create Item</h1>

        @include('includes.breadcrumb', [
            'data' => [
                ['name' => 'Dashboard', 'link' => '#'],
                ['name' => 'Items', 'link' => route('admin.items.index')],
                ['name' => 'Create Item'],
            ]
        ])

        @include('includes.form-error')

        {!! Form::open(['route' => 'admin.items.store']) !!}
        <div class="form-group">
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        {!! Form::submit('Create Item', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
@endsection
