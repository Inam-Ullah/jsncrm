<form class="form-horizontal form-label-left" role="form" method="post" action="{{ route('isp.insert') }}" autocomplete="off">
    @csrf
    <div class="modal fade add_isp_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel2"><i class="fas fa-user-plus"></i> {{ __('isp_add') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">{{ __('company_name') }} <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12" name="company_name" type="text" placeholder="{{ __('isp_company') }}" value="{{ old('company_name') }}" required>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">{{ __('owner_name') }} <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12" name="poc_name" type="text" placeholder="{{ __('enter_poc_name') }}" value="{{ old('poc_name') }}" required>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">{{ __('mobile') }} <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12" name="mobile" type="text" placeholder="{{ __('enter_mobile') }}" value="{{ old('mobile') }}" required>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">{{ __('address') }} <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12" name="address" type="text" placeholder="{{ __('enter_address') }}" value="{{ old('address') }}" required>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">{{ __('city') }} <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control ajax-city chosen-select" name="city_id" required>
                                <option value="">{{ __('select_city') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-20">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('close') }}</button>
                    <button type="submit" class="btn btn-zalpro">{{ __('submit') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
