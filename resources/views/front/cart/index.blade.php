
<x-front-layout title="Cart"> 

    <x-slot name='breadcrumb'>

        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Cart</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('front.home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="{{ route('front.products.index') }}">Shop</a></li>
                            <li>Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <!-- Start Breadcrumbs -->
    <!-- End Breadcrumbs -->

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="cart-list-head">
                <!-- Cart List Title -->
                <div class="cart-list-title">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-12">

                        </div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <p>Product Name</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Quantity</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Subtotal</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Discount</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <p>Remove</p>
                        </div>
                    </div>
                </div>
                <!-- End Cart List Title -->

                @foreach ($cart->get() as $item )
                    
                
                <!-- Cart Single List list -->
                <div class="cart-single-list" id="{{ $item->id }}">
                    <div class="row align-items-center">
                        <div class="col-lg-1 col-md-1 col-12">
                            <a href="{{ route('front.products.show',$item->product->slug) }}">
                            <img src="{{ $item->product->image_url }}" alt="#"></a>
                        </div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <h5 class="product-name"><a href="{{ route('front.products.show',$item->product->slug) }}">
                                {{ $item->product->name }}</a></h5>
                            <p class="product-des">
                                <span><em>Type:</em> Mirrorless</span>
                                <span><em>Color:</em> Black</span>
                            </p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <div class="count-input">
                                <input class="form-control item-quantity" name="quantity" data-id={{ $item->id }} value="{{$item->quantity }}">
                                    {{-- <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option> --}}
                                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{ App\Helpers\Currency::formate($item->product->price * $item->quantity , config('app.currency')) }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{App\Helpers\Currency::formate(0 , config('app.currency') )}}</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <a class="remove-item" data-id={{ $item->id }} href="javascript:void(0)"><i class="lni lni-close"></i></a>
                        </div>
                    </div>
                </div>
                <!-- End Single List list -->
                @endforeach
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-6 col-12">
                                <div class="left">
                                    <div class="coupon">
                                        <form action="#" target="_blank">
                                            <input name="Coupon" placeholder="Enter Your Coupon">
                                            <div class="button">
                                                <button class="btn">Apply Coupon</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="right">
                                    <ul>
                                        <li>Cart Subtotal<span>{{App\Helpers\Currency::formate($cart->total() , config('app.currency')) }}</span></li>
                                        <li>Shipping<span>Free</span></li>
                                        <li>You Save<span>{{App\Helpers\Currency::formate(0 , config('app.currency'))}}</span></li>
                                        <li class="last">You Pay<span>
                                            @php
                                                $total=$cart->total();
                                                $discount=0 ;
                                                $final=$total - $discount ;
                                            @endphp
                                            {{ App\Helpers\Currency::formate($final ,  config('app.currency')) }}</span></li>
                                    </ul>
                                    <div class="button">
                                        <a href="{{ route('front.checkout') }}" class="btn">Checkout</a>
                                        <a href="{{ route('front.products.index') }}" class="btn btn-alt">Continue shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Shopping Cart -->

    @push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

@vite('resources/js/cart.js')
        
 

    @endpush
</x-front-layout>



