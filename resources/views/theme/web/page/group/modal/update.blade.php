<div data-keyboard="false" class="modal fade modal-update" id="modal_update" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg w-50 md-home-w" role="document">
        <div class="modal-content">
            <p class="mg-t-60 text-center txt-hm-header-md">ユーザー情報変更</p>
            <div class="modal-body">
                <form class="form-layout pd-x-100 pd-b-30 pd-t-60" id="form_update">
                    <input type="hidden" name="id" id="id_user" value="">
                    <div class="row">
                        <label class="col-12 col-md-3 form-control-label tx-inverse">名前<br><span
                                    class="tx-danger">必須</span></label>
                        <div class="col-12 col-md-9 mg-sm-t-0">
                            <div class="input-group">
                            <input class="form-control rounded-7" name="name" id="update_name" value=""
                                        placeholder="氏名を入力してください"
                                        data-parsley-validation-threshold="-1" data-parsley-validation-threshold="-1" data-parsley-trigger="keyup"
                                        maxlength="190" required
                                        data-parsley-required-message="必須項目です"
                                        data-parsley-errors-container="#slErrorContainerModalNameUpdate">
                            </div>
                            <div id="slErrorContainerModalNameUpdate"></div>
                        </div>
                    </div>

                    <div class="row mg-sm-t-0 mg-md-t-35">
                        <label class="col-12 col-md-3 form-control-label tx-inverse">メールアドレス</label>
                        <div class="col-12 col-md-9 mg-sm-t-0" id="text_mail"></div>
                    </div>
                    
                    <div class="row mg-sm-t-0 mg-md-t-35">
                        <label class="col-12 col-md-3 form-control-label tx-inverse">権限<br><span
                                    class="tx-danger">必須</span></label>
                        <div class="col-12 col-md-5 mg-sm-t-0 font-weight-500" id="text_role"></div>
                    </div>                    

                    <div class="row" style="margin-top: 140px">
                        <div class="col-12 text-center">
                            <button class="btn btn-light rounded-7 col-12 col-md-3 btn-submit btn-change" id="btnChange"> 変更 </button>
                            <button class="btn btn-light rounded-7 col-12 col-md-3 ml-0 ml-md-3 mg-t-10 mg-md-t-0 btn-delete" id="btnDelete"> 削除 </button>
                        </div>
                    </div>
                </form>
            </div>
        
      
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>