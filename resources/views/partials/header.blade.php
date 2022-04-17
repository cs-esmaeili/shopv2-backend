<section id="header">
    <!-- Top NavBar -->
    <div id="top-nav">
        <div class="container">
            <div class="row">
                <div class="col-8 d-none d-md-block">
                    <ul>
                        <li><a href="./index.html">صفحه نخست</a></li>
                        <li><a href="./about.html">درباره ما</a></li>
                        <li><a href="./contact.html">تماس با ما</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-4 text-center text-md-end" id="top-support-info">
                    <span>تلفن مشاوره و فروش: 09351234567</span>
                </div>
            </div>
        </div>
    </div>
    <!-- /Top NavBar -->
    <!-- Search NavBar -->
    <div id="search-nav">
        <div class="container pt-1">
            <div class="row py-3 align-content-center">
                <div class="col-12 col-md-3 col-xl-2 text-center text-md-start pb-2" id="header-logo">
                    <a href="./index.html">
                        <img src="assets/images/logo.png" alt=""> روبیک مارکت
                    </a>
                </div>
                <div class="col-12 col-md-5 col-xl-6">
                    <div id="search-bar">
                        <i class="fa fa-search"></i>
                        <input type="text" placeholder="جستجو کنید...">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="row">
                        <div class="col-12 col-md-7 col-lg-6 text-center" id="btn-login-register">
                            @if (session()->has('token'))
                                <a href="./login.html">خروج</a>
                            @else
                                <a href={{ route('login') }}>ورود</a>
                                /
                                <a href="./register.html">عضویت</a>
                            @endif
                        </div>
                        <div class="col-12 col-md-5 col-lg-6">
                            <a href="./cart.html">
                                <div class="btn btn-warning w-100"><i class="fa fa-shopping-cart"></i>&nbsp;<span
                                        class="d-md-none d-lg-inline-block">سبد خرید</span> (2)</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Search NavBar -->
    <!-- Main NavBar -->
    <div id="main-nav">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="droopmenu-navbar dmarrow-down droopmenu-horizontal dmpos-top dmfade">
                        <div class="droopmenu-inner">
                            <div class="droopmenu-header">
                                <a href="#" class="droopmenu-toggle"><i class="dm-burg"></i></a>
                                <span class="d-md-none">منوی فروشگاه</span>
                            </div>
                            <!-- Header Mega Menu-->
                            <div class="droopmenu-nav">
                                <div class="droopmenu-nav-wrap">
                                    <div class="droopmenu-navi">
                                        <ul class="droopmenu">
                                            <li class="droopmenu-parent" aria-haspopup="true">
                                                <a href="#" aria-expanded="false"><i
                                                        class="fa fa-bars"></i>&nbsp;&nbsp;گروه های محصولات<em
                                                        class="droopmenu-topanim"></em></a>
                                                <div class="dm-arrow"></div>
                                                <ul class="droopmenu-grid droopmenu-grid-9">
                                                    <li class="droopmenu-tabs droopmenu-tabs-vertical">
                                                        <div class="droopmenu-tabsection" id="droopmenutab14">
                                                            <a class="droopmenu-tabheader" href="#">سلامت و
                                                                زیبایی</a>
                                                            <div class="droopmenu-tabcontent">
                                                                <div class="droopmenu-row">
                                                                    <ul class="droopmenu-col droopmenu-col4">
                                                                        <li>
                                                                            <h4>محصولات</h4>
                                                                        </li>
                                                                        <li><a href="products.html">لوازم آرایشی</a>
                                                                        </li>
                                                                        <li><a href="products.html">شامپو</a></li>
                                                                        <li><a href="products.html">نرم کننده</a>
                                                                        </li>
                                                                        <li><a href="products.html">برس و شانه</a>
                                                                        </li>
                                                                        <li><a href="products.html">انواع ماسک</a>
                                                                        </li>
                                                                        <li><a href="products.html">تقویت کننده
                                                                                مو</a></li>
                                                                        <li><a href="products.html">رنگ مو</a></li>
                                                                        <li><a href="products.html">دستمال کاغذی</a>
                                                                        </li>
                                                                        <li><a href="products.html">سایر محصولات</a>
                                                                        </li>
                                                                    </ul>
                                                                    <ul class="droopmenu-col droopmenu-col4">
                                                                        <li>
                                                                            <h4>برند ها</h4>
                                                                        </li>
                                                                        <li><a href="products.html">صحت</a></li>
                                                                        <li><a href="products.html">پرژک</a></li>
                                                                        <li><a href="products.html">داروگر</a></li>
                                                                        <li><a href="products.html">طبیعت</a></li>
                                                                        <li><a href="products.html">گلرنگ</a></li>
                                                                        <li><a href="products.html">گلنار</a></li>
                                                                        <li><a href="products.html">کلیر</a></li>
                                                                        <li><a href="products.html">شبنم</a></li>
                                                                        <li><a href="products.html">آیسان</a></li>
                                                                    </ul>
                                                                    <ul
                                                                        class="droopmenu-col droopmenu-col4 d-none d-lg-inline-block">
                                                                        <li><img src="assets/images/megamenu/megamenu-image5.png"
                                                                                alt=""></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="droopmenu-parent" aria-haspopup="true">
                                                <a href="./blog.html" aria-expanded="false">بلاگ آموزشی<em
                                                        class="droopmenu-topanim"></em></a>
                                                <div class="dm-arrow"></div>
                                                <ul style="">
                                                    <li><a href="./blog.html">آرشیو مطالب</a></li>
                                                    <li><a href="./blog-post.html">داخلی بلاگ</a></li>
                                                </ul>
                                            </li>
                                            <li class="droopmenu-parent" aria-haspopup="true">
                                                <a href="profile/personal-info.html" aria-expanded="false">پروفایل
                                                    کاربری<em class="droopmenu-topanim"></em></a>
                                                <div class="dm-arrow"></div>
                                                <ul style="">
                                                    <li><a href="profile/personal-info.html">مشخصات کاربری</a></li>
                                                    <li><a href="profile/factors.html">سفارشات</a></li>
                                                    <li><a href="profile/addresses.html">آدرس ها</a></li>
                                                    <li><a href="profile/favorites.html">علاقه مندی ها</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- /Header Menu Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main NavBar -->
</section>
