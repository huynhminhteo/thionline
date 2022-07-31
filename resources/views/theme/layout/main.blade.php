<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{asset('/assets/images/vietnhat.svg')}}">
    <title>@yield('page_title')</title>
    @include('theme.layout.main_css_exam')
</head>
<body class="slim-sticky-sidebar wait-containter">
@include('theme.layout.header_exam')
<div class="slim-body">
    <div class="slim-mainpanel">
        <div class="container d-block" style="overflow: hidden; overflow-y: scroll;">
            @yield('page_header')
            @yield('page_content')
        </div><!-- container -->
    </div><!-- slim-mainpanel -->
</div>

@include('theme.layout.modal_change_password')
@include('theme.layout.main_js')

</body>
</html>
