<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="_token" content="{!! csrf_token() !!}" />
    <meta name="author" content="eShop" />
    
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
    <title>File Manager</title>

    <!-- jQuery and jQuery UI (REQUIRED) -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    <!-- elFinder CSS (REQUIRED) -->
    {!! HTML::style('/jquery-ui-1.13.2/elfinder.min.css') !!}
    {!! HTML::style('/jquery-ui-1.13.2/theme.min.css') !!}
    {!! HTML::style('/jquery-ui-1.13.2/theme-gray.min.css') !!}

</head>
<body>
    <!-- Element where elFinder will be created (REQUIRED) -->
    <div id="elfinder"></div>

    <!-- jQuery and jQuery UI (REQUIRED) -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    
    <!-- elFinder JS (REQUIRED) -->
    {!! HTML::script('/jquery-ui-1.13.2/jquery-ui.min.js') !!}
    {!! HTML::script('/jquery-ui-1.13.2/standalonepopup.min.js') !!}
    
    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
        // Helper function to get parameters from the query string.
            function getUrlParam(paramName) {
                var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
                var match = window.location.search.match(reParam) ;
    
                return (match && match.length > 1) ? match[1] : '' ;
            }
    
            $().ready(function() {
                var funcNum = getUrlParam('CKEditorFuncNum');
    
                var elf = $('#elfinder').elfinder({
                    // set your elFinder options here
    
                    customData: {
                        _token: '<?= csrf_token() ?>'
                    },
                    url: '<?= route("elfinder.connector") ?>',  // connector URL
                    height: 600,
                    getFileCallback : function(file) {
                        window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
                        window.close();
                    }
                }).elfinder('instance');
            });
    </script>
</body>
</html>
