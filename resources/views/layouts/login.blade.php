<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Merchant Factors - Portal') }}</title>
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images') }}/favicon.ico">
        <!-- Fonts -->     
        <!-- Icons -->
        @include('partials.styles')
        {!! Html::style('css/legacy/login.css?v='. config('app.css_version')) !!}
    </head>
    <body class="main-content">
        <div id="page-container">
            @include('layouts.navbars.login_navbar')
            <div class="content">                          
                @yield('content')                       
            </div>  
            @include('layouts.login_footer')  
        </div>
        @include('partials.scripts')   
        @include('flash::message')         
        <script>
            flash_package();
        </script>
    </body>
</html>

