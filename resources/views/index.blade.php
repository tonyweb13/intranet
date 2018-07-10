<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ARB VPS System</title>
    <link href="{{ mix('css/template.css') }}" rel="stylesheet">
    @if(\Auth::check())
        @include('vps.js_vars')
    @else
    <script>
        sessionStorage.clear();
    </script>
    @endif
</head>
<body class="gray-bg">
    <div id="vps-app"></div>
    <script src="{{ mix('js/template.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/loan_matrix.js') }}"></script>
</body>
</html>
