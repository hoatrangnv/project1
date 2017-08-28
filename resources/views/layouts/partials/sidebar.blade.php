<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <!--form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form-->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li {{ Request::is('home') ? 'class=active' : '' }}><a href="{{ url('home') }}"><i class='fa fa-link'></i> <span>{{ trans('adminlte_lang::default.side_dashboard') }}</span></a></li>
            <li {{ Request::is('home') ? 'class=active' : '' }}><a href="{{ url('home') }}"><i class='fa fa-link'></i> <span>{{ trans('adminlte_lang::default.side_dashboard') }}</span></a></li>
			<li class="treeview{{ Request::segment(1) === 'members' ? ' active' : null }}">
				<a href="#">
					<i class='fa fa-link'></i> <span>{{ trans('adminlte_lang::default.side_member') }}</span> 
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
                    <li class="{{ Request::segment(2) === 'genealogy' ? 'active' : null }}"><a href="{{ url('members/genealogy') }}">{{ trans('adminlte_lang::default.side_member_genealogy') }}</a></li>
                    <li class="{{ Request::segment(2) === 'binary' ? 'active' : null }}"><a href="{{ url('members/binary') }}">{{ trans('adminlte_lang::default.side_member_binary') }}</a></li>
                    <li class="{{ Request::segment(2) === 'refferals' ? 'active' : null }}"><a href="{{ url('members/refferals') }}">{{ trans('adminlte_lang::default.side_member_refferals') }}</a></li>
                </ul>
			</li>
            <li class="{{ Request::segment(1) === 'users' ? 'active' : null }}"><a href="{{ url('users') }}"><i class='fa fa-link'></i> <span>Member</span></a></li>
            <li class="{{ Request::segment(1) === 'permissions' ? 'active' : null }}"><a href="{{ url('permissions') }}"><i class='fa fa-link'></i> <span>Permissions</span></a></li>
            <li class="{{ Request::segment(1) === 'roles' ? 'active' : null }}"><a href="{{ url('roles') }}"><i class='fa fa-link'></i> <span>Roles</span></a></li>
			<li class="treeview{{ Request::segment(1) === 'wallets' ? ' active' : null }}">
				<a href="#"><i class='fa fa-link'></i> <span>{{ trans('adminlte_lang::default.side_wallet') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
                    <li class="{{ Request::segment(2) === 'usd' ? 'active' : null }}"><a href="{{ url('wallets/usd') }}">{{ trans('adminlte_lang::default.side_wallet_usd') }}</a></li>
                    <li class="{{ Request::segment(2) === 'btc' ? 'active' : null }}"><a href="{{ url('wallets/btc') }}">{{ trans('adminlte_lang::default.side_wallet_btc') }}</a></li>
                    <li class="{{ Request::segment(2) === 'clp' ? 'active' : null }}"><a href="{{ url('wallets/clp') }}">{{ trans('adminlte_lang::default.side_wallet_clp') }}</a></li>
                    <li class="{{ Request::segment(2) === 'reinvest' ? 'active' : null }}"><a href="{{ url('wallets/reinvest') }}">{{ trans('adminlte_lang::default.side_wallet_reinvest') }}</a></li>
                </ul>
			</li>
			<li class="treeview{{ Request::segment(1) === 'mybonus' ? ' active' : null }}">
				<a href="#"><i class='fa fa-link'></i> <span>{{ trans('adminlte_lang::default.side_mybonus') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
                    <li class="{{ Request::segment(2) === 'faststart' ? 'active' : null }}"><a href="{{ url('mybonus/faststart') }}">{{ trans('adminlte_lang::default.side_mybonust_fast') }}</a></li>
                    <li class="{{ Request::segment(2) === 'binary' ? 'active' : null }}"><a href="{{ url('mybonus/binary') }}">{{ trans('adminlte_lang::default.side_mybonus_binary') }}</a></li>
                    <li class="{{ Request::segment(2) === 'loyalty' ? 'active' : null }}"><a href="{{ url('mybonus/loyalty') }}">{{ trans('adminlte_lang::default.side_mybonus_loyalty') }}</a></li>
                </ul>
			</li>
			
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
