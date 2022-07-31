<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{asset('/assets/images/vietnhat.svg')}}">
    <title>ユーザーログイン</title>

    @include('theme.layout.main_css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/themes/app/page/admin/css/min/login.min.css')}}" />
</head>
<body>
    <div class="signin-wrapper">
        <div class="signin-box">
            <h2 class="slim-logo">ユーザーログイン</h2>
            <form id="formLogin" method="POST" class="mg-t-40">
                <div class="form-layout form-layout-5">
                    <div class="row">
                        <label class="col-sm-12 form-control-label">ログインID</label>
                        <div class="col-sm-12 mg-t-10 mg-sm-t-0">
                            <input name="mail" class="form-control rounded-7" 
                                maxlength="40" data-parsley-maxlength="40"
                                data-parsley-maxlength-message="ログインIDが40文字を超えています"
                                required data-parsley-required-message="必須項目です">
                        </div>
                    </div>
                    <div class="row mg-t-35">
                        <label class="col-sm-12 form-control-label">パスワード</label>
                        <div class="col-sm-12 mg-t-10 mg-sm-t-0">
                            <input type="password" name="password" id="pass" class="form-control rounded-7" 
                                maxlength="20" data-parsley-maxlength="20"
                                data-parsley-maxlength-message="パスワードが20文字を超えています"
                                required data-parsley-required-message="必須項目です">
                        </div>
                    </div>
                </div><!-- form-group -->
                <div class="row mg-t-40 text-center">
                    <div class="col-sm-12 mg-l-auto">
                        <div class="form-layout-footer">
                            <button type="submit" id="btnLogin" class="btn btn-primary bd-0 btn-login">ログイン</button>
                        </div><!-- form-layout-footer -->
                    </div><!-- col-8 -->
                </div>
            </form>
        </div><!-- signin-box -->
    </div>
</body>
@include('theme.layout.main_js')
@if(env('APP_DEBUG'))
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{asset('assets/themes/app/page/admin/js/login.js')}}"></script>
@else
    <script src="{{asset('assets/themes/app/page/admin/js/min/login.min.js')}}"></script>
@endif
</html>
