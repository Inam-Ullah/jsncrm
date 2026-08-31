@extends('theme1.layouts.app')

@section('content')
<div class="right_col" role="main">
    <div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 mt-20">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fas fa-edit"></i> {{ __('edit') }} {{ __('isp') }}</h2>
                        <h2 class="right">
                            <a href="{{ route('isp') }}" class="btn btn-default">
                                <i class="fas fa-arrow-left"></i> {{ __('back') }}
                            </a>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left" role="form" method="post" action="{{ route('isp.update') }}" autocomplete="off">
                            @csrf
                            <input type="hidden" name="id" value="{{ $isp->id }}">

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('company_name') }} <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="company_name" type="text" value="{{ old('company_name', $isp->company_name) }}" required>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('owner_name') }} <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="poc_name" type="text" value="{{ old('poc_name', $isp->poc_name) }}" required>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('mobile') }} <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="mobile" type="text" value="{{ old('mobile', $isp->mobile) }}" required>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('address') }} <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="address" type="text" value="{{ old('address', $isp->address) }}" required>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('city') }} <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control chosen-select" name="city_id" required>
                                        <option value="">{{ __('select_city') }}</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" @selected(old('city_id', $isp->city_id) == $city->id)>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="{{ route('isp') }}" class="btn btn-default">{{ __('cancel') }}</a>
                                    <button type="submit" class="btn btn-zalpro">{{ __('update') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
