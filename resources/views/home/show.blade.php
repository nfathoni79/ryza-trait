@extends('layouts.simple')

@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>

        <h5>Categories</h5>

        <ul>
            @foreach ($item->categories as $category)
                <li>
                    <a href="{!! route('items.index.category', $category) !!}">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>

        <h5>Materials</h5>

        <ul>
            @foreach ($item->materials as $material)
                <li>
                    <a href="{!! route('items.index.material', $material) !!}">{{ $material->materialable->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
