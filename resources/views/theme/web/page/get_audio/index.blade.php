@extends('theme.layout.main')

@section('page_title')
    {{$page_title}}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/themes/app/page/admin/css/get_audio.css')}}" />
@endsection

@section('page_header')
    <div class="slim-pageheader d-block">
        <h6 class="slim-pagetitle">{{$page_title}}</h6>
    </div>
@endsection

@section('page_content')
    <div class="section-wrapper-exam" style="padding: 20px !important">
        @include('theme.web.page.get_audio.section.section')
    </div>
@endsection

@section('js')
    <script src="{{asset('assets/themes/app/page/admin/js/get_audio.js')}}"></script>
@endsection
