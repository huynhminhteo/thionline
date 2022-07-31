<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-token-api" content="Bearer {{session('tokenapi')}}">
    <link rel="icon" type="image/png" href="{{asset('/assets/images/favico.png')}}">
    <title>@yield('page_title')</title>
    @include('theme.layout.main_css_app')
</head>
<body class="slim-full-width">
<div class="se-pre-con">
    <div class="sk-spinner sk-spinner-pulse bg-gray-800"></div>
</div>
<div class="slim-mainpanel">
    <div class="container">
        @yield('page_content')
    </div><!-- container -->
</div><!-- slim-mainpanel -->
@yield('btn_back')
@include('theme.layout.main_js_app')
<script src="{{asset('/assets/themes/app/lib/modernizr/modernizr.js')}}"></script>
</body>
</html>