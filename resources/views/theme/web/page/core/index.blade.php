@extends('theme.layout.main')

@section('page_title')
    {{$page_title}}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/themes/app/page/admin/css/contract.css')}}" />
@endsection

@section('page_header')
    <div class="slim-pageheader flex-column-reverse flex-lg-row-reverse align-items-start align-items-lg-center">
        <button type="button" class="btn btn-cus-hm _2" id="btnRegist">新 規 登 録</button>
        <h6 class="slim-pagetitle">{{$page_title}}</h6>
    </div>
@endsection

@section('page_content')
    <div class="section-wrapper">
        @include('theme.web.page.core.section.section')
    </div>
@endsection

@section('js')
    <script src="{{asset('assets/themes/app/page/admin/js/core.js')}}"></script>
    <script src="{{asset('assets/themes/app/page/admin/js/user.js')}}"></script>
@endsection
