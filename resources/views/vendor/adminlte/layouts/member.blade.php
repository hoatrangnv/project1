<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
    @include('adminlte::layouts.partials.htmlheader')
@show

<script src="/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/AdminLTE/bower_components/bootstrap/dist/js/bootstrap-confirmation.min.js"></script>
<script src="/AdminLTE/bower_components/fastclick/lib/fastclick.js"></script>
<script src="/AdminLTE/dist/js/app.js"></script>
<body class="skin-purple sidebar-mini">
<div>
    <div class="wrapper">

    @include('adminlte::layouts.partials.mainheader')

    @include('adminlte::layouts.partials.sidebar')
    

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 0px !important;">

        @include('adminlte::layouts.partials.contentheader')

        <!-- Main content -->
        <section class="content">
            @include('flash::message')
            <!-- Your Page Content Here -->
            <div class="rows" >
               @yield('main-content')
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    
    @include('adminlte::layouts.partials.controlsidebar')

    @include('adminlte::layouts.partials.footer')
    

 

    </div><!-- ./wrapper -->
</div>
</body>
</html>
