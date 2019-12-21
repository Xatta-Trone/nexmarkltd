<!DOCTYPE html>
<html>

<head>
    @include('admin.partials.header')

</head>

<body class="hold-transition skin-green sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

        @include('admin.partials.topnav')

        <!-- =============================================== -->

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            @include('admin.partials.sidebar')
            <!-- /.sidebar -->
        </aside>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @section('main-content')
            @show

        </div>
        <!-- /.content-wrapper -->

        @include('admin.partials.footer')

</body>

</html>