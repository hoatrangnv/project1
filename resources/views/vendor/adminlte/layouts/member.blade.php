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
                <div class="col-md-9" >
                    @yield('main-content')
                </div>
                <div class="col-md-3">
                    <div class="box box-danger row">
                        <div class="box-header with-border">
                           <h3 class="box-title">Crypto news</h3>

                           <div class="box-tools pull-right">
                               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                               </button>
                               <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                               </button>
                           </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding" style="">

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center" style="">
                           <a href="javascript:void(0)" class="uppercase">View more</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <div class="box box-danger row">
                        <div class="box-header with-border">
                          <h3 class="box-title">Blockchain news</h3>

                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                          </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding" style="">

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center" style="">
                          <a href="javascript:void(0)" class="uppercase">View more</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <div class="box box-danger row">
                        <div class="box-header with-border">
                           <h3 class="box-title">CLP news</h3>

                           <div class="box-tools pull-right">
                               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                               </button>
                               <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                               </button>
                           </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding" style="">

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center" style="">
                          <a href="javascript:void(0)" class="uppercase">View more</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <div class="box box-danger row">
                        <div class="box-header with-border">
                            <h3 class="box-title">P2P news</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding" style="">
                            
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center" style="">
                          <a href="javascript:void(0)" class="uppercase">View more</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    @include('adminlte::layouts.partials.controlsidebar')

    @include('adminlte::layouts.partials.footer')

</div><!-- ./wrapper -->
</div>


</body>
</html>
