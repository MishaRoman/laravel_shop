@extends('layouts.layout')

@section('title', 'Товар')

@section('content')
    <h1>{{ $product->name }}</h1>
    <h2>{{ $product->category->name }}</h2>
    <p>Цена: <b>{{ $product->price }} ₽</b></p>
    <img src="{{ Storage::url($product->image) }}">
    <p>{{ $product->description }}</p>

    <form action="{{ route('basket-add', $product->id) }}" method="POST">
        @if($product->isAvailable())
            <button class="btn btn-primary" role="button" type="submit">Добавить в корзину</button>
        @else
            <a class="btn btn-danger">Нет в наличии</a>
        @endif
        @csrf
    </form>
@endsection