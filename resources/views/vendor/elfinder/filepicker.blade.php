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
                    resizable: false,
                    ui: ['toolbar', 'path','stat'],
                    onlyMimes: [{{ $mimeTypes }}],
                    rememberLastDir : false,
                    height: 300,
                    defaultView: 'list',
                    getFileCallback: function (file) {
                        window.parent.processSelectedFile(file, '{{ $input_id }}');
                        console.log(file);
                    },
                    uiOptions : {
                        // toolbar configuration
                        toolbar : [
                            ['home', 'up'],
                            ['upload'],
                            ['quicklook'],
                        ],
                        // directories tree options
                        tree : {
                            // expand current root on init
                            openRootOnLoad : true,
                            // auto load current dir parents
                            syncTree : true
                        },
                        // navbar options
                        navbar : {
                            minWidth : 150,
                            maxWidth : 500
                        },
                        // current working directory options
                        cwd : {
                            // display parent directory in listing as ".."
                            oldSchool : false
                        }
                    }
                }).elfinder('instance');
            });
        </script>
    </head>
    <body style="margin: 0;">

        <!-- Element where elFinder will be created (REQUIRED) -->
        <div id="elfinder"></div>

    </body>
</html>
