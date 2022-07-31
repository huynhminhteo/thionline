@extends('theme.layout.main')

@section('page_title')
    {{$page_title}}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/themes/app/page/admin/css/waiting.css')}}" />
@endsection

@section('page_content')
    <div class="section-wrapper">
        @include('theme.web.page.dashboard.waiting.section.section')
    </div>
@endsection

@section('js')
    <script>
        var time_start = moment('{{$time_start}}');
    </script>
    <script src="{{asset('assets/themes/app/page/admin/js/waiting.js')}}"></script>
@endsection
