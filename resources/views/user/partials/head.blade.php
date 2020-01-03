<!-- Mobile Specific Meta -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Favicon-->
<link rel="shortcut icon" href="{{ asset('user_asset/img/fav.png')}}">
<!-- Author Meta -->
<meta name="author" content="CodePixar">
<!-- Meta Description -->
<meta name="description" content="">
<!-- Meta Keyword -->
<meta name="keywords" content="">
<!-- meta character set -->
<meta charset="UTF-8">
<!-- Site Title -->
<title>@yield('title')</title>
<meta name="csrf-token" content="{{ csrf_token() }}">

<!--
    CSS
    ============================================= -->
<link rel="stylesheet" href="{{ asset('user_asset/css/linearicons.css')}}">
<link rel="stylesheet" href="{{ asset('user_asset/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{ asset('user_asset/css/themify-icons.css')}}">
<link rel="stylesheet" href="{{ asset('user_asset/css/bootstrap.css')}}">
<link rel="stylesheet" href="{{ asset('user_asset/css/owl.carousel.css')}}">
<link rel="stylesheet" href="{{ asset('user_asset/css/nice-select.css')}}">
<link rel="stylesheet" href="{{ asset('user_asset/css/nouislider.min.css')}}">
<link rel="stylesheet" href="{{ asset('user_asset/css/ion.rangeSlider.css')}}" />
<link rel="stylesheet" href="{{ asset('user_asset/css/ion.rangeSlider.skinFlat.css')}}" />
<link rel="stylesheet" href="{{ asset('user_asset/css/magnific-popup.css')}}">
<link rel="stylesheet" href="{{ asset('user_asset/css/main.css')}}">

@section('extra_header')

@show