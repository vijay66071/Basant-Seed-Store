@extends('layouts.app')

@section('content')
<style>
  .filled-heart{
    color: orange;
  }
</style>
<main class="pt-90">
    <section class="shop-main container d-flex pt-4 pt-xl-5">

      <div class="shop-list flex-grow-1" style="width: 100vw; max-width: 100%; overflow: hidden;">
        <div class="swiper-container js-swiper-slider slideshow slideshow_small slideshow_split"  data-settings='{
            "autoplay": {
              "delay": 5000
            },
            "slidesPerView": 1,
            "effect": "fade",
            "loop": true,
            "pagination": {
              "el": ".slideshow-pagination",
              "type": "bullets",
              "clickable": true
            }
          }'>
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                <div class="slide-split_text position-relative d-flex align-items-center"
                  style="background-color: #f5e6e0;">
                  <div class="slideshow-text container p-3 p-xl-5">
                    <h2
                      class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                      <strong>#fruits and </br>vegetables</strong></h2>
                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5"></h6>
                  </div>
                </div>
                <div class="slide-split_media position-relative">
                  <div class="slideshow-bg" style="background-color: #f5e6e0;">
                    <img loading="lazy" src="assets/images/shop/vegitable.jpg" width="630" height="450"
                      alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                <div class="slide-split_text position-relative d-flex align-items-center"
                  style="background-color: #f5e6e0;">
                  <div class="slideshow-text container p-3 p-xl-5">
                    <h2
                      class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                      <strong>#fruits and </br>vegetables</strong></h2></h2>
                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5"></h6>
                  </div>
                </div>
                <div class="slide-split_media position-relative">
                  <div class="slideshow-bg" style="background-color: #f5e6e0;">
                    <img loading="lazy" src="assets/images/shop/vegitable.jpg" width="630" height="450"
                      alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                <div class="slide-split_text position-relative d-flex align-items-center"
                  style="background-color: #f5e6e0;">
                  <div class="slideshow-text container p-3 p-xl-5">
                    <h2
                      class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                      <strong>#fruits and </br>vegetables</strong></h2></h2>
                    
                  </div>
                </div>
                <div class="slide-split_media position-relative">
                  <div class="slideshow-bg" style="background-color: #f5e6e0;">
                    <img loading="lazy" src="assets/images/shop/vegitable.jpg.jpg" width="630" height="450"
                      alt="Vegetables" class="slideshow-bg__img object-fit-cover" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="container p-3 p-xl-5">
            <div class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-4 pb-xl-2"></div>

          </div>
        </div>

        <div class="mb-3 pb-2 pb-xl-3"></div>

        <div class="d-flex justify-content-between mb-4 pb-md-2">
          <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
            <a href="{{route('home.index')}}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
            <a href="{{route('shop.index')}}" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
          </div>

          <div class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1" >
            

            <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>

            <div class="col-size align-items-center order-1 d-none d-lg-flex">
              <span class="text-uppercase fw-medium me-2">View</span>
              <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid" data-cols="2">2</button>
              <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid" data-cols="3">3</button>
              <button class="btn-link fw-medium js-cols-size" data-target="products-grid" data-cols="4">4</button>
            </div>

            <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
              <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside" data-aside="shopFilter">
                <svg class="d-inline-block align-middle me-2" width="14" height="10" viewBox="0 0 14 10" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_filter" />
                </svg>
                <span class="text-uppercase fw-medium d-inline-block align-middle">Filter</span>
              </button>
            </div>
          </div>
        </div>

        <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
          @foreach($products as $product) 
          <div class="product-card-wrapper">
            <div class="product-card mb-3 mb-md-4 mb-xxl-5">
              <div class="pc__img-wrapper">
                <div class="swiper-container background-img js-swiper-slider" data-settings='{"resizeObserver": true}'>
                  <div class="swiper-wrapper">
                    <div class="swiper-slide">
                      <a href="{{route('shop.product.details',['product_slug'=>$product->slug])}}"><img loading="lazy" src="{{asset('uploads/products')}}/{{$product->image}}" width="330"
                          height="400" alt="{{$product->name}}" class="pc__img"></a>
                    </div>
                    <div class="swiper-slide">
                      @foreach(explode(',', $product->images) as $image)
                      <a href="{{route('shop.product.details',['product_slug'=>$product->slug])}}"><img loading="lazy" src="{{asset('uploads/products')}}/{{$image}}"
                          width="330" height="400" alt="{{$product->name}}" class="pc__img"></a>
                        @endforeach
                        </div>
                  </div>
                  <span class="pc__img-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                      xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_prev_sm" />
                    </svg></span>
                  <span class="pc__img-next"><svg width="7" height="11" viewBox="0 0 7 11"
                      xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_next_sm" />
                    </svg></span>
                </div>
                @if(\Surfsidemedia\Shoppingcart\Facades\Cart ::instance('cart')->content()->where('id', $product->id)->count()>0)
                    <a href="{{route('cart.index')}}" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium btn-warning mb-3" >Go To Cart</a>
                @else 
                <form name="addtocart-form" method="post" action="{{route('cart.add')}}">
                  @csrf
                <input type="hidden" name="id" value="{{$product->id}}">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="name" value="{{$product->name}}">
                <input type="hidden" name="price" value="{{$product->sale_price==''?$product->regular_price:$product->sale_price}}">
                <button type="submit" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium " data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                </form>
                @endif
              </div>

              <div class="pc__info position-relative">
                <p class="pc__category">{{$product->category->name}}</p>
                <h6 class="pc__title"><a href="{{route('shop.product.details',['product_slug'=>$product->slug])}}">{{$product->name}}</a></h6>
                <div class="product-card__price d-flex">
                  <span class="money price">
                    @if($product->sale_price)
                       <s>Rs. {{$product->regular_price}}</s>Rs.{{$product->sale_price}}
                    @else
                    Rs.{{$product->regular_price}}
                    @endif
                  </span>
                </div>
                <!-- <div class="product-card__review d-flex align-items-center">
                  <div class="reviews-group d-flex">
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                  </div>
                  <span class="reviews-note text-lowercase text-secondary ms-1">8k+ reviews</span>
                </div> -->
                
              </div>
            </div>
          </div>
          @endforeach

        </div>

      <div class="divider"> </div>
      <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
        {{$products->links('pagination::bootstrap-5') }}
      </div>
    </section>
</main>
  
@endsection

