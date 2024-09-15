@extends('admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="/jquery-ui-1.13.2/jquery-ui.min.css" />
    
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    <!-- jQuery and jQuery UI (REQUIRED) -->
    <script src="/jquery-ui-1.13.2/external/jquery/jquery.js"></script>
    <script src="/jquery-ui-1.13.2/jquery-ui.min.js"></script>

    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/theme.css') }}">
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!-- elFinder JS (REQUIRED) -->
    <script src="{{ asset($dir.'/js/elfinder.min.js') }}"></script>
    
    @if($locale)
        <!-- elFinder translation (OPTIONAL) -->
        <script src="{{ asset($dir."/js/i18n/elfinder.$locale.js") }}"></script>
    @endif

    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
        // Documentation for client options:
        // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
        $().ready(function() {
            $('#elfinder').elfinder({
                // set your elFinder options here
                @if($locale)
                    lang: '{{ $locale }}', // locale
                @endif
                customData: { 
                    _token: '{{ csrf_token() }}'
                },
                url : '{{ route("elfinder.connector") }}',  // connector URL
                soundPath: '{{ asset($dir.'/sounds') }}',
                height: 600,
                commandsOptions: {
                    upload: {
                        multiple: true,
                    }
                }
            });
        });
    </script>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="/elfinder" class="link-dark link-underline-opacity-0">Filemanager</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Files</li>
                    </ol>
                </nav>
                <h2 id="table-group-dividers">
                    <strong>Filemanager</strong>
                    <a class="anchor-link" href="#table-group-dividers"></a>
                </h2>
            </div>
        </div>
        <!-- Element where elFinder will be created (REQUIRED) -->
        <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <div id="elfinder"></div>
                </div>
            </div>
            </div>
        </div>
    </div>

@stop
