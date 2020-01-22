<!DOCTYPE html>
<html lang="ne">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="{{ asset('smartadmin/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        div.row {
            clear: both;
        }
        div.col-md-12 {
            width: 100%;
            padding: 13px;
        }
        img {
            max-width: 100%;
        }

    </style>
    </head>
    <body lang="ne">
    <div class="container" lang="ne">
        {!! $data !!}
    </div>
    </body>
</html>