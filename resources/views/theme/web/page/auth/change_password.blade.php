<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{asset('/assets/images/favico.png')}}">
    <title>パスワード変更</title>

    @include('theme.layout.main_css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/themes/app/page/admin/css/min/change_pass.min.css')}}" />
</head>
<body>
    <div class="signin-wrapper">
        <div class="signin-box">
            <h2 class="slim-logo title-fg">パスワード変更</h2>
            <form class="form-layout mg-t-90 form-layout-5" id="ChangePassForm" method="POST">
                <div class="row">
                    <label class="col-sm-4 form-control-label">古いパスワード </label>
                    <div class="col-sm-7 mg-t-10 mg-sm-t-0">
                        <input type="password" class="form-control rounded-7" name="oldpass" id="oldpass" value=""
                                maxlength="20" data-parsley-maxlength="20"
                                data-parsley-maxlength-message="古いパスワードが20文字を超えています"
                                required
                                data-parsley-required-message="必須項目です">
                    </div>
                </div>
                <div class="row mg-t-35">
                    <label class="col-sm-4 form-control-label">新しいパスワード </label>
                    <div class="col-sm-7 mg-t-10 mg-sm-t-0">
                        <input type="password" class="form-control rounded-7" name="newpass" id="newpass" value=""
                                maxlength="20" data-parsley-maxlength="20"
                                data-parsley-maxlength-message="新しいパスワードが20文字を超えています"
                                required
                                data-parsley-required-message="必須項目です">
                    </div>
                </div>
                <div class="row mg-t-35">
                    <label class="col-sm-4 form-control-label">新しいパスワード <br><span class="label-small">(確認)</span></label>
                    <div class="col-sm-7 mg-t-10 mg-sm-t-0">
                        <input type="password" class="form-control rounded-7" id="newpass_confirmation" value=""
                                maxlength="20" data-parsley-maxlength="20"
                                data-parsley-maxlength-message="新しいパスワードが20文字を超えています"
                                required
                                data-parsley-equalto="#newpass"
                                data-parsley-equalto-message="パスワードと確認用パスワードが一致しません"
                                data-parsley-required-message="必須項目です">
                    </div>
                </div>
                <div class="row mg-t-90">
                    <button class="btn btn-primary bd-0 mg-r-10 btn-cus-hm mg-l-auto" onclick="window.history.back()">戻る</button>
                    <button class="btn btn-primary bd-0 btn-cus-hm _1 mg-r-auto" id="btn_change_pw">変更</button>
                </div>
            </form>
        </div><!-- signin-box -->
    </div>
</body>
@include('theme.layout.main_js')
@if(env('APP_DEBUG'))
    <script src="{{asset('assets/themes/app/page/admin/js/login.js')}}"></script>
@else
    <script src="{{asset('assets/themes/app/page/admin/js/min/login.min.js')}}"></script>
@endif
</html>
