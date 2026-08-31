@extends('theme1.layouts.app')

@section('content')
<div class="right_col" role="main">
    <div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 mt-20">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fas fa-address-card"></i> {{ __('isp') }}</h2>

                        @if(in_array($author->role_id, [1, 2]))
                            <h2 class="right">
                                <button type="button" class="btn btn-zalpro text-white add-isp-modal"
                                    data-toggle="modal" data-target=".add_isp_modal">
                                    <i class="fas fa-user-plus"></i> {{ __('isp_add') }}
                                </button>
                            </h2>
                        @endif

                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <table class="dtAllIsp table table-striped responsive-utilities jambo_table bulk_action" style="table-layout: auto !important;">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title">#</th>
                                    <th class="column-title">{{ __('company_name') }}</th>
                                    <th class="column-title">{{ __('owner_name') }}</th>
                                    <th class="column-title">{{ __('mobile') }}</th>
                                    <th class="column-title">{{ __('city') }}</th>
                                    <th class="column-title">{{ __('users') }}</th>
                                    <th class="column-title">{{ __('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($isps as $index => $row)
                                    <tr class="even pointer">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $row->company_name }}</td>
                                        <td>{{ $row->poc_name }}</td>
                                        <td>{{ $row->mobile }}</td>
                                        <td>{{ $row->city ? $row->city->name : 'N/A' }}</td>
                                        <td><span class="label label-info">{{ $row->users->count() }}</span></td>
                                        <td class="action-link">
                                            <a href="{{ route('isp.edit', $row->id) }}" class="mr-5">
                                                <span data-toggle="tooltip" title="{{ __('edit') }}" class="label label-warning">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                            </a>
                                            @if($row->users->count() == 0 && $row->invoices->count() == 0)
                                                <a class="delete-disable isp-delete" href="{{ route('isp.delete', $row->id) }}">
                                                    <span data-toggle="tooltip" title="{{ __('delete') }}" class="label label-danger">
                                                        <i class="fas fa-times-circle"></i>
                                                    </span>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if(in_array($author->role_id, [1, 2]))
                    @include('theme1.isp.insert')
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
