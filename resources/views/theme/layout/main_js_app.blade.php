<script src="https://code.jquery.com/jquery-3.1.0.js"></script>
<script src="https://code.jquery.com/jquery-migrate-3.1.0.js"></script>
<script src="{{asset('assets/themes/app/page/admin/js/lang.js')}}"></script>
<script>
    var base_url = '{{ url('/') }}';
    var base_admin = '{{ route('admin.page.index') }}';
    var base_webview = '{{ route('webview.page.index') }}';
    var base_ajax = '{{ route('admin.page.ajax') }}';
    var debug = {{ (env('APP_DEBUG')) ? 1 : 0}};
</script>

<script src="{{asset('assets/themes/app/lib/popper.js/js/popper.js')}}"></script>
<script src="{{asset('assets/themes/app/lib/bootstrap/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/themes/app/lib/jquery.cookie/js/jquery.cookie.js')}}"></script>
<script src="{{asset('assets/themes/app/lib/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/themes/app/lib/parsleyjs/js/parsley.js')}}"></script>
<script src="{{asset('assets/themes/app/lib/moment/min/moment.min.js')}}"></script>
<script src="{{asset('assets/themes/app/lib/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('assets/themes/app/lib/lightbox2/js/lightbox.js')}}"></script>
<script src="{{asset('assets/themes/app/lib/fileuploader/js/jquery.modal.min.js')}}"></script>
<script src="{{asset('assets/themes/app/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>
<script src="{{asset('assets/themes/app/lib/waitme/js/waitMe.min.js')}}"></script>
<script src="{{asset('assets/themes/app/lib/iCheck/icheck.min.js')}}"></script>
<script src="{{asset('assets/themes/app/lib/simple-timer/simple-timer.js')}}"></script>
<script type="text/javascript"
        src="{{asset('assets/themes/app/lib/polyfill/promise.min.js')}}"></script>
<script type="text/javascript"
        src="{{asset('assets/themes/app/lib/sweet2/sweet2.js')}}"></script>
<script type="text/javascript"
        src="{{asset('assets/themes/app/js/jquery.mobile-events.min.js')}}"></script>
<script type="text/javascript"
        src="{{asset('assets/themes/app/js/slim.js')}}"></script>
<script type="text/javascript"
        src="{{asset('assets/themes/app/js/ResizeSensor.js')}}"></script>
@yield('js')
<script>$(window).on('load', function () {
        if ($('.se-pre-con').length > 0) {
            $(".se-pre-con").fadeOut("slow");
        }
});</script>