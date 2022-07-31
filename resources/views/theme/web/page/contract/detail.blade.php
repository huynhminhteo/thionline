@extends('theme.layout.main')

@section('page_title')
    {{$page_title}}
@endsection

@section('css')
    @if(env('APP_DEBUG'))
        <link rel="stylesheet" type="text/css" href="{{asset('assets/themes/app/page/admin/css/contract.css')}}" />
    @else
        <link rel="stylesheet" type="text/css" href="{{asset('assets/themes/app/page/admin/css/min/contract.min.css')}}" />
    @endif
@endsection

@section('page_header')
    <div class="slim-pageheader flex-column flex-sm-row align-items-start align-items-lg-center">
        <h6 class="slim-pagetitle">{{$page_title}}</h6>
        <button type="button" class="btn pd-x-10 btn-cus-hm _1 mt-2 mt-sm-0" id="btnUse" data-type="@if($status != 0) un_use @else use @endif">@if($status != 0) 利用停止 @else 利用再開 @endif</button>
    </div><!-- slim-pageheader -->
@endsection

@section('page_content')
    <div class="section-wrapper">
        @include('theme.web.page.contract.section.detail')
    </div><!-- section-wrapper -->
@endsection

@section('js')
    @if(env('APP_DEBUG'))
        <script src="{{asset('assets/themes/app/page/admin/js/contract_detail.js')}}"></script>
    @else
        <script src="{{asset('assets/themes/app/page/admin/js/min/contract_detail.min.js')}}"></script>
    @endif
@endsection
