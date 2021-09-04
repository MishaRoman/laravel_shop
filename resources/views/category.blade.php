@extends('layouts.layout')

@section('title', 'Категория ' . $category->name)

@section('content')
        <h1>
            {{ $category->name }}
        </h1>
        <p>
            {{ $category->description }}
        </p>
        <div class="row">
            @foreach($category->products as $product)
                @include('card', compact('product'))
            @endforeach
        </div>

@endsection