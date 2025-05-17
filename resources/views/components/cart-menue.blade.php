<div class="cart-items">
    <a href="javascript:void(0)" class="main-btn">
        <i class="lni lni-cart"></i>
        <span class="total-items">{{$cart->count()}} </span>
    </a>
    <!-- Shopping Item -->
    <div class="shopping-item">
        <div class="dropdown-cart-header">
            <span>{{$cart->count()}} Items</span>
            <a href="cart.html">View Cart</a>
        </div>
        <ul class="shopping-list">
            @foreach ($cart as $item  )
                
           
            <li>
                <a href="javascript:void(0)" class="remove" title="Remove this item"><i
                        class="lni lni-close"></i></a>
                <div class="cart-img-head">
                    <a class="cart-img" href="{{ route('front.products.show' , $item->product->slug) }}"><img
                            src="{{$item->product->image_url}}" alt="#"></a>
                </div>

                <div class="content">
                    <h4><a href="{{ route('front.products.show' , $item->product->slug) }}">
                           {{$item->product->name}}</a></h4>
                    <p class="quantity"> {{$item->quantity}} x - <span class="amount"> {{Currency::formate($item->product->price ,config('app.currency'))}}</span></p>
                </div>
            </li>
            @endforeach
        </ul>
        <div class="bottom">
            <div class="total">
                <span>Total</span>
                <span class="total-amount">{{Currency::formate($total,config('app.currency'))}}</span>
            </div>
            <div class="button">
                <a href="{{ route('front.checkout') }}" class="btn animate">Checkout</a>
            </div>
        </div>
    </div>
    <!--/ End Shopping Item -->

    
</div>