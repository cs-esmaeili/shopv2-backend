@extends('partials.main')
@section('content')
    <!-- Slider Section -->
    <section id="slider" class="mt-3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-9" data-aos="fade-zoom-in" data-aos-duration="700">
                    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @php
                                $temp = $data['slider'];
                            @endphp
                            @for ($i = 0; $i < count($temp); $i++)
                                @if ($i == 0)
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                                        class="active" aria-current="true" aria-label="Slide 0">
                                    </button>
                                @else
                                    <button type="button" data-bs-target="#carouselExampleCaptions"
                                        data-bs-slide-to={{ $i }} aria-label={{ 'Slide ' . $i }}>
                                    </button>
                                @endif
                            @endfor
                        </div>
                        <div class="carousel-inner">
                            @for ($i = 0; $i < count($temp); $i++)
                                @php
                                    $image = json_decode($temp[$i]->value)->url;
                                    $url = json_decode($temp[$i]->value)->url_target;
                                @endphp
                                @if ($i == 0)
                                    <div class="carousel-item active">
                                        <a href={{ $url }} target="_blank">
                                            <img src={{ $image }} class="d-block">
                                        </a>
                                    </div>
                                @else
                                    <div class="carousel-item">
                                        <a href={{ $url }} target="_blank">
                                            <img src={{ $image }} class="d-block">
                                        </a>
                                    </div>
                                @endif
                            @endfor
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-md-3 mt-2 mt-sm-1 text-center text-sm-start" id="slider-side-banners">
                    <div class="row row-cols-1 row-cols-sm-3 row-cols-md-1 h-100 gy-2 g-sm-1 g-md-0">
                        <div class="col align-self-start" data-aos="fade-top" data-aos-duration="1000">
                            <a href="./products.html">
                                <img src="assets/images/slider/side-slide1.jpg" alt="" width="100%">
                            </a>
                        </div>
                        <div class="col align-self-center" data-aos="fade-top" data-aos-duration="1100">
                            <a href="./products.html">
                                <img src="assets/images/slider/side-slide2.jpg" alt="" width="100%">
                            </a>
                        </div>
                        <div class="col align-self-end" data-aos="fade-top" data-aos-duration="1200">
                            <a href="./products.html">
                                <img src="assets/images/slider/side-slide3.jpg" alt="" width="100%">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Slider Section -->

    <!-- Featured Products Section -->
    <section id="featured-products" class="my-5">
        <div class="container">
            <!-- Tabs -->
            <div class="row pb-2 pb-sm-4">
                <div class="col-12 text-center">
                    <div class="btn-group" role="group" id="featured-products-nav">
                        <button type="button" class="btn active featured-categories" data-val="featured">محصولات
                            منتخب</button>
                        <button type="button" class="btn featured-categories" data-val="on-sale">تخفیف خورده</button>
                        <button type="button" class="btn featured-categories" data-val="most-visited">پربازدیدترین</button>
                    </div>
                </div>
            </div>
            <!-- /Tabs -->

            <!-- Products -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-md-4 featured-product featured" data-aos="fade-up"
                data-aos-duration="1000">
                @php
                    $temp = $data['products3x'][0];
                @endphp
                @for ($i = 0; $i < count($temp); $i++)
                    <div class="col">
                        <!-- Product Box -->
                        <div class="col">
                            <!-- Product Box -->
                            <div class="product-box">
                                <a href="./product.html">
                                    <div class="image" style="background-image: url('{{ $temp[$i]['image'] }}')">
                                    </div>
                                </a>
                                <div class="icons">
                                    <div class="btn btn-outline-secondary btn-favorite"></div>
                                    <div class="btn btn-outline-secondary btn-compare"></div>
                                </div>
                                <div class="details p-3">
                                    <div class="category">
                                        <a href="./products.html">{{ $temp[$i]['category']['name'] }}</a>
                                    </div>
                                    <a href="./product.html">
                                        <h2>{{ $temp[$i]['name'] }}</h2>
                                    </a>
                                    <span class="d-inline-block text-truncate" style="max-width: 260px;">
                                        {{ $temp[$i]['description'] }}
                                    </span>
                                    <div>
                                        @if (isset($temp[$i]['price']))
                                            <span class="discounted">{{ $temp[$i]['price'] }} تومان</span>
                                            <br class="d-sm-none">
                                        @endif
                                        <span class="price">{{ $temp[$i]['sale_price'] }} تومان</span>
                                    </div>
                                </div>
                            </div>
                            <!-- /Product Box -->
                        </div>
                        <!-- /Product Box -->
                    </div>
                @endfor
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-md-4 featured-product on-sale">
                @php
                    $temp = $data['products3x'][1];
                @endphp
                @for ($i = 0; $i < count($temp); $i++)
                    <div class="col">
                        <!-- Product Box -->
                        <div class="col">
                            <!-- Product Box -->
                            <div class="product-box">
                                <a href="./product.html">
                                    <div class="image"
                                        style="background-image: url('{{ $temp[$i]['image'] }}')">
                                    </div>
                                </a>
                                <div class="icons">
                                    <div class="btn btn-outline-secondary btn-favorite"></div>
                                    <div class="btn btn-outline-secondary btn-compare"></div>
                                </div>
                                <div class="details p-3">
                                    <div class="category">
                                        <a href="./products.html">{{ $temp[$i]['category']['name'] }}</a>
                                    </div>
                                    <a href="./product.html">
                                        <h2>{{ $temp[$i]['name'] }}</h2>
                                    </a>
                                    <span class="d-inline-block text-truncate" style="max-width: 260px;">
                                        {{ $temp[$i]['description'] }}
                                    </span>
                                    <div>
                                        @if (isset($temp[$i]['price']))
                                            <span class="discounted">{{ $temp[$i]['price'] }} تومان</span>
                                            <br class="d-sm-none">
                                        @endif
                                        <span class="price">{{ $temp[$i]['sale_price'] }} تومان</span>
                                    </div>
                                </div>
                            </div>
                            <!-- /Product Box -->
                        </div>
                        <!-- /Product Box -->
                    </div>
                @endfor
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-md-4 featured-product most-visited">
                @php
                    $temp = $data['products3x'][2];
                @endphp
                @for ($i = 0; $i < count($temp); $i++)
                    <div class="col">
                        <!-- Product Box -->
                        <div class="col">
                            <!-- Product Box -->
                            <div class="product-box">
                                <a href="./product.html">
                                    <div class="image"
                                        style="background-image: url('{{ $temp[$i]['image'] }}')">
                                    </div>
                                </a>
                                <div class="icons">
                                    <div class="btn btn-outline-secondary btn-favorite"></div>
                                    <div class="btn btn-outline-secondary btn-compare"></div>
                                </div>
                                <div class="details p-3">
                                    <div class="category">
                                        <a href="./products.html">{{ $temp[$i]['category']['name'] }}</a>
                                    </div>
                                    <a href="./product.html">
                                        <h2>{{ $temp[$i]['name'] }}</h2>
                                    </a>
                                    <span class="d-inline-block text-truncate">{{ $temp[$i]['description'] }}</span>
                                    <div>
                                        @if (isset($temp[$i]['price']))
                                            <span class="discounted">{{ $temp[$i]['price'] }} تومان</span>
                                            <br class="d-sm-none">
                                        @endif
                                        <span class="price">{{ $temp[$i]['sale_price'] }} تومان</span>
                                    </div>
                                </div>
                            </div>
                            <!-- /Product Box -->
                        </div>
                        <!-- /Product Box -->
                    </div>
                @endfor
            </div>
            <!-- /Products -->
        </div>
    </section>
    <!-- /Featured Products Section -->

    <!-- On Sale Products -->
    <section id="on-sale-products" class="py-5 mt-5">
        <h1 class="section-title">فروش ویژه</h1>
        <div class="section-subtitle">محصولات دارای تخفیف ویژه به مدت محدود</div>
        <div class="container pt-4">
            <div class="row">
                @php
                    $temp = $data['special'];
                @endphp
                @for ($i = 0; $i < count($temp); $i++)
                    @if ($i == 0)
                        <div class="col-12 col-lg-6">
                            <div class="on-sale-product-box h-100 p-3" data-aos="fade-zoom-in" data-aos-duration="800">
                                <div class="row h-100">
                                    <div class="col-12 col-sm-4 col-lg-5">
                                        <a href="./product.html">
                                            <div class="image h-100"
                                                style="background-image: url('{{ $temp[$i]['image'] }}')"></div>
                                        </a>
                                    </div>
                                    <div class="col-12 col-sm-8 col-lg-7 py-3">
                                        <div class="box-title">محصول ویژه امروز</div>
                                        <div class="box-subtitle">فروش به مدت محدود</div>
                                        <a href="./product.html">
                                            <div class="product-title pt-4">{{ $temp[$i]['name'] }}
                                            </div>
                                        </a>
                                        <div class="price py-2">
                                            <span class="discounted">{{ $temp[$i]['sale_price'] }} تومان</span>
                                            <br class="d-sm-none">
                                            <span class="pre">{{ $temp[$i]['price'] }} تومان</span>
                                        </div>
                                        <div class="cta pt-2">
                                            <a href="./product.html" class="hvr-icon-back">همین حالا بخرید <i
                                                    class="fa fa-arrow-left hvr-icon"></i></a>
                                        </div>
                                        <div class="counter mt-3">
                                            <div class="time-counter">
                                                <div class="seconds count">
                                                    <div class="num">30</div>
                                                    <div class="label">ثانیه</div>
                                                </div>
                                                <div class="minutes count">
                                                    <div class="num">59</div>
                                                    <div class="label">دقیقه</div>
                                                </div>
                                                <div class="hours count">
                                                    <div class="num">13</div>
                                                    <div class="label">ساعت</div>
                                                </div>
                                                <div class="days count">
                                                    <div class="num">38</div>
                                                    <div class="label">روز</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-12 col-sm-6 col-lg-3">
                            <!-- Product Box -->
                            <div class="product-box">
                                <a href="./product.html">
                                    <div class="image"
                                        style="background-image: url('{{ $temp[$i]['image'] }}')">
                                        <span class="badge on-sale-badge">فروش ویژه</span>
                                    </div>
                                </a>
                                <div class="details p-3">
                                    <div class="category">
                                        <a href="./products.html">گوشی موبایل</a>
                                    </div>
                                    <a href="./product.html">
                                        <h2>{{ $temp[$i]['name'] }}</h2>
                                    </a>
                                    <div>
                                        <span class="discounted">{{ $temp[$i]['sale_price'] }} تومان</span>
                                        <br class="d-sm-none">
                                        <span class="price">{{ $temp[$i]['price'] }} تومان</span>
                                    </div>
                                </div>
                            </div>
                            <!-- /Product Box -->
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </section>
    <!-- /On Sale Products -->

    <!-- Benefits Section -->
    <section id="benefits" class="pt-4">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 gy-3 text-center">
                <div class="col" data-aos="fade-zoom-in" data-aos-duration="800">
                    <img src="assets/images/benefits/benefit1.png" alt="">
                    <span>پشتیبانی 24 ساعته</span>
                </div>
                <div class="col" data-aos="fade-zoom-in" data-aos-duration="1000">
                    <img src="assets/images/benefits/benefit2.png" alt="">
                    <span>ضمانت اصالت کالا</span>
                </div>
                <div class="col" data-aos="fade-zoom-in" data-aos-duration="1200">
                    <img src="assets/images/benefits/benefit3.png" alt="">
                    <span>ضمانت بازگشت وجه</span>
                </div>
                <div class="col" data-aos="fade-zoom-in" data-aos-duration="1400">
                    <img src="assets/images/benefits/benefit4.png" alt="">
                    <span>ارسال سریع و رایگان</span>
                </div>
            </div>
            <div class="row pt-2">
                <div class="col">
                    <hr>
                </div>
            </div>
        </div>
    </section>
    <!-- /Benefits Section -->

    <!-- Most Sales Products -->
    <section id="most-sales-products" class="pt-4">
        <h1 class="section-title">پرفروش ترین محصولات</h1>
        <div class="container pt-4">

            <!-- Products -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-md-4 most-sales-product mobile" data-aos="fade-up"
                data-aos-duration="1000">
                @php
                    $temp = $data['moreSeal'];
                @endphp
                @for ($i = 0; $i < count($temp); $i++)
                    <div class="col">
                        <!-- Product Box -->
                        <div class="product-box">
                            <a href="./product.html">
                                <div class="image" style="background-image: url('{{ $temp[$i]['image'] }}')">
                                </div>
                            </a>
                            <div class="icons">
                                <div class="btn btn-outline-secondary btn-favorite"></div>
                                <div class="btn btn-outline-secondary btn-compare"></div>
                            </div>
                            <div class="details p-3">
                                <div class="category">
                                    <a href="./products.html">{{ $temp[$i]['category']['name'] }}</a>
                                </div>
                                <a href="./product.html">
                                    <h2>{{ $temp[$i]['name'] }}</h2>
                                </a>
                                <span class="d-inline-block text-truncate" style="max-width: 260px;">
                                    {{ $temp[$i]['description'] }}
                                </span>
                                <div>
                                    @if (isset($temp[$i]['price']))
                                        <span class="discounted">{{ $temp[$i]['price'] }} تومان</span>
                                        <br class="d-sm-none">
                                    @endif
                                    <span class="price">{{ $temp[$i]['sale_price'] }} تومان</span>
                                </div>
                            </div>
                        </div>
                        <!-- /Product Box -->
                    </div>
                @endfor
            </div>
            <!-- /Products -->
        </div>
    </section>
    <!-- /Most Sales Products -->

    <!-- Promo Images -->
    <div class="container" data-aos="fade-up" data-aos-duration="1200">
        <div class="row">
            <div class="col-12 col-md-4 pt-2 text-center">
                <a href="./products.html">
                    <img src="assets/images/promo-image1.png" alt="">
                </a>
            </div>
            <div class="col-12 col-md-8 pt-2 text-center">
                <a href="./products.html">
                    <img src="assets/images/promo-image2.png" alt="">
                </a>
            </div>
        </div>
    </div>
    <!-- /Promo Images -->

    <!-- Blog Section -->
    <section id="blog" class="pt-5">
        <h1 class="section-title">جدیدترین مقالات آموزشی</h1>
        <div class="container pt-4">
            <div class="row row-cols-1 row-cols-md-3">
                @php
                    $temp = $data['latestPosts'];
                @endphp
                @for ($i = 0; $i < count($temp); $i++)
                    <div class="col">
                        <div class="blog-post-box" data-aos="fade-up" data-aos-duration="1000">
                            <a href="./blog-post.html">
                                <div class="post-image"
                                    style="background-image: url('{{ $temp[$i]['image']}}')">
                                </div>
                            </a>
                            <div class="details py-3 px-4">
                                <div class="post-date">ارسال شده در{{ $temp[$i]['time']}}</div>
                                <a href="./blog-post.html">
                                    <h2 class="post-title">{{ $temp[$i]['title']}}</h2>
                                </a>
                                <a href="./blog-post.html">
                                    <div class="post-description text-truncate">{{ $temp[$i]['description']}}</div>
                                </a>
                                <div class="read-more"><a href="./blog-post.html" class="hvr-icon-back">بیشتر خوانید
                                        <i class="fa fa-arrow-left hvr-icon"></i></a></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>
    <!-- /Blog Section -->
@endsection
