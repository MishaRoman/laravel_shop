
Уважаемый клиент, товар {{ $sku->name }} появился в наличии.

<a href="{{ route('sku', [$sku->category->code, $sku->code]) }}">Узнать подробности</a>