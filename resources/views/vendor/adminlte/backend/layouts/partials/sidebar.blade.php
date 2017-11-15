<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
             <li class="header" ></li> 
            <!-- Optionally, you can add icons to the links -->

            <li {{ Request::is('admin/home') ? 'class=active' : '' }}><a href="{{ url('admin/home') }}"><i class='fa fa-home'></i> <span>{{ trans('adminlte_lang::default.side_dashboard') }}</span></a></li>
            @can('view_users')
                <li class="{{ Request::is('users*') ? 'active' : '' }}">
                    <a href="/users">
                        <i class="glyphicon glyphicon-user"></i> Users
                    </a>
                </li>
            @endcan
            @can('view_reports')
                <li class="{{ Request::is('report*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="glyphicon glyphicon-user"></i> Report
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::segment(2) === '' ? 'active' : null }}"><a href="{{ url('report') }}">Statistics</a>
                        </li>
                        <li class="{{ Request::segment(2) === 'commission' ? 'active' : null }}">
                            <a href="{{ url('report/commission') }}">Commission
                            </a>
                        </li>
                        <li class="{{ Request::segment(2) === 'commission' ? 'active' : null }}">
                            <a href="{{ url('report/commission') }}">Top 50
                            </a>
                        </li>
                        
                        <li class="{{ Request::is('users/photo_approve') ? 'active' : '' }}">
                            <a href="{{ route('users.photo_approve') }}">
                                List Approve
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            <li class="{{ Request::is('roles*') ? 'active' : '' }}">
                <a href="{{ route('withdraw.list') }}">
                    <i class='glyphicon glyphicon-lock'></i> Withdraw Approve</a>
                </a>
            </li>
            <li class="{{ Request::is('roles*') ? 'active' : '' }}">
                <a href="{{ route('wallet.list') }}">
                    <i class='glyphicon glyphicon-lock'></i> Wallet History</a>
                </a>
            </li>
            @can('view_roles')
                <li class="{{ Request::is('roles*') ? 'active' : '' }}">
                    <a href="{{ route('roles.index') }}">
                        <i class='glyphicon glyphicon-lock'></i> Roles</a>
                    </a>
                </li>
            @endcan
            @can('view_news')
            <li class="treeview{{ Request::is('news*') ? ' active' : null }}">
                <a href="#"><i class='fa fa-newspaper-o'></i> <span>{{ trans('adminlte_lang::default.news') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) === 'news' ? 'active' : null }}"><a href="{{ url('news') }}">{{ trans('adminlte_lang::default.manage') }}</a></li>
                    <li class="{{ Request::segment(2) === 'create' ? 'active' : null }}"><a href="{{ url('news/create') }}">{{ trans('adminlte_lang::default.add') }}</a></li>
                </ul>
            </li>
            @endcan
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
