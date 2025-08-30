  <!-- Start Single Product -->
  <div class="single-product">
    <div class="product-image">
        <img src="{{$product->image_url}}" alt="#">
        {{-- this is accessor to get the percentage of discount  --}}
        @if ($product->sale_percentage)  
        <span class="sale-tag">-{{$product->sale_percentage}}%</span>
        @endif
        {{-- this is accessor to know if this product is new or not new  --}}
        @if ($product->new)  
        <span class="new-tag">New</span>
        @endif
        <div class="button">
            <a href="{{route('front.products.show',$product->slug)  }}" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
        </div>
    </div>
    <div class="product-info">
        <span class="category">{{$product->category->name}}</span>
        <h4 class="title">
            <a href="{{ route('front.products.show',$product->slug) }}">{{$product->name}}</a>
        </h4>
        <ul class="review">
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><span>5.0 Review(s)</span></li>
        </ul>
        <div class="price">

            @php
                
                // if(session()->has('rate') || session()->has('currency') ) {
                //   $currency_rate=session()->get('rate');
                  
                //   $currency_code=session()->get('currency_code');
                // }else{
                //     $currency_rate= 1 ;
                //    $currency_code=config('app.currency');
                // }
            @endphp
            <span>{{ Currency::formate($product->price )}}</span>
            {{-- <span>{{ Currency::formate($product->price * $currency_rate ,$currency_code)}}</span> --}}

            @if ($product->compare_price)
            <span class="discount-price">{{ Currency::formate($product->compare_price )}}</span> 
            @endif
        </div>
    </div>
</div>
<!-- End Single Product -->