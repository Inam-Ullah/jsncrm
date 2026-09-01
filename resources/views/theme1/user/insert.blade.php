<!-- Start add modal -->
<form class="form-horizontal form-label-left" role="form" method="post" action="{{ route('team.insert', $roleName) }}" autocomplete="off">
    @csrf
    <div class="modal fade add_user" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">
                        <i class="fas fa-user-plus"></i> {{ __('add') }} {{ __('new') }} {{ ucfirst($roleName) }}
                    </h4>
                </div>
                <div class="modal-body">

                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">
                            {{ __('isp') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control chosen-select" name="ispid" required>
                                <option value="">{{ __('select_isp') }}</option>
                                @foreach($isps as $isp)
                                    <option value="{{ $isp->id }}" @selected(old('ispid') == $isp->id)>
                                        {{ $isp->company_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">
                            {{ __('name') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12" name="name" type="text"
                                placeholder="{{ __('enter_name') }}" value="{{ old('name') }}" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">
                            {{ __('username') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12 username" name="username"
                                type="text" placeholder="{{ __('enter_username') }}" value="{{ old('username') }}" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">
                            {{ __('password') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12" name="password" type="password"
                                placeholder="{{ __('enter_password') }}" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">
                            {{ __('national_id') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12" name="nic" type="text"
                                placeholder="{{ __('enter_nic') }}" value="{{ old('nic') }}" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">
                            {{ __('phone') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12" name="phone" type="text"
                                placeholder="{{ __('enter_phone_number') }}" value="{{ old('phone') }}" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">
                            {{ __('email') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12" name="email" type="email"
                                placeholder="{{ __('enter_email_address') }}" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">
                            {{ __('address') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12" name="address" type="text"
                                placeholder="{{ __('enter_address') }}" value="{{ old('address') }}" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">
                            {{ __('city') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control ajax-city chosen-select" name="city_id"
                                data-selected="{{ old('city_id') }}" required>
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
<!-- end modal -->
