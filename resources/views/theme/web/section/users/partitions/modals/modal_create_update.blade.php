<!-- Modal create or update users -->
<div class="modal fade modal_user" id="modal_user" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg max-w-90 w-90" role="document">
        <div class="modal-content">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i id="ttlModalUser"></i>{{__('user.modal_user.title')}}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
                <form class="form-layout" id="UserForm">
                    <input type="hidden" id="action" name="action" value="">
                    <input type="hidden" id="id" name="id" value="">

                    <div class="card mg-t-15">
                        <p class="card-title">{{__('user.modal_user.card.information')}}<p>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-12 col-md-2 col-12  form-control-label">{{__('user.datatable.phone')}}<span
                                    class="tx-danger">*</span></label>
                                <div class="col-sm-12 col-md-4 col-12 mg-sm-t-0">
                                    <input class="form-control" name="phone" id="phone" value="" placeholder="{{__('user.form.placeholder.phone')}}"
                                        data-parsley-validation-threshold="-1" data-parsley-validation-threshold="-1" data-parsley-trigger="keyup"
                                        data-parsley-pattern="^(09[0|1|2|3|4|6|7|8|9]|07[0|9|7|6|8]|08[3|4|5|1|2]|03[2|3|4|5|6|7|8|9]|05[6|8|9])+([0-9]{7,8})$"
                                        data-parsley-pattern-message="Phone number is invalid"
                                        maxlength="190" required
                                        data-parsley-required-message="{{__('user.form.error.phone')}}">
                                </div>

                                <label class="col-sm-12 col-md-2 col-12  form-control-label">{{__('user.datatable.email')}}<span
                                    class="tx-danger">*</span></label>
                                <div class="col-sm-12 col-md-4 col-12 mg-sm-t-0">
                                    <input type="email" class="form-control" name="email" id="email" value=""
                                        placeholder="{{__('user.form.placeholder.email')}}"
                                        data-parsley-validation-threshold="-1" data-parsley-validation-threshold="-1" data-parsley-trigger="keyup"
                                        maxlength="190" required
                                        data-parsley-required-message="{{__('user.form.error.email')}}">
                                </div>
                            </div>

                            <div class="row mg-t-30">
                                <label class="col-sm-12 col-md-2 col-12  form-control-label">{{__('user.datatable.password')}}
                                    <span class="tx-danger password-required">*</span></label>
                                <div class="col-sm-12 col-md-4 col-12 mg-sm-t-0">
                                    <input type="password" class="form-control" name="password" id="password" value=""
                                        placeholder="{{__('user.form.placeholder.password')}}"
                                        required data-parsley-required-message="{{__('user.form.error.password')}}" maxlength="190">
                                </div>

                                <label class="col-sm-12 col-md-2 col-12  form-control-label">{{__('user.datatable.password_confirm')}}
                                    <span class="tx-danger password-required">*</span></label>
                                <div class="col-sm-12 col-md-4 col-12 mg-sm-t-0">
                                    <input type="password" class="form-control" name="password_confirm" id="password_confirm" value=""
                                        data-parsley-equalto="#password" data-parsley-equalto-message="{{__('user.form.error.password_check')}}"
                                        placeholder="{{__('user.form.placeholder.password_confirm')}}"
                                        required data-parsley-required-message="{{__('user.form.error.password_confirm')}}" maxlength="190">
                                </div>
                            </div>

                            <div class="row mg-t-30">
                                <label class="col-sm-12 col-md-2 col-12  form-control-label">{{__('user.datatable.fullname')}}
                                    <span class="tx-danger">*</span></label>
                                <div class="col-sm-12 col-md-4 col-12 mg-sm-t-0">
                                    <input class="form-control" name="fullname" id="fullname" value=""
                                        placeholder="{{__('user.form.placeholder.full_name')}}"
                                        maxlength="190" required
                                        data-parsley-required-message="{{__('user.form.error.fullname')}}">
                                </div>

                                <label class="col-sm-12 col-md-2 col-12  form-control-label">{{__('user.datatable.employeeID')}}
                                    <span class="tx-danger">*</span></label>
                                <div class="col-sm-12 col-md-4 col-12 mg-sm-t-0">
                                    <input class="form-control" name="employeeId" id="employeeId" value=""
                                        placeholder="{{__('user.form.placeholder.employee_id')}}"
                                        maxlength="190" required
                                        data-parsley-required-message="{{__('user.form.error.employeeID')}}">
                                </div>
                            </div>


                            <div class="row mg-t-30">
                                <label class="col-sm-12 col-md-2 col-12  form-control-label">{{__('user.datatable.code')}}<span
                                            class="tx-danger">*</span></label>
                                <div class="col-sm-12 col-md-4 col-12 mg-sm-t-0">
                                    <input class="form-control" name="code" id="code" value=""
                                        placeholder="{{__('user.form.placeholder.code')}}"
                                        maxlength="190" required
                                        data-parsley-required-message="{{__('user.form.error.code')}}">
                                </div>

                                <label class="col-sm-12 col-md-2 col-12  form-control-label">{{__('user.datatable.role')}}<span
                                            class="tx-danger">*</span></label>
                                <div class="col-sm-12 col-md-4 col-12 mg-sm-t-0">
                                    <div id="slWrapperRole" class="parsley-select">
                                        <select class="form-control select2" style="width: 100%" id="role"
                                                name="role" data-placeholder="{{__('user.form.select_role')}}"
                                                data-parsley-class-handler="#slWrapperRole"
                                                data-parsley-errors-container="#slErrorContainerRole"
                                                required data-parsley-required-message="{{__('user.form.error.role')}}">
                                            <option label="Select Role"></option>
                                            <option value="Role1">Role 1</option>
                                            <option value="Role2">Role 2</option>
                                        </select>
                                        <div id="slErrorContainerRole"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mg-t-30">
                                <label class="col-sm-2 form-control-label">{{__('user.datatable.status')}}</label>
                                <div class="col-sm-10 mg-sm-t-0">
                                    <label class="ckbox">
                                        <input type="checkbox" name="status" id="status" checked="true">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mg-t-30">
                        <p class="card-title">{{__('user.modal_user.card.address')}}<p>
                        <div class="card-body">
                            <div class="row" id="location_filter">
                                <label class="col-12 col-sm-2 col-lg-1 form-control-label">{{__('setting.location.region.name')}}
                                    <span class="tx-danger">*</span></label>
                                <div class="col-12 col-sm-3 col-lg-2 mg-sm-t-0">
                                    <div id="slWrapperModalRegion" class="parsley-select">
                                        <select class="form-control select2" style="width: 100%" id="region"
                                                name="filter_modal_region[]" data-placeholder="{{__('user.modal_user.placeholder.region')}}"
                                                data-parsley-class-handler="#slWrapperModalRegion"
                                                data-parsley-errors-container="#slErrorContainerModalRegion"
                                                required
                                                data-parsley-required-message="{{__('setting.location.index.error.region')}}">
                                            <option label="{{__('user.modal_user.placeholder.region')}}"></option>
                                        </select>
                                        <div id="slErrorContainerModalRegion"></div>
                                    </div>
                                </div>

                                <label class="col-12 col-sm-2 col-lg-1 form-control-label text-center">
                                    <i class="fa fa-angle-right text-center tx-50  d-none d-sm-block"></i>
                                </label>

                                <label class="col-12 col-sm-2 col-lg-1 form-control-label">{{__('setting.location.area.name')}}
                                    <span class="tx-danger">*</span></label>
                                <div class="col-12 col-sm-3 col-lg-2 mg-sm-t-0">
                                    <div id="slWrapperModalArea" class="parsley-select">
                                        <select class="form-control select2" style="width: 100%" id="area"
                                                name="filter_modal_area[]" data-placeholder="{{__('user.modal_user.placeholder.area')}}"
                                                data-parsley-class-handler="#slWrapperModalArea"
                                                data-parsley-errors-container="#slErrorContainerModalArea"
                                                required
                                                data-parsley-required-message="{{__('setting.location.index.error.area')}}">
                                            <option label="{{__('user.modal_user.placeholder.area')}}"></option>
                                        </select>
                                        <div id="slErrorContainerModalArea"></div>
                                    </div>
                                </div>

                                <label class="col-12 col-sm-2 col-lg-1 form-control-label text-center">
                                    <i class="fa fa-angle-right text-center tx-50  d-none d-sm-block"></i>
                                </label>

                                <label class="col-12 col-sm-2 col-lg-1  form-control-label">{{__('setting.location.province.name')}}
                                    <span class="tx-danger">*</span></label>
                                <div class="col-12 col-sm-3 col-lg-2 mg-sm-t-0">
                                    <div id="slWrapperProvinceModal" class="parsley-select">
                                        <select class="form-control select2" style="width: 100%" id="province"
                                                name="filter_province[]" data-placeholder="{{__('user.modal_user.placeholder.province')}}"
                                                data-parsley-class-handler="#slWrapperProvinceModal"
                                                data-parsley-errors-container="#slErrorContainerProvinceModal"
                                                required
                                                data-parsley-required-message="{{__('setting.location.index.error.province')}}">
                                            <option label="{{__('user.modal_user.placeholder.province')}}"></option>
                                        </select>
                                        <div id="slErrorContainerProvinceModal"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mg-t-30 address_panel">
                                <label class="col-sm-1 form-control-label">{{__('user.datatable.address')}}</label>
                                <div class="col-sm-11 mg-t-10 mg-sm-t-0">
                                    <input class="form-control" name="address" id="address" value=""
                                        placeholder="{{__('user.form.placeholder.address')}}"
                                        maxlength="190">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">{{__('user.index.cancel')}}</button>
                <button type="button" class="btn btn-primary" id="btnUser"
                    data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                    <i class="fa fa-plus"></i> {{__('user.index.save')}}
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
