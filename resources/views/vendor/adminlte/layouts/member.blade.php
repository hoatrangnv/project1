<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
    @include('adminlte::layouts.partials.htmlheader')
@show

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<script src="/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/AdminLTE/bower_components/fastclick/lib/fastclick.js"></script>
<script src="/AdminLTE/dist/js/adminlte.min.js"></script>
<script src="/AdminLTE/dist/js/demo.js"></script>
<body class="skin-blue sidebar-mini">
<div>
    <div class="wrapper">

    @include('adminlte::layouts.partials.mainheader')

    @include('adminlte::layouts.partials.sidebar')
    

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @include('adminlte::layouts.partials.contentheader')

        <!-- Main content -->
        <section class="content">
            @include('flash::message')
            <!-- Your Page Content Here -->
            <div class="row" >
                @if ( !Session::has('not_show_news') )
                <div class="col-md-9" >
                    @yield('main-content')
                </div>
                <div class="col-md-3">
                    @include('adminlte::news.display')
                </div>
                @else
                <div class="col-md-12" >
                    @yield('main-content')
                </div>
                {{ session()->forget('not_show_news') }}
                @endif
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    @include('adminlte::layouts.partials.controlsidebar')

    @include('adminlte::layouts.partials.footer')

</div><!-- ./wrapper -->
</div>

</body>
</html>
