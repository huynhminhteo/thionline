<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{asset('/assets/images/favico.png')}}">
    <title>パスワードを忘れた方</title>
    @include('theme.layout.main_css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/themes/app/page/admin/css/min/forgot.min.css')}}" />
</head>
<body>
    <div class="signin-wrapper">
        <div class="signin-box">
            <h2 class="slim-logo title-fg">パスワードを忘れた方</h2>
            <p class="hint-t-p">ログインID（ご登録済みのメールアドレス）を入力の上、[送信]をクリックしてください。</p>
            <p class="hint-t-p">メールアドレス宛に仮パスワードが送信されます。</p>
            <form id="forgotForm">
                <div class="form-layout form-layout-5 mg-t-65">
                    <div class="row">
                        <label class="col-sm-3 form-control-label label-no-margin">ログインID<br><span class="sup-tt">(メールアドレス)</span></label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input type="email" name="email" class="form-control rounded-7" 
                                maxlength="40" data-parsley-maxlength="40"
                                data-parsley-maxlength-message="ログインIDが40文字を超えています"
                                data-parsley-type-message="メールアドレスの書式に誤りがあります"
                                required data-parsley-required-message="必須項目です">
                        </div>
                    </div>
                </div><!-- form-group -->
                <div class="row mg-t-65">
                    <div class="form-layout-footer mg-x-auto">
                        <a href="{{route('admin.page.login')}}" class="btn btn-primary bd-0 mg-r-10 btn-cus-hm">戻る</a>
                        <button type="submit" id="btnForgot" class="btn btn-primary bd-0 btn-cus-hm _1">送信</button>
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
