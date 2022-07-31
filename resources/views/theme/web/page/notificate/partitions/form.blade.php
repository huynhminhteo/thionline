<div class="list-group mg-t-25">
    <form id="form_add_noti">
        <div class="form-group">
            <div class="row mg-x-0">
                <div class="col-9">
                    <div class="row mg-x-0">
                        <div class="col-lg-10 col-md-9 col-6 block-input">
                            <label for="title_noti" id="label_noti">
                                タイトル
                            </label>
                            <input autocomplete="off" name="title" class="form-control rounded-radius-7" id="title_noti"
                                aria-label="タイトル" aria-describedby="basic-addon2"
                                maxlength="40" data-parsley-maxlength-message="タイトルが40文字を超えています"
                                required data-parsley-required-message="必須項目です"
                                data-parsley-errors-container="#slErrorTitle">
                        </div>
                        <div class="col-lg-2 col-md-3 col-6 block-btn-input">
                            <button class="btn btn-cus-hm _2" id="btnView" type="button">
                                送信
                            </button>
                        </div>
                        
                        <div id="slErrorTitle"></div>
                    </div>
                </div>
            </div>

            <div class="row mg-x-0">
                <div class="col-9">
                    <div class="row mg-x-0 mg-t-10">
                        <div class="col-md-12 col-12">
                            <textarea name="content" class="form-control" id="content_noti"
                                rows="4" placeholder="本文" maxlength="300" data-parsley-maxlength-message="本文が300文字を超えています"
                                required data-parsley-required-message="必須項目です"
                                data-parsley-errors-container="#slErrorContent"></textarea>
                            <div id="slErrorContent"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
