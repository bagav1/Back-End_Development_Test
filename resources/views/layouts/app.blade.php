<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <link rel="icon" type="image/x-icon" href="{{ url('storage/img/icon_mg.png') }}">
    <title>Front de API</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
</head>

<body>
    <div id="app">
        @if ($rute == 'dashboard')
            <dashboard-component></dashboard-component>
        @elseif ($rute == 'register')
            <register-component></register-component>
        @elseif ($rute == 'login')
            <login-component></login-component>
        @endif
    </div>
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>

</html>
