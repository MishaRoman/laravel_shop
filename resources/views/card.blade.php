<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <div class="labels">
            
            
                    </div>
        <img src="http://internet-shop.tmweb.ru/storage/products/iphone_x.jpg" alt="iPhone X 64GB">
        <div class="caption">
            <h3>{{ $product->name }}</h3>
            <p>{{ $product->price }}</p>
            <p>
            <form action="http://internet-shop.tmweb.ru/basket/add/1" method="POST">
                <a class="btn btn-primary"
                    href="{{ route('basket') }}"
                    role="button">
                    В корзину
                </a>
                
                <a href="{{ route('product', [$product->category->code, $product->code]) }}"
                   class="btn btn-default"
                   role="button">Подробнее</a>
                <input type="hidden" name="_token" value="ebMp7ljCkBAUk6ZCQHxgHkuxcCoT9owPX74uGrGH">            </form>
            </p>
        </div>
    </div>
</div>