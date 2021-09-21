<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('images') }}/favicon.ico">
        <title>{{ $report_title }}</title>
        {!! Html::style('packages/bootstrap-4.2.1/css/bootstrap.css?v='. config('app.css_version')) !!}
        {!! Html::style('css/packages/carers.pdf.css') !!}
        {!! Html::style('css/packages/carers.datatables.css?v='. config('app.css_version')) !!}
    </head>
    <body style="font-family: 'Helvetica', sans-serif;">
        <div class="a4 {{$orientation ?? 'landscape'}}"> <!--  style="border-radius: 10px; border: 1px solid red;" -->
            @yield('content')
        </div>
    </body>
</html>
