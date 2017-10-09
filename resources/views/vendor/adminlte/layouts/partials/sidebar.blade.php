<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
<!--        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                     <img src="{{ Gravatar::get(Auth()->user()->email) }}" class="img-circle" alt="User Image" /> 
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                     Status 
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif-->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
             <li class="header" ></li> 
            <!-- Optionally, you can add icons to the links -->
            <li {{ Request::is('home') ? 'class=active' : '' }}><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>{{ trans('adminlte_lang::default.side_dashboard') }}</span></a></li>
            <li class="treeview{{ Request::segment(1) === 'members' ? ' active' : null }}">
                <a href="#">
                    <i class='fa fa-address-book'></i> <span>{{ trans('adminlte_lang::default.side_member') }}</span>
                    <span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(2) === 'genealogy' ? 'active' : null }}"><a href="{{ url('members/genealogy') }}">{{ trans('adminlte_lang::default.side_member_genealogy') }}</a></li>
                    <li class="{{ Request::segment(2) === 'binary' ? 'active' : null }}"><a href="{{ url('members/binary') }}">{{ trans('adminlte_lang::default.side_member_binary') }}</a></li>
                    <li class="{{ Request::segment(2) === 'refferals' ? 'active' : null }}"><a href="{{ url('members/referrals') }}">{{ trans('adminlte_lang::default.side_member_refferals') }}</a></li>
                </ul>
            </li>
            @can('view_users')
                <li class="{{ Request::is('users*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}">
                        <i class="glyphicon glyphicon-user"></i> Users
                    </a>
                </li>
                <li class="{{ Request::is('users/root') ? 'active' : '' }}">
                    <a href="{{ route('users.root') }}">
                        <i class="glyphicon glyphicon-user"></i> List Root
                    </a>
                </li>
                <li class="{{ Request::is('users/photo_approve') ? 'active' : '' }}">
                    <a href="{{ route('users.photo_approve') }}">
                        <i class="glyphicon glyphicon-user"></i> List Approve
                    </a>
                </li>
            @endcan
            @can('view_roles')
                <li class="{{ Request::is('roles*') ? 'active' : '' }}">
                    <a href="{{ route('roles.index') }}">
                        <i class='glyphicon glyphicon-lock'></i> Roles</a>
                    </a>
                </li>
            @endcan
            @can('view_packages')
                <li class="{{ Request::is('packages*') && !Request::is('packages/invest') ? 'active' : '' }}">
                    <a href="{{ route('packages.index') }}">
                        <i class="glyphicon glyphicon-user"></i> Packages
                    </a>
                </li>
            @endcan
            <li class="treeview{{ Request::is('wallets*') ? ' active' : null }}">
                <a href="#"><i class='fa fa-credit-card'></i> <span>{{ trans('adminlte_lang::default.side_wallet') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(2) === 'btc' ? 'active' : null }}"><a href="{{ url('wallets/btc') }}">{{ trans('adminlte_lang::default.side_wallet_btc') }}</a></li>
                    <li class="{{ Request::segment(2) === 'clp' ? 'active' : null }}"><a href="{{ url('wallets/clp') }}">{{ trans('adminlte_lang::default.side_wallet_clp') }}</a></li>
                    <li class="{{ Request::segment(2) === 'usd' ? 'active' : null }}"><a href="{{ url('wallets/usd') }}">{{ trans('adminlte_lang::default.side_wallet_usd') }}</a></li>
                    <li class="{{ Request::segment(2) === 'reinvest' ? 'active' : null }}"><a href="{{ url('wallets/reinvest') }}">{{ trans('adminlte_lang::default.side_wallet_reinvest') }}</a></li>
                </ul>
            </li>
            <li class="treeview{{ Request::is('mybonus*') ? ' active' : null }}">
                <a href="#"><i class='fa fa-money'></i> <span>{{ trans('adminlte_lang::default.side_mybonus') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(2) === 'faststart' ? 'active' : null }}"><a href="{{ url('mybonus/faststart') }}">{{ trans('adminlte_lang::default.side_mybonust_fast') }}</a></li>
                    <li class="{{ Request::segment(2) === 'binary' ? 'active' : null }}"><a href="{{ url('mybonus/binary') }}">{{ trans('adminlte_lang::default.side_mybonus_binary') }}</a></li>
                    <li class="{{ Request::segment(2) === 'loyalty' ? 'active' : null }}"><a href="{{ url('mybonus/loyalty') }}">{{ trans('adminlte_lang::default.side_mybonus_loyalty') }}</a></li>
                </ul>
            </li>
            @can('view_news')
            <li class="treeview{{ Request::is('news*') ? ' active' : null }}">
                <a href="#"><i class='fa fa-newspaper-o'></i> <span>{{ trans('adminlte_lang::default.news') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(2) === 'manage' ? 'active' : null }}"><a href="{{ url('news/manage') }}">{{ trans('adminlte_lang::default.manage') }}</a></li>
                    <li class="{{ Request::segment(2) === 'add' ? 'active' : null }}"><a href="{{ url('news/add') }}">{{ trans('adminlte_lang::default.add') }}</a></li>
                </ul>
            </li>
            @endcan
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
