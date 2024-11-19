@extends('layouts.app')
@section('content')

<main>

<section class="swiper-container js-swiper-slider swiper-number-pagination slideshow" data-settings='{
    "autoplay": {
      "delay": 5000
    },
    "slidesPerView": 1,
    "effect": "fade",
    "loop": true
  }'>
  <div class="swiper-wrapper">
    <div class="swiper-slide">
      <div class="overflow-hidden position-relative h-100">
        <div class="slideshow-character position-absolute bottom-0 pos_right-center">
          
        </div>
        <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
         
          <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">On all kind of Seeds</h2>
          <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5">Seeds</h2>
          <a href="{{route('shop.index')}}"
            class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
            Now</a>
        </div>
      </div>
    </div>

  </div>

  <div class="container">
    <div
      class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5">
    </div>
  </div>
</section>
<div class="container mw-1620 bg-white border-radius-10">
  <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
  <section class="category-carousel container">
    <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">You Might Like</h2>

    <div class="position-relative">
    <div class="swiper-container js-swiper-slider" data-settings='{
      "autoplay": {
        "delay": 5000
      },
      "slidesPerView": 2,
      "slidesPerGroup": 1,
      "effect": "none",
      "loop": true,
      "navigation": {
        "nextEl": ".products-carousel__next-1",
        "prevEl": ".products-carousel__prev-1"
      },
      "breakpoints": {
        "320": {
          "slidesPerView": 2,
          "slidesPerGroup": 2,
          "spaceBetween": 15
        },
        "768": {
          "slidesPerView": 4,
          "slidesPerGroup": 4,
          "spaceBetween": 30
        },
        "992": {
          "slidesPerView": 6,
          "slidesPerGroup": 1,
          "spaceBetween": 45,
          "pagination": false
        },
        "1200": {
          "slidesPerView": 8,
          "slidesPerGroup": 1,
          "spaceBetween": 60,
          "pagination": false
        }
      }
    }'>

    <div class="swiper-wrapper">
      @foreach ($categories->take(2) as $category)
      <div class="swiper-slide">
        <img 
          loading="lazy" 
          class="w-100 h-auto mb-3" 
          src="{{ asset('uploads/categories/' . $category->image) }}" 
          width="124" 
          height="124" 
          alt="{{ $category->name }}" />
        <div class="text-center">
          <a href="{{ route('shop.index', ['categories' => $category->id]) }}" class="menu-link fw-medium">
            {{ $category->name }}
          </a>
        </div>
      </div>
      @endforeach
    </div><!-- /.swiper-wrapper -->

</div><!-- /.swiper-container -->
 </div><!-- /.swiper-container js-swiper-slider -->

      <div
        class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 d-flex align-items-center justify-content-center">
        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
          <use href="#icon_prev_md" />
        </svg>
      </div><!-- /.products-carousel__prev -->
      <div
        class="products-carousel__next products-carousel__next-1 position-absolute top-50 d-flex align-items-center justify-content-center">
        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
          <use href="#icon_next_md" />
        </svg>
      </div><!-- /.products-carousel__next -->
    </div><!-- /.position-relative -->
  </section>

  <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

  

  

  <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

  <section class="products-grid container">
    <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Featured Products</h2>

    <div class="row">
      @foreach($fproducts as $fproduct)
      
      <div class="col-6 col-md-4 col-lg-3">
        <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
          <div class="pc__img-wrapper">
            <a href="{{route('shop.product.details',['product_slug'=>$fproduct->slug])}}">
              <img loading="lazy" src="{{asset('uploads/products')}}/{{$fproduct->image}}" width="330" height="400"
              alt="{{$fproduct->name}}" class="pc__img">
            </a>
          </div>
          
          <div class="pc__info position-relative">
            <h6 class="pc__title"><a href="details.html">{{$fproduct->name}}</a></h6>
            <div class="product-card__price d-flex align-items-center">
              <span class="money price text-secondary">
                @if($fproduct->sale_price)
                    <s>Rs.{{$fproduct->regular_price}}</s>Rs.{{$fproduct->sale_price}}
                @else
                    Rs.{{$fproduct->regular_price}}
                @endif
              </span>
            </div>
    </div>
  </div>
</div>
@endforeach
    </div><!-- /.row -->

    <div class="text-center mt-2">
      <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="{{route('shop.index')}}">Load More</a>
    </div>
  </section>
</div>

<div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

</main>


@endsection