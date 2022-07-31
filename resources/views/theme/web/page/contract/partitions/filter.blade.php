<div class="list-group mg-t-10" id="filter_bar_contract">
    <div class="row mg-x-0">
        <div class="col-lg-7 col-12" style="padding-right: 0">
            <div class="form-group">
                <label for="filter_text">契約プラン</label>
                <div class="row filter-plans">
                    
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-12">
            <div class="form-group">
                <label for="filter_text">フリーワード</label>
                <div class="row">
                    <div class="col-9">
                        <input autocomplete="off" class="form-control rounded-radius-7" id="filter_text"
                            aria-label="フリーワード" aria-describedby="basic-addon2">
                    </div>
                    <div class="col-3">
                        <button class="btn btn-light rounded-7 btn-cus-hm btn-search font-bold" id="filter_text_btn" type="button">
                            検索
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mg-x-0 mg-t-5">
        <div class="col-lg-7 col-12">
            <div class="row mg-x-0">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="filter_text">入金状況</label>
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-light rounded-7 btn-cus-hm btn-search-payment font-bold" data-search="pay" type="button">
                                    入金済
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-light rounded-7 btn-cus-hm btn-search-payment font-bold" data-search="nopay" type="button">
                                    未入金
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="filter_text">契約状況</label>
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-light rounded-7 btn-cus-hm btn-search-status active font-bold" data-search="under" type="button">
                                    契約中
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-light rounded-7 btn-cus-hm btn-search-status font-bold" data-search="cancel" type="button">
                                    解約
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 col-12">
            <div class="form-group">
                <label>&nbsp;</label>
                <div class="row">
                    <div class="col-9"></div>
                    <div class="col-3">
                        <button class="btn btn-light rounded-7 btn-cus-hm btn-search font-bold" id="btn_search_all" type="button">
                            クリア
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
