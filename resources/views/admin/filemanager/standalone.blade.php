<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <title>elFinder 2.0</title>

        <!-- jQuery and jQuery UI (REQUIRED) -->
        <link rel="stylesheet" href="/jquery-ui-1.13.2/jquery-ui.min.css" />
        <script src="/jquery-ui-1.13.2/external/jquery/jquery.js"></script>
        <script src="/jquery-ui-1.13.2/jquery-ui.min.js"></script>

        <!-- elFinder CSS (REQUIRED) -->
        <link rel="stylesheet" type="text/css" href="{{ asset($dir . '/css/elfinder.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset($dir . '/css/theme.css') }}">

        <!-- elFinder JS (REQUIRED) -->
        <script src="{{ asset($dir . '/js/elfinder.min.js') }}"></script>

        @if($locale)
            <!-- elFinder translation (OPTIONAL) -->
            <script src="{{ asset($dir . "/js/i18n/elfinder.$locale.js") }}"></script>
        @endif
        <!-- Include jQuery, jQuery UI, elFinder (REQUIRED) -->

        <script type="text/javascript">
            $().ready(function () {
                var elf = $('#elfinder').elfinder({
                    // set your elFinder options here
                    @if($locale)
                        lang: '{{ $locale }}', // locale
                    @endif
                    customData: { 
                        _token: '{{ csrf_token() }}'
                    },
                    url: '{{ route("elfinder.connector") }}',  // connector URL
                    soundPath: '{{ asset($dir.'/sounds') }}',
                    dialog: {width: 900, modal: true, title: 'Select a file'},
                    resizable: false,
                    commandsOptions: {
                        getfile: {
                            oncomplete: 'destroy'
                        },
                        upload: {
                            multiple: true,
                        }
                    },
                    getFileCallback: function (file) {
                        // console.log(file);
                        ifVariation = parseInt('{!! Input::get('variation', 0) !!}');
                        ifFile = parseInt('{!! Input::get('file', 0) !!}');
                        if(ifFile > 1)
                            window.opener.setVideoUrl("{!! $base_path !!}/"+file.path);
                        else if(ifFile > 0)
                            window.opener.setFileUrl("{!! $base_path !!}/"+file.path);
                        else if(ifVariation > 0)
                            window.opener.setUrlForVariations("{!! $base_path !!}/"+file.path);
                        else
                            window.opener.setUrl("{!! $base_path !!}/"+file.path);
                            window.close();
                    }
                }).elfinder('instance');
            });
        </script>

    </head>
    <body>

        <!-- Element where elFinder will be created (REQUIRED) -->
        <div id="elfinder"></div>

    </body>
</html>
