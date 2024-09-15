@extends('admin.layouts.app')

@section('css')
    <!-- jQuery and jQuery UI (REQUIRED) -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    
    <!-- elFinder CSS (REQUIRED) -->
    {!! HTML::style('/jquery-ui-1.13.2/elfinder.min.css') !!}
    {!! HTML::style('/jquery-ui-1.13.2/theme.min.css') !!}
    {!! HTML::style('/jquery-ui-1.13.2/theme-gray.min.css') !!}
@endsection

@section('scripts')

<!-- jQuery and jQuery UI (REQUIRED) -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


<!-- elFinder JS (REQUIRED) -->
{!! HTML::script('/jquery-ui-1.13.2/jquery-ui.min.js') !!}

<!-- elFinder initialization (REQUIRED) -->
<script type="text/javascript" charset="utf-8">
    // Documentation for client options:
    // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
    $().ready(function() {
        $('#elfinder').elfinder({
            // set your elFinder options here

            customData: {
                _token: '<?= csrf_token() ?>'
            },
            url : '<?= route("elfinder.connector") ?>',  // connector URL
            height: 600
        });
    });
</script>
@stop

@section('breadcrumb')
  <a class="navbar-brand" href="#">{!! __('filemanager.media') !!}</a>
@stop

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header card-header-info card-header-icon">
          <div class="card-icon">
            <i class="bi bi-folder"></i>
          </div>
          <h4 class="card-title">{!! __('filemanager.filemanager') !!}</h4>
        </div>
        <div class="card-body px-0 px-md-3">
          <div id="elfinder"></div>
        </div>
      </div>

    </div>
  </div>
</div>
@stop
