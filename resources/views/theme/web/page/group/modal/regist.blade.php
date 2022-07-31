<div data-keyboard="false" class="modal fade modal-regist" id="modal_regist" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg w-50 md-home-w" role="document">
        <div class="modal-content">
            <p class="mg-t-60 text-center txt-hm-header-md">ユーザー新規登録</p>
            <div class="modal-body">
                <form class="form-layout pd-x-100 pd-b-30 pd-t-60" id="form_regist">
                    <div class="row">
                        <label class="col-12 col-md-3 form-control-label tx-inverse">名前<br><span
                                    class="tx-danger">必須</span></label>
                        <div class="col-12 col-md-9 mg-sm-t-0">
                            <div class="input-group">
                            <input class="form-control rounded-7" name="name" id="regist_name" value=""
                                        placeholder="氏名を入力してください"
                                        data-parsley-validation-threshold="-1" data-parsley-validation-threshold="-1" data-parsley-trigger="keyup"
                                        maxlength="190" required
                                        data-parsley-required-message="必須項目です"
                                        data-parsley-errors-container="#slErrorContainerModalName">
                            </div>
                            <div id="slErrorContainerModalName"></div>
                        </div>
                    </div>

                    <div class="row mg-sm-t-0 mg-md-t-35">
                        <label class="col-12 col-md-3 form-control-label tx-inverse">メールアドレス<br><span
                                    class="tx-danger">必須</span></label>
                        <div class="col-12 col-md-9 mg-sm-t-0">
                            <div class="input-group">
                            <input type="email" class="form-control rounded-7" name="mail" id="regist_mail" value=""
                                    placeholder="メールアドレスを入力してください"
                                    data-parsley-validation-threshold="-1" data-parsley-validation-threshold="-1" data-parsley-trigger="keyup"
                                    maxlength="40" data-parsley-maxlength="40" required
                                    data-parsley-maxlength-message="メールアドレスが40文字を超えています"
                                    data-parsley-required-message="必須項目です"
                                    data-parsley-validate-email-rfc="true"
                                    aria-describedby="button_check_email"
                                    data-parsley-type-message="メールアドレスの書式に誤りがあります"
                                    data-parsley-errors-container="#slErrorContainerModalEmail">
                            </div>
                            <div id="slErrorContainerModalEmail"></div>
                        </div>
                    </div>
                    
                    <div class="row mg-sm-t-0 mg-md-t-35">
                        <label class="col-12 col-md-3 form-control-label tx-inverse">権限<br><span
                                    class="tx-danger">必須</span></label>
                        <div class="col-12 col-md-5 mg-sm-t-0">
                            <div id="slWrapperRole" class="parsley-select">
                                <select class="form-control select2 role" style="width: 100%" id="regist_role" name="role"
                                        data-placeholder="選択してください"
                                        data-parsley-class-handler="#slWrapperRole"
                                        data-parsley-errors-container="#slErrorContainerRole" required
                                        data-parsley-required-message="必須項目です">
                                    <option label="Select Role"></option>
                                    <option value="1">管理者</option>
                                    <option value="2">一般</option>
                                </select>
                                <div id="slErrorContainerRole"></div>
                            </div>
                        </div>
                    </div>                    

                    <div class="row" style="margin-top: 140px">
                        <div class="col-12 text-center">
                            <button class="btn btn-cus-hm _2 btn-submit" style="margin: auto">登録</button>
                        </div>
                    </div>
                </form>
            </div>
        
      
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>