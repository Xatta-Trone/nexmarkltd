<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    @include('user.partials.head')
</head>

<body>

    <!-- Start Header Area -->
    @include('user.partials.header')
    @include('user.partials.nav')

    <!-- End Header Area -->
    <div id="app">
        @section('main_content')
        @show
    </div>



    <!-- start footer Area -->
    @include('user.partials.footer')

    <!-- End footer Area -->


</body>

</html>