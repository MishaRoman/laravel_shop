<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <div class="labels">
            @if($product->isNew())
                <span class="badge badge-success">Новинка</span>
            @endif
            @if($product->isHit())
                <span class="badge badge-danger">Хит</span>
            @endif
            @if($product->isRecommend())
                <span class="badge badge-warning">Рекомендуемое</span>
            @endif
        </div>
        <img src="{{ Storage::url($product->image) }}">
        <div class="caption">
            <h3>{{ $product->name }}</h3>
            <p>{{ $product->price }}</p>
            <p>
            <form action="{{ route('basket-add', $product) }}" method="POST">
                @if($product->isAvailable())
                    <button class="btn btn-primary" role="button" type="submit">В корзину</button>
                @else
                    <a class="btn btn-danger">Нет в наличии</a>
                @endif
                <a href="{{ route('product', [isset($category) ? $category->code : $product->category->code, $product->code]) }}"
                   class="btn btn-default"
                   role="button">Подробнее</a>
                @csrf
                </form>
            </p>
        </div>
    </div>
</div>