@extends('theme.layout.main')

@section('page_title')
    {{$page_title}}
@endsection

@section('css')
    @if(env('APP_DEBUG'))
        <link rel="stylesheet" type="text/css" href="{{asset('assets/themes/app/page/admin/css/contract.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('assets/themes/app/page/admin/css/noti.css')}}" />
    @else
        <link rel="stylesheet" type="text/css" href="{{asset('assets/themes/app/page/admin/css/min/contract.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('assets/themes/app/page/admin/css/min/noti.min.css')}}" />
    @endif
@endsection

@section('page_header')
    <div class="slim-pageheader" style="display: block">
        <h6 class="slim-pagetitle">{{$page_title}}</h6>
    </div><!-- slim-pageheader -->
@endsection

@section('page_content')
    <div class="section-wrapper">
        @include('theme.web.page.notificate.section.section')
    </div><!-- section-wrapper -->
@endsection

@section('js')
    @if(env('APP_DEBUG'))
        <script src="{{asset('assets/themes/app/page/admin/js/noti.js')}}"></script>
    @else
        <script src="{{asset('assets/themes/app/page/admin/js/min/noti.min.js')}}"></script>
    @endif
@endsection
