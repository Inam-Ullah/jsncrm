@extends('theme1.layouts.app')

@section('content')
<div class="right_col" role="main">
    <div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 mt-20">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fas fa-edit"></i> {{ __('edit_area') }}</h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <div class="col-md-8 col-lg-8 col-sm-12 col-md-offset-2 col-lg-offset-2">
                            <form class="form-horizontal form-label-left" role="form" method="post"
                                action="{{ route('area.update') }}" accept-charset="utf-8" autocomplete="off">
                                @csrf
                                <input type="hidden" name="id" value="{{ $area->id }}">

                                <div class="col-md-12">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('area_name') }} <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control" name="name"
                                                value="{{ old('name', $area->name) }}"
                                                placeholder="{{ __('area_name') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="item form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <button type="submit" class="btn btn-zalpro">
                                                <i class="fas fa-cloud-upload-alt"></i> {{ __('submit') }}
                                            </button>
                                            <a href="{{ route('area') }}" class="btn btn-default">
                                                {{ __('back') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
