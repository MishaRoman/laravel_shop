<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <div class="labels">
            @if($sku->product->isNew())
                <span class="badge badge-success">Новинка</span>
            @endif
            @if($sku->product->isHit())
                <span class="badge badge-danger">Хит</span>
            @endif
            @if($sku->product->isRecommend())
                <span class="badge badge-warning">Рекомендуемое</span>
            @endif
        </div>
        <img src="{{ Storage::url($sku->product->image) }}">
        <div class="caption">
            <h3>{{ $sku->product->__('name') }}</h3>
            @isset($sku->product->properties)
                @foreach($sku->propertyOptions as $propertyOption)
                    <h4>{{ $propertyOption->property->name }}: {{ $propertyOption->name }}</h4>
                @endforeach
            @endisset
            <p>
                {{ $sku->price }}
                {{-- Переменная $currencySymbol передана из App\Providers\ViewServiceProvider --}}
                {{ $currencySymbol }}
            </p>
            <p>
            <form action="{{ route('basket-add', $sku) }}" method="POST">
                @if($sku->isAvailable())
                    <button class="btn btn-primary" role="button" type="submit">В корзину</button>
                @else
                    <a class="btn btn-danger">Нет в наличии</a>
                @endif
                <a href="
                    {{ route('sku',
                    [isset($category) ? $category->code :
                     $sku->product->category->code,
                     $sku->product->code, $sku->id]) }}"
                   class="btn btn-default"
                   role="button">Подробнее</a>
                @csrf
                </form>
            </p>
        </div>
    </div>
</div>