<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ asset('admin_asset/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>{{ auth()->user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- search form -->
    {{-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
            </span>
        </div>
    </form> --}}
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="{{ route('admin.home') }}"><i class="fa fa-circle-o text-aqua"></i>Dashboard</a></li>

        <li class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>Categories</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('categories.index') }}"><i class="fa fa-circle-o"></i>All</a></li>
                <li><a href="{{ route('categories.create') }}"><i class="fa fa-circle-o"></i> Create</a></li>
            </ul>
        </li>

        <li class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>Shops</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('shops.index') }}"><i class="fa fa-circle-o"></i>All</a></li>
                <li><a href="{{ route('shops.create') }}"><i class="fa fa-circle-o"></i> Create</a></li>
            </ul>
        </li>

        <li class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>Admins</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('admins.index') }}"><i class="fa fa-circle-o"></i>All</a></li>
                <li><a href="{{ route('admins.create') }}"><i class="fa fa-circle-o"></i> Create</a></li>
            </ul>
        </li>

        <li class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>Permission</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('permissions.index') }}"><i class="fa fa-circle-o"></i>All</a></li>
                <li><a href="{{ route('permissions.create') }}"><i class="fa fa-circle-o"></i> Create</a></li>
            </ul>
        </li>

        <li class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>Roles</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('roles.index') }}"><i class="fa fa-circle-o"></i>All</a></li>
                <li><a href="{{ route('roles.create') }}"><i class="fa fa-circle-o"></i> Create</a></li>
            </ul>
        </li>

        <li class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>Products</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('products.index') }}"><i class="fa fa-circle-o"></i>All</a></li>
                <li><a href="{{ route('products.create') }}"><i class="fa fa-circle-o"></i> Add</a></li>
                <li><a href="{{ route('products.excell') }}"><i class="fa fa-circle-o"></i> Import</a></li>
            </ul>
        </li>

        <li class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>Orders</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('orders.index') }}"><i class="fa fa-circle-o"></i>All</a></li>
                <li><a href="{{ route('orders.create') }}"><i class="fa fa-circle-o"></i> Add</a></li>
                <li><a href="{{ route('order.setting') }}"><i class="fa fa-circle-o"></i> Settings</a></li>

            </ul>
        </li>




    </ul>
</section>