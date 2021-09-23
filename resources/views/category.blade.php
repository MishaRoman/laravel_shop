@extends('layouts.layout')

@section('title', 'Категория ' . $category->__('name'))

@section('content')
        <h1>
            {{ $category->__('name') }}
        </h1>
        <p>
            {{ $category->__('description') }}
        </p>
        <div class="row">
            @foreach($category->products->map->skus->flatten() as $sku)
                @include('card', compact('sku'))
            @endforeach
        </div>

@endsection