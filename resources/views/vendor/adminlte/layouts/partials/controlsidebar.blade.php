<?php 
    use App\Http\Controllers\News\DisplayNewsController as News;
    $tempNews = new News();
    $news = $tempNews->getNewsDataDisplay();
    $title = $tempNews->category;
    $i = 1;
?>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            @foreach ($news as $data)
                <h3 class="control-sidebar-heading">{{ $title[$i] }}</h3>
                <ul class='control-sidebar-menu'>
                @foreach ($data as $new)
                <li title="read more...">
                    <a href="/news/detail/{{ $new->id }}">
                        <i class="@if($i == 0)
                           menu-icon fa fa-newspaper-o bg-yellow
                           @elseif($i == 1)
                           menu-icon fa fa-newspaper-o bg-red
                           @elseif($i == 2)
                           menu-icon fa fa-newspaper-o bg-light-blue
                           @else
                           menu-icon fa fa-newspaper-o bg-green
                           @endif
                           "></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">
                                {{ $new->title }}
                            </h4>
                            <p>{{ $new->short_desc }}</p>
                        </div>
                    </a>
                </li>
                @endforeach
                </ul>
                <?php $i++ ;?>
            @endforeach
        </div>
        
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">{{ trans('adminlte_lang::message.statstab') }}</div><!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading">{{ trans('adminlte_lang::message.generalset') }}</h3>
                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        {{ trans('adminlte_lang::message.reportpanel') }}
                        <input type="checkbox" class="pull-right" {{ trans('adminlte_lang::message.checked') }} />
                    </label>
                    <p>
                        {{ trans('adminlte_lang::message.informationsettings') }}
                    </p>
                </div><!-- /.form-group -->
            </form>
        </div><!-- /.tab-pane -->
    </div>
</aside><!-- /.control-sidebar

<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>
<script>
    
if(getCookie("open") != 0 && getCookie("open") != 1 ){
    document.cookie = "open=1";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

if(getCookie("open") == 1)
    $(".control-sidebar").addClass("control-sidebar-open")
</script>