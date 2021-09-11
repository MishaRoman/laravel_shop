@extends('layouts.layout')

@section('title', 'Товар')

@section('content')
    <h2>{{ $product->name }}</h2>
    <h1>iPhone X 64GB</h1>
    <h2>{{ $product->category->name }}</h2>
    <p>Цена: <b>{{ $product->price }} ₽</b></p>
    <img src="{{ Storage::url($product->image) }}">
    <p>{{ $product->description }}</p>

    <form action="{{ route('basket-add', $product->id) }}" method="POST">

        <button type="submit" class="btn btn-success" role="button">Добавить в корзину</button>

        @csrf
    </form>
@endsection