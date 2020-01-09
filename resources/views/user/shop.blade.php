@extends('user.app')

@section('title','Shop')
@section('extra_header')

<style>
    .sidebar-categories .head,
    .filter-bar {
        background: #ff8b00;
    }

    .img-fluid {
        height: 200px;
    }

    .single-product .product-details h6 {
        text-transform: none;
    }

    .single-product img {
        width: auto;
        margin-bottom: 0;
    }

    .product-details {
        text-align: left;
    }

    .single-product {
        text-align: center;
        /* box-shadow: 0px 0px 10px #eee; */

    }

    .product-details {
        padding: 10px 10px 5px;
    }
</style>
@endsection


@section('main_content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Products</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Products</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<div class="container">
    <all-products />
</div>
{{-- {{ dd($categories)}} --}}

{{-- <div class="col-xl-3 col-lg-4 col-md-5 ">
            <div class="sidebar-categories">
                <div class="head">Categories</div>
                <ul class="main-categories">
                    <li class="main-nav-list">
                        <a href="{{ route('shop') }}">
<span class="lnr lnr-arrow-right"></span>
All products

</a>
</li>

@foreach ($categories as $category)

<li class="main-nav-list">
    <a data-toggle="collapse" href="#{{$category->slug}}" aria-expanded="false" aria-controls="{{$category->slug}}">
        <span class="lnr lnr-arrow-right"></span>
        {{ $category->name }}

    </a>
    <ul class="collapse" id="{{$category->slug}}" data-toggle="collapse" aria-expanded="false"
        aria-controls="{{$category->slug}}">

        @foreach ($category->children as $sub_category)
        <li class="main-nav-list child">
            <a href="{{ request()->fullUrlWithQuery(['cat' => $sub_category->slug]) }}">{{ $sub_category->name }}</a>
        </li>
        @endforeach


    </ul>
</li>
@endforeach

</ul>
</div>

</div> --}}
{{-- <div class="col-xl-9 col-lg-8 col-md-7"> --}}
<!-- Start Filter Bar -->
{{-- @if (request()->get('cat') != null || request()->get('query') != null)
<div class="filter-bar py-3 d-flex flex-wrap align-items-center">


    <span class="text-white">Showing products for
        <strong>{{ request()->get('cat')}}{{ request()->get('query') }}</strong> </span>



<div class="sorting mr-auto">
    <select>
        <option value="1">Show 12</option>
        <option value="1">Show 12</option>
        <option value="1">Show 12</option>
    </select>
</div>

</div>
@endif --}}
<!-- End Filter Bar -->


<!-- Start Best Seller -->
{{-- <section class="lattest-product-area pb-40 category-list">
                <div class="row">



                    @if($products->count() == 0)
                    <div class="col-12 text-center py-3">
                        <h2>No product found</h2>
                    </div>

                    @endif

                    @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-product">
                            <img class="img-fluid" src="{{ asset('storage/thumbnail/'.$product->image) }}"
alt="{{ $product->slug }}" height="200px" width="auto">
<div class="product-details">
    <h6>{{ $product->name }}</h6>
    <div class="price">
        <span class="currency">
            ৳
        </span>

        <h6>{{sprintf("%0.2f",$product->price)}}</h6>
    </div>
    <div class="prd-bottom">

        <a href="" class="social-info">
            <span class="ti-bag"></span>
            <p class="hover-text">add to bag</p>
        </a>
        <a href="" class="social-info">
            <span class="lnr lnr-heart"></span>
            <p class="hover-text">Favorite</p>
        </a>

        <a href="" class="social-info">
            <span class="lnr lnr-move"></span>
            <p class="hover-text">view more</p>
        </a>
    </div>
</div>
</div>
</div>
@endforeach



</div>
</section> --}}
<!-- End Best Seller -->

{{-- <div>
    <h2>vue </h2>


</div>

</div>
</div> --}}

@endsection

@section('extra_footer')
<script>


</script>




@endsection