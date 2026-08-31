<form class="form-horizontal form-label-left" role="form" method="post"
    action="{{ route('area.insert') }}" accept-charset="utf-8" autocomplete="off">
    @csrf

    <div class="modal fade add_areas_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="fas fa-map-marker-alt"></i> {{ __('add_new_area') }}
                    </h4>
                </div>

                <div class="modal-body">
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('area_type') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <select class="form-control area_areatype" name="type" required>
                                <option value="">{{ __('select_type') }}</option>
                                <option value="1" @selected(old('type') == 1)>{{ __('city') }}</option>
                                <option value="2" @selected(old('type') == 2)>{{ __('area') }}</option>
                                <option value="3" @selected(old('type') == 3)>{{ __('subarea') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="item form-group area_citydiv hide">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('city') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <select class="form-control area_city" name="city">
                                <option value="">{{ __('select_city') }}</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" @selected(old('city') == $city->id)>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group area_areadiv hide">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('area') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <select class="form-control area_area" name="area">
                                <option value="">{{ __('select_area') }}</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}" data-city-id="{{ $area->parent_id }}"
                                        @selected(old('area') == $area->id)>
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('area_name') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12" name="name" type="text"
                                value="{{ old('name') }}" placeholder="{{ __('name') }}" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        {{ __('close') }}
                    </button>
                    <button type="submit" class="btn btn-zalpro">{{ __('submit') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
