<p>Уважаемый {{ $name }}</p>

<p>Ваш заказ на сумму {{ $fullSum }} создан</p>

<table>
    <tbody>
    @foreach($order->skus as $sku)
        <tr>
            <td>
                <a href="{{ route('sku', [$sku->product->category->code, $sku->product->code, $sku]) }}">
                    <img height="56px" src="{{ Storage::url($sku->product->image) }}">
                    {{ $sku->product->__('name') }}
                </a>
            </td>
            <td><span class="badge">{{ $sku->countInOrder }}</span>
                <div class="btn-group form-inline">
                    {!! $sku->product->__('description') !!}
                </div>
            </td>
            {{-- Переменная $currencySymbol передана из App\Providers\ViewServiceProvider --}}
            <td>{{ $sku->price }} {{ $currencySymbol }}</td>
            <td>{{ $sku->getPriceForCount() }} {{ $currencySymbol }}</td>
        </tr>
    @endforeach
    </tbody>
</table>