@inject('helper', 'App\ViewHelper')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ elixir('js/app.js') }}"></script>
    <script> {!! $helper->initGlobalJsVars(@$name) !!} </script>
</head>
<body>
    @include('_nav')

    @yield('content')

    <!-- include('stats') -->
    <!-- include('prayers') -->

    <!-- Scripts -->
    @yield('footer_script')
    @include('_footer')
</body>
</html>