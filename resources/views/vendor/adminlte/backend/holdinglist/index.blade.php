@extends('adminlte::backend.layouts.member')

@section('htmlheader_title')
    {{ trans('adminlte_lang::user.header_title') }}
@endsection

@section('contentheader_description')
{{ trans('adminlte_lang::user.manager') }}
@endsection

@section('main-content')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body" style="padding-top:0;">
                <div class="result-set">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="user-grid">
                            <thead class="text-primary">
                                <th>Name</th>
                                <th>Total All</th>
                                <th>From Date to Date</th>
                            </thead>
                            <thead>
                                <tr>
                                    <td><input type="text" data-column="0"  class="search-input-text"></td>
                                    <th></td>
                                    <td>
                                        <input type="text" data-column="2" name="daterange" class="search-input-select">
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<script>
  $(document).ready(function() {

    $('input[name="daterange"]').daterangepicker({
      locale: {
        format: 'DD/MM/YYYY'
      }
    });

    var dataTableHoldingList = $('#user-grid').DataTable( {
      "processing": true,
      'language':{
        "loadingRecords": "&nbsp;",
        "processing": "Updating..."
      },
      "serverSide": true,
      "ordering": true,
      "columnDefs": [
        {
          "targets": 0,
          "orderable": false
        },
        {
          "targets": 2,
          "orderable": false
        },
      ],
      "order": [[ 2, "desc" ]],
      "ajax":{
        url :"/report/holdinguser/userdata", // json datasource
        type: "get",  // method  , by default get
        error: function(){  // error handling
          $(".user-grid-error").html("");
          $("#user-grid").append('<tbody class="user-grid-error"><tr><th colspan="3">No data available in table</th></tr></tbody>');
          $("#user-grid_processing").css("display","none");
        },
        complete : function (dataTableHoldingList) {
          console.log(dataTableHoldingList)
        }
      }
    });

    $("#user-grid_filter").css("display","none");  // hiding global search box

    $('.search-input-text').on( 'keyup', function () {   // for text boxes
      var i =$(this).attr('data-column');  // getting column index
      var v =$(this).val();  // getting search input value
      dataTableHoldingList.columns(i).search(v).draw();
    } );

    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
      var i =$('.search-input-select').attr('data-column');
      var v =$('.search-input-select').val();
      dataTableHoldingList.columns(i).search(v).draw();
    });

  });
</script>

@endsection