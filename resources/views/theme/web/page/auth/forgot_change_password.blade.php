<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{asset('/assets/images/favico.png')}}">
    <title>パスワードリセット</title>
    @include('theme.layout.main_css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/themes/app/page/admin/css/min/forgot.min.css')}}" />
</head>
<body>
    <div class="signin-wrapper">
        <div class="signin-box forgotpass">
            <h2 class="slim-logo title-fg">パスワードリセット</h2>

            <form id="changePasswordForm">
                <input type="hidden" name="mail" class="form-control rounded-7" value="{{$user->mail}}"/>
                <input type="hidden" name="id" class="form-control rounded-7"  value="{{$user->id}}"/>
                <div class="form-layout form-layout-5 mg-t-90">
                    <div class="row">
                        <label class="col-sm-4 form-control-label">新しいパスワード </label>
                        <div class="col-sm-7 mg-t-10 mg-sm-t-0">
                            <input type="password" id="newPassword" name="password" class="form-control rounded-7" 
                                maxlength="20" data-parsley-maxlength="20"
                                data-parsley-maxlength-message="新しいパスワードが20文字を超えています"
                                required data-parsley-required-message="必須項目です">
                        </div>
                    </div>
                    <div class="row mg-t-35">
                        <label class="col-sm-4 form-control-label">新しいパスワード <span class="sup-tt">(確認)</span></label>
                        <div class="col-sm-7 mg-t-10 mg-sm-t-0">
                            <input type="password" class="form-control rounded-7" required
                                maxlength="20" data-parsley-maxlength="20"
                                data-parsley-maxlength-message="新しいパスワードが20文字を超えています"
                                data-parsley-required-message="必須項目です"
                                data-parsley-equalto="#newPassword"
                                data-parsley-equalto-message='パスワードと確認用パスワードが一致しません'
                             >
                        </div>
                    </div>
                </div><!-- form-group -->
                <div class="row mg-t-90">
                    <div class="form-layout-footer" style="margin: auto">
                        <a class="btn btn-primary bd-0 mg-r-10 btn-cus-hm mg-l-auto" href="{{route('admin.page.login')}}">戻る</a>
                        <button type="submit" id="btnChangePassword" class="btn btn-primary bd-0 btn-cus-hm _2 mg-r-auto">送信</button>
                    </div><!-- form-layout-footer -->
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
