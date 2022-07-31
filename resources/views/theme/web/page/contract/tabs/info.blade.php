<hr style="margin-left: -10px;">
<div class="tab-content" style="padding-top: 5px">
<div class="tab-pane fade active show" id="info_tab">
    <form class="form-layout" id="form_info">
        <input type="hidden" name="id" id="id" value="{{$companyId}}">
        <div class="row mg-md-b-0 mg-b-30 mx-0 mx-md-3">
            <label class="col-md-3 col-12 form-control-label tx-inverse">事業所ID<br><span
                        class="tx-note">(英数字大文字小文字6桁)</span></label>
            <div class="col-md-6 col-12 mg-sm-t-0">
                <div class="input-group">
                    <input class="form-control rounded-7" name="corp_id" id="corp_id" value="" disabled>
                </div>
            </div>
        </div>

        <hr style="margin-left: -10px;">

        <div class="row mg-sm-t-0 mg-md-t-15 mg-b-15 mx-0 mx-md-3">
            <label class="col-md-3 col-12 form-control-label tx-inverse">会社名・法人名</label>
            <div class="col-md-6 col-12 mg-sm-t-0">
                <div class="input-group">
                    <input class="form-control rounded-7" name="company_name" id="company_name" value="" disabled>
                </div>
            </div>
        </div>

        <div class="row mg-sm-t-0 mg-b-15 mx-0 mx-md-3">
            <label class="col-md-3 col-12 form-control-label tx-inverse">会社名・法人名（カナ）</label>
            <div class="col-md-6 col-12 mg-sm-t-0">
                <div class="input-group">
                    <input class="form-control rounded-7" name="company_name_kana" id="company_name_kana" value="" disabled>
                </div>
            </div>
        </div>

        <hr style="margin-left: -10px;">

        <div class="row mg-sm-t-0 mg-md-t-30 mg-b-30 mx-0 mx-md-3">
            <label class="col-md-3 col-12 form-control-label tx-inverse">事業所名</label>
            <div class="col-md-6 col-12 mg-sm-t-0">
                <div class="input-group">
                    <input class="form-control rounded-7" name="office_name" id="office_name" value="" disabled>
                </div>
            </div>
        </div>

        <div class="row mg-sm-t-0 mg-md-t-30 mg-b-30 mx-0 mx-md-3">
            <label class="col-md-3 col-12 form-control-label tx-inverse">事業所名（カナ）</label>
            <div class="col-md-6 col-12 mg-sm-t-0">
                <div class="input-group">
                    <input class="form-control rounded-7" name="office_name_kana" id="office_name_kana" value="" disabled>
                </div>
            </div>
        </div>

        <div class="row mg-sm-t-0 mg-md-t-30 mg-b-30 mx-0 mx-md-3">
            <label class="col-md-3 col-12 form-control-label tx-inverse">郵便番号</label>
            <div class="col-md-3 col-12 mg-sm-t-0">
                <div class="input-group">
                    <input class="form-control rounded-7" name="postal_code" id="postal_code" value="" disabled>
                    <span class="input-group-text rounded-7" id="basic-addon2"><i class="fas fa-search" style="font-size: 20px"></i></span>
                </div>
            </div>
        </div>

        <div class="row mg-sm-t-0 mg-md-t-30 mg-b-30 mx-0 mx-md-3">
            <label class="col-md-3 col-12 form-control-label tx-inverse">住所</label>
            <div class="col-md-6 col-12 mg-sm-t-0">
                <div class="input-group">
                    <input class="form-control rounded-7" name="address" id="address" value="" disabled>
                </div>
            </div>
        </div>

        <div class="row mg-sm-t-0 mg-md-t-30 mg-b-30 mx-0 mx-md-3">
            <label class="col-md-3 col-12 form-control-label tx-inverse">建物名</label>
            <div class="col-md-6 col-12 mg-sm-t-0">
                <div class="input-group">
                    <input class="form-control rounded-7" name="building" id="building" value="" disabled>
                </div>
            </div>
        </div>

        <div class="row mg-sm-t-0 mg-md-t-30 mg-b-30 mx-0 mx-md-3">
            <label class="col-md-3 col-12 form-control-label tx-inverse">電話番号</label>
            <div class="col-md-6 col-12 mg-sm-t-0">
                <div class="input-group">
                    <input class="form-control rounded-7" name="phone" id="phone" value="" disabled>
                </div>
            </div>
        </div>

        <div class="row mg-sm-t-0 mg-md-t-30 mg-b-30 mx-0 mx-md-3">
            <label class="col-md-3 col-12 form-control-label tx-inverse">FAX番号</label>
            <div class="col-md-6 col-12 mg-sm-t-0">
                <div class="input-group">
                    <input class="form-control rounded-7" name="fax" id="fax" value="" disabled>
                </div>
            </div>
        </div>

        <div class="row mg-sm-t-0 mg-md-t-30 mg-b-30 mx-0 mx-md-3">
            <label class="col-md-3 col-12 form-control-label tx-inverse">担当者名</label>
            <div class="col-md-6 col-12 mg-sm-t-0">
                <div class="input-group">
                    <input class="form-control rounded-7" name="charge" id="charge" value="" disabled>
                </div>
            </div>
        </div>

        <div class="row mg-sm-t-0 mg-md-t-30 mg-b-30 mx-0 mx-md-3">
            <label class="col-md-3 col-12 form-control-label tx-inverse">E-mail</label>
            <div class="col-md-6 col-12 mg-sm-t-0">
                <div class="input-group">
                    <input type="email" class="form-control rounded-7" name="email" id="email" value="" disabled>
                </div>
            </div>
        </div>
    </form>
</div>
