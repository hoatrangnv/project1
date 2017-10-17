<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
    @include('adminlte::backend.layouts.partials.htmlheader')
@show
<body class="skin-blue sidebar-mini">
<div id="app" v-cloak>
    <div class="wrapper">
    @include('adminlte::backend.layouts.partials.mainheader')

    @include('adminlte::backend.layouts.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('adminlte::backend.layouts.partials.contentheader')
        <!-- Main content -->
        <section class="content">
            @include('flash::message')
            <!-- Your Page Content Here -->
            @yield('main-content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    @include('adminlte::backend.layouts.partials.controlsidebar')
    @include('adminlte::backend.layouts.partials.footer')

</div><!-- ./wrapper -->
</div>
@section('scripts')
    @include('adminlte::backend.layouts.partials.scripts')
@show

</body>
</html>
