@extends('adminlte::layouts.member')
@section('contentheader_title')
    {{ $title }}
@endsection
@section('main-content')
    @if ( session()->has("errorMessage") )
        <div class="callout callout-danger">
            <h4>Warning!</h4>
            <p>{!! session("errorMessage") !!}</p>
        </div>
        {{ session()->forget('errorMessage') }}
    @elseif ( session()->has("successMessage") )
        <div class="callout callout-success">
            <h4>Success</h4>
            <p>{!! session("successMessage") !!}</p>
        </div>
        {{ session()->forget('successMessage') }}
    @else
        <div></div>
    @endif
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box">
          <div class="nav-tabs-custom">
            <div class="tab-content">
              <div class="tab-pane active" id="clpnews">
                <!-- Post -->
                @foreach($listNews as $news)
                <div class="post">
                  <div class="user-block">
                    <span class="username" style="margin-left: 0px;">
                      <a href="/news/detail/{{ $news->id }}" class="list_news" data-id="{{ $news->id }}">
                          {{ $news->title }}
                          <small class="label bg-yellow"></small>
                      </a>
                    </span>
                    @if(date('Y-m-d', strtotime($news->created_at)) == date('Y-m-d'))
                      <span class="description" style="margin-left: 0px;">Today</span>
                    @else
                      <span class="description" style="margin-left: 0px;">{{ date('Y-m-d', strtotime($news->created_at)) }}</span>
                    @endif
                  </div>
                  <!-- /.user-block -->
                  <p>
                    {{ $news->short_desc }}
                  </p>
                </div>
                <!-- /.post -->
                @endforeach
                @if(count($listNews) == 0)
                  <p>
                    <i>There are no matching entries</i>
                  </p>
                @endif
                <div class="text-center">
                        {{ $listNews->links() }}
                    </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
        <!-- /.col -->
        <script>
            $(document).ready(function () {
                storage = $.localStorage;

                var arr = new Array();
                arr[0] = 1;
                if(storage.get("{{ $type }}_news") != null) arr = JSON.parse(JSON.stringify(storage.get("{{ $type }}_news")));

                $('.list_news').each( function(){
                    if($.inArray($(this).data('id'), arr) == -1)
                    {
                      $(this).find('small').text("New");
                    }
                });

                $('.list_news').on('click', function() {
                    if($.inArray($(this).data('id'), arr) == -1)
                    {
                      $(this).find('small').text("");
                      arr.push($(this).data('id'));
                      storage.set('{{ $type }}_news', JSON.stringify(arr));
                    }
                });
            });
        </script>
@endsection
