
@extends('theme.layout.main_app')
@section('page_title')
{{$page_title}}
@endsection

@section('page_content')
    <div class="page-error-wrapper">
            <div>
                <h5 class="tx-sm-24 tx-normal">Service Temporarily Unavailable.</h5>
                <p class="mg-b-50">The server is unable to service your request due to maintenance downtime or capacity problems.</p>
            </div>
    </div><!-- page-error-wrapper -->
@endsection
