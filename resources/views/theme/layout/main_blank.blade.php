<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{asset('/assets/images/favico.png')}}">
    <title>@yield('page_title')</title>
    @include('theme.layout.main_css')
</head>
<body>
<div class="slim-mainpanel">
    <div class="container">
        @yield('page_content')
    </div><!-- container -->
</div><!-- slim-mainpanel -->
@include('theme.layout.main_js')
</body>
</html>
