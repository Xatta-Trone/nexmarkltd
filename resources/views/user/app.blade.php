<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    @include('user.partials.head')
</head>

<body>
    <div id="app">
        <!-- Start Header Area -->
        @include('user.partials.header')
        @include('user.partials.nav')

        <!-- End Header Area -->

        @section('main_content')
        @show
    </div>



    <!-- start footer Area -->
    @include('user.partials.footer')

    <!-- End footer Area -->


</body>

</html>