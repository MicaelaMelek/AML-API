<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>AML</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('styles')

    <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body>
        <div class="container">
            
            @yield('content')

        </div>
        
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
