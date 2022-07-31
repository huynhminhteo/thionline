<div class="list-group bg-gray-100" id="filter_bar">
    <div class="list-group-item d-block pd-y-20 bg-gray-100">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12 mg-b-10" id="filter_search">
                <div class="input-group">
                    <input autocomplete="off" class="form-control" id="filter_text"
                           placeholder="{{__('user.filter.filter')}}" aria-label="{{__('user.filter.filter')}}"
                           aria-describedby="basic-addon2">
                    <span class="input-group-btn">
                            <button class="btn bd bd-l-0 bg-white tx-gray-600" id="filter_text_btn" type="button"><i
                                        class="fa fa-search"></i></button>
                        </span>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-12 col-sm-12 mg-b-10">
                <select class="form-control select2" style="width: 100%" id="filter_role" name="filter_role"
                        data-placeholder="{{__('user.filter.select_role')}}">
                    <option label="Select role"></option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-12 col-sm-12 mg-b-10">
                <select class="form-control select2" style="width: 100%" id="filter_status" name="filter_status"
                        data-placeholder="{{__('user.filter.select_status')}}">
                    <option label="Select status"></option>
                    <option value="1">{{__('user.filter.active')}}</option>
                    <option value="0">{{__('user.filter.deactive')}}</option>
                </select>
            </div>
            
            <div class="col-lg-3 col-md-12 col-sm-12 mg-b-10">
                <button class="btn btn-primary btn-block btn-add-user" id="btn-addnew-user" data-toggle="modal"
                        data-target="#modal_user"><i class="icon ion-plus-round"></i>{{__('user.index.new_user')}}
                </button>
            </div>
        </div>

        <div class="row selectLocation">
            <div class="col-lg-3 col-md-12 col-sm-12 mg-b-10">
                <select class="form-control select2 filter_region" style="width: 100%" id="filter_region"
                        name="filter_region" data-placeholder="{{__('user.filter.select_region')}}"
                        data-parsley-class-handler="#slWrapperRegion"
                        data-parsley-errors-container="#slErrorContainerRegion">
                    <option label="Select Region"></option>
                    <option value="region1">Region 1</option>
                    <option value="region2">Region 2</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-12 col-sm-12 mg-b-10">
                <select class="form-control select2 filter_area" style="width: 100%" id="filter_area"
                        name="filter_area" data-placeholder="{{__('user.filter.select_area')}}"
                        data-parsley-class-handler="#slWrapperArea"
                        data-parsley-errors-container="#slErrorContainerArea">
                    <option label="Select area"></option>
                    <option label="area1">Area 1</option>
                    <option label="area2">Area 2</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-12 col-sm-12 mg-b-10">
                <select class="form-control select2 filter_province" style="width: 100%" id="filter_province"
                        name="filter_province" data-placeholder="{{__('user.filter.select_province')}}"
                        data-parsley-class-handler="#slWrapperProvince"
                        data-parsley-errors-container="#slErrorContainerProvince">
                    <option label="Select province"></option>
                    <option label="province1">Province 1</option>
                    <option label="province2">Province 2</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-12 col-sm-12 mg-b-10">
                <select class="form-control select2 filter_district" style="width: 100%" id="filter_district"
                        name="filter_district" data-placeholder="{{__('user.filter.select_district')}}"
                        data-parsley-class-handler="#slWrapperDistrict"
                        data-parsley-errors-container="#slErrorContainerDistrict">
                    <option label="Select district"></option>
                    <option label="district1">District 1</option>
                    <option label="district2">District 2</option>
                </select>
            </div>

        </div>
    </div>
