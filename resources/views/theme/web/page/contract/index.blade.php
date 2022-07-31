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
    <div class="slim-pageheader flex-column-reverse flex-lg-row-reverse align-items-start align-items-lg-center" style="margin-top: 8px">
        <div class="block-number-contracts mt-2 mt-lg-0" style="font-size: 14px; letter-spacing: 1px;">
            <span class="badge badge-secondary title-number-contract rounded-0">契約件数表示</span>
            <span class="badge badge-light detail-number-contract rounded-0">全件 : <span class="number-contract">80件</span><span class="summary-plans"></span></span>
        </div>
        <h6 class="slim-pagetitle">{{$page_title}}</h6>
    </div><!-- slim-pageheader -->
@endsection

@section('page_content')
    <div class="section-wrapper">
        @include('theme.web.page.contract.section.section')
    </div><!-- section-wrapper -->
@endsection

@section('js')
    @if(env('APP_DEBUG'))
        <script src="{{asset('assets/themes/app/page/admin/js/contract.js')}}"></script>
    @else
        <script src="{{asset('assets/themes/app/page/admin/js/min/contract.min.js')}}"></script>
    @endif
@endsection
