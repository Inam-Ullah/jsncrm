@extends('theme1.layouts.app')

@section('content')
<div class="right_col" role="main">
    <div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 mt-20">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fas fa-map-marker-alt"></i> {{ __('areas') }}</h2>

                        @if(in_array($author->role_id, [1, 2]) || permission('area_add_new'))
                            <h2 class="right">
                                <button type="button" class="btn btn-zalpro text-white add-areas-modal"
                                    data-toggle="modal" data-target=".add_areas_modal">
                                    <i class="fas fa-map-marker-alt"></i> {{ __('add_new_area') }}
                                </button>
                            </h2>
                        @endif

                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <table class="dtAreas table table-striped responsive-utilities jambo_table bulk_action"
                            data-url="{{ route('area.getAreas') }}">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title">{{ __('id') }}</th>
                                    <th class="column-title">{{ __('type') }}</th>
                                    <th class="column-title">{{ __('name') }}</th>
                                    <th class="column-title">{{ __('users') }}</th>
                                    <th class="column-title">{{ __('action') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                @if(in_array($author->role_id, [1, 2]) || permission('area_add_new'))
                    @include('theme1.area.insert')
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
