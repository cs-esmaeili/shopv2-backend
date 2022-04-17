@extends('partials.main')
@section('content')
    <section class="inner-page" id="contact-page">
        <div class="container-fluid" id="page-hero">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 px-0">
                                <h1>ورود به ناحیه کاربری</h1>
                                <p>وارد ناحیه کاربری خود در روبیک مارکت شوید.</p>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="./index.html">صفحه نخست</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">ورود</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-2 py-md-5" id="logIn_container"></div>

    </section>
@section('script')
    <script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>
    <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Load our React component. -->
    <script type="text/babel" src={{ asset('assets/js/logIn.js') }}></script>
@endsection
@endsection
