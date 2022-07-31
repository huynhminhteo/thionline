<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{asset('/assets/images/favico.png')}}">
    <link rel="stylesheet" href="{{asset('/vendor/translation/css/main_exam.css')}}">
    <title>{{ __('page.title.setting_language') }}</title>
    @include('theme.layout.main_css')
</head>
<body class="slim-sticky-sidebar">
@include('theme.layout.header')
<div class="slim-body">
    @include('theme.layout.navbar')
    <div class="slim-mainpanel">
        <div class="container" id="app">
            @yield('page_header')
            @include('translation::notifications')
            @yield('body')
        </div><!-- container -->
    </div><!-- slim-mainpanel -->
</div>
@include('theme.layout.main_js')
<script src="{{asset('/vendor/translation/js/app.js')}}"></script>
</body>
</html>
