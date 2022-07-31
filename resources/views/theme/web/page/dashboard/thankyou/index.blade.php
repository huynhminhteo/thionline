@extends('theme.layout.main')

@section('page_title')
    {{$page_title}}
@endsection

@section('page_content')
    <div style="text-align: center">
        <img src="{{asset('assets/images/goodjob.gif')}}" height="250px" style="margin-top: calc(100% / 3)">
    </div>
@endsection
