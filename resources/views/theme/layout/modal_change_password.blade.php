<div data-keyboard="false" class="modal fade modal_change_password" id="modal_change_password" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg w-50  md-home-w" role="document">
        <div class="modal-content">
            <p class="mg-t-60 text-center txt-hm-header-md">パスワード変更</p>
            <div class="modal-body">
                <form class="form-layout pd-50" style="padding-top: 30px !important" id="ChangePassForm">
                    <div class="row">
                        <label class="col-sm-4 form-control-label">古いパスワード <br><span
                                    class="tx-danger">必須</span></label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input type="password" class="form-control rounded-7" name="oldpass" id="oldpass" value=""
                                   maxlength="190" required
                                   data-parsley-required-message="必須項目です">
                        </div>
                    </div>
                    <div class="row mg-t-20">
                        <label class="col-sm-4 form-control-label">新しいパスワード <br><span
                                    class="tx-danger">必須</span></label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input type="password" class="form-control rounded-7" name="newpass" id="newpass" value=""
                                   maxlength="190" required
                                   data-parsley-required-message="必須項目です">
                        </div>
                    </div>
                    <div class="row mg-t-20">
                        <label class="col-sm-4 form-control-label">新しいパスワード <br>(確認)<br><span
                                    class="tx-danger change">必須</span></label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input type="password" class="form-control rounded-7" id="newpass_confirmation" value=""
                                   maxlength="190" required
                                   data-parsley-equalto="#newpass"
                                   data-parsley-equalto-message="パスワードと確認用パスワードが一致しません"
                                   data-parsley-required-message="必須項目です">
                        </div>
                    </div>
                    <div class="row mg-t-50">
                        <button class="btn btn-cus-hm _2 btn-submit mg-xx-auto" id="btnSubmit">変更</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    