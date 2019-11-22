<aside class="main-sidebar">
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                @if(isset(auth()->user()->user_image))
                <img src="{{ asset('laravel/public/images/user/'.auth()->user()->user_image) }}" class="img-circle" alt="User Image">
                @else
                <img src="{{ asset('images/avater.png') }}" class="img-circle" alt="User Image">
                @endif
            </div>
            <div class="pull-left info">
                <p>
                    @if (isset(auth()->user()->username))
                        {{ auth()->user()->username }}
                    @else
                        {{ auth()->user()->name }}
                    @endif
                </p>
                <!-- Status -->
                <a href=""><i class="fa fa-circle text-success"></i>
                {{ auth()->user()->admin_role }}
                </a>
            </div>
        </div>

        <!-- search form (Optional) -->
        {{-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                            class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form> --}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            @canany(['isAdmin','isSuperAdmin'])
            <li class="header">Members</li>
            <!-- Optionally, you can add icons to the links -->
            @can('isSuperAdmin')
            <li><a href="/admin/all_admin"><i class="fa fa-link"></i> <span>Admins</span></a></li>
            @endcan

           
            @foreach ($role_menu as $role)
            <li><a href="/admin/users/{{ $role->id }}"><i class="fa fa-link"></i> <span>{{ $role->name }}</span></a></li>
            @endforeach

            <li><a href="/admin/investors"><i class="fa fa-link"></i> <span>Investors</span></a></li>

            <li class="header">Business</li>
            
            <!--<li><a href="/admin/products"><i class="fa fa-link"></i> <span>Products</span></a></li>-->

           

            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Income</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    
                    @can('isSuperAdmin')
                    @foreach ($income_menu as $menu)
                    <li><a href="/admin/income/{{ $menu->id }}">{{ $menu->name }}</a></li>
                    @endforeach
                    @endcan
                    <li><a href="/admin/income_report">Report</a></li>
                    @can('isSuperAdmin')
                    <li><a href="/admin/income_sectors">Add Sector</a></li>
                    @endcan
                </ul>
            </li>

            @endcanany
            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Expences</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/report">Report</a></li>
                    @can('isSuperAdmin')
                    <li><a href="/admin/salary">Salary</a></li>
                    @foreach ($expense_menu as $menu)
                    <li><a href="/admin/expense/{{ $menu->id }}">{{ $menu->name }}</a></li>
                    @endforeach
                    @endcan
                </ul>
            </li>
            @canany(['isAdmin','isSuperAdmin'])
            <li><a href="/admin/investment"><i class="fa fa-link"></i> <span>Investments</span></a></li>

            @can('isSuperAdmin')
            <li class="header">Settings/Fields</li>

            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Business</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/sectors">All</a></li>
                    @foreach ($expense_menu as $menu)
                    <li><a href="/admin/sectors/{{ $menu->id }}">{{ $menu->name }}</a></li>
                    @endforeach
                </ul>
            </li>

            <li><a href="/admin/employee_roles"><i class="fa fa-link"></i> <span>Employee Roles</span></a></li>

            <!--<li><a href="/admin/business"><i class="fa fa-link"></i> <span>Business Settings</span></a></li>-->
            @endcan
            @endcanany

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
