@extends('theme1.layouts.app')

@section('content')
<div class="right_col" role="main">
    <div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 mt-20">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fas fa-user-edit"></i> {{ __('edit') }} {{ optional($user->role)->name ?? __('user') }}</h2>
                        <h2 class="right">
                            @php
                                $roleSlug = strtolower(optional($user->role)->name ?? 'admin');
                                if ($roleSlug == 'sales person') { $roleSlug = 'sales'; }
                            @endphp
                            <a href="{{ route('team', $roleSlug) }}" class="btn btn-default">
                                <i class="fas fa-arrow-left"></i> {{ __('back') }}
                            </a>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left" role="form" method="post"
                            action="{{ route('team.update') }}" autocomplete="off">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ __('isp') }} <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control chosen-select" name="ispid" required>
                                        <option value="">{{ __('select_isp') }}</option>
                                        @foreach($isps as $isp)
                                            <option value="{{ $isp->id }}" @selected(old('ispid', $user->isp_id) == $isp->id)>
                                                {{ $isp->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ __('name') }} <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="name" type="text"
                                        value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ __('username') }} <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12 username" name="username" type="text"
                                        value="{{ old('username', $user->username) }}" required>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ __('password') }}
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="password" type="password"
                                        placeholder="{{ __('leave_blank_to_keep_current_password') }}">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ __('national_id') }} <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="nic" type="text"
                                        value="{{ old('nic', $user->nic) }}" required>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ __('phone') }} <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="phone" type="text"
                                        value="{{ old('phone', $user->phone) }}" required>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ __('email') }} <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="email" type="email"
                                        value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ __('address') }} <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="address" type="text"
                                        value="{{ old('address', $user->address) }}" required>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ __('city') }} <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control ajax-city chosen-select" name="city_id"
                                        data-selected="{{ old('city_id', $user->city_id) }}" required>
                                        <option value="">{{ __('select_city') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-zalpro">{{ __('submit') }}</button>
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
