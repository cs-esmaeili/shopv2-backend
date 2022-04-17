<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>فروشگاه</title>
    <!-- CSS Styles -->
    <link rel="stylesheet" href={{ asset('assets/css/bootstrap.rtl.min.css') }}>
    <link rel="stylesheet" href={{ asset('ssets/plugins/fontawesome/css/all.min.css') }}>
    <link rel="stylesheet" href={{ asset('assets/plugins/aos-master/dist/aos.css') }}>
    <link rel="stylesheet" href={{ asset('assets/plugins/hover-master/css/hover-min.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/ionicons.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/droopmenu.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/highlight.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/nouislider.min.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/style.css') }}>
    <!-- /CSS Styles -->
</head>

<body>
    <!-- Header -->
    @include('partials.header')
    <!-- /Header -->

    @yield('content')

    <!-- Footer -->
    @include('partials.footer')
    <!-- /Footer -->


    <!-- Scripts -->
    <script src={{ asset('assets/js/jquery.min.js') }}></script>
    <script src={{ asset('assets/js/bootstrap.bundle.min.js') }}></script>
    <script src={{ asset('assets/plugins/fontawesome/js/all.min.js') }}></script>
    <script src={{ asset('assets/plugins/aos-master/dist/aos.js') }}></script>
    <script src={{ asset('assets/js/droopmenu.js') }}></script>
    <script src={{ asset('assets/js/nouislider.min.js') }}></script>
    <script src={{ asset('assets/js/pagination.js') }}></script>
    <script src={{ asset('assets/js/scripts.js') }}></script>
    @yield('script')
    <!-- /Scripts -->
</body>

</html>
