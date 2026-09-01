@extends('theme1.layouts.app')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 mt-20">
                <div class="x_panel">

                    <div class="x_title">
                        <h2><i class="fas fa-users"></i> {{ __($roleName) }} {{ __('teams') }}</h2>
                        @if(in_array($author->role_id, [1]))
                        <h2 class="right">
                            <button type="button" class="btn btn-zalpro text-white add-admin-modal" data-toggle="modal" data-target=".add_user">
                                <i class="fas fa-user-plus"></i> {{ __('add') }} {{ __('new') }} {{ ucfirst($roleName) }}
                            </button>
                        </h2>
                        @endif
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <table class="dtAllAdmins table table-striped responsive-utilities jambo_table bulk_action"
                            style="table-layout: auto !important;">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title">#</th>
                                    <th class="column-title">{{ __('photo') }}</th>
                                    <th class="column-title">{{ __('name') }}</th>
                                    <th class="column-title">{{ __('last_login') }}</th>
                                    <th class="column-title">{{ __('city') }}</th>
                                    <th class="column-title">{{ __('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $row)
                                <tr class="even pointer">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <img class="profile_photo"
                                            src="{{ !empty($row->photo) ? asset('assets/images/final/' . $row->photo) : asset('theme1/assets/system/images/user.png') }}"
                                            alt="{{ $row->username }}" style="width:35px; height:35px; border-radius:50%;">
                                    </td>
                                    <td>
                                        <span class="label label-default">{{ $row->name }}</span>
                                        <span class="label label-success ml-5">{{ $row->username }}</span>
                                    </td>
                                    <td>{{ $row->last_login_at ? $row->last_login_at->format('Y-m-d H:i:s') : __('N/A') }}</td>
                                    <td>{{ $row->city ? $row->city->name : __('N/A') }}</td>
                                    <td class="action-link">
                                        <a href="{{ route('team.edit', $row->id) }}" class="mr-5">
                                            <span data-toggle="tooltip" title="{{ __('edit') }}" class="label label-warning">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </a>
                                        @if($author->role_id == 1 && $row->ownedIsps->count() == 0)
                                        <a class="delete-disable user-delete" href="{{ route('team.delete', $row->id) }}">
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

                @if(in_array($author->role_id, [1]))
                @include('theme1.user.insert')
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        if ($('.dtAllAdmins').length) {
            $('.dtAllAdmins').DataTable({
                dom: 'lBfrtip',
                searching: true,
                info: true,
                stateSave: true,
                fixedHeader: true,
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100, 500, 1000],
                responsive: true,
                buttons: [{
                    extend: 'colvis',
                    text: '<i class="fas fa-eye"></i> View',
                    className: 'btn-primary'
                }]
            });
        }

        $(document).on('click', '.user-delete', function (e) {
            e.preventDefault();
            var deleteUrl = $(this).attr('href');

            if (typeof $.confirm === 'function') {
                $.confirm({
                    title: 'Delete Confirmation',
                    content: 'Are you sure you want to delete this record?',
                    type: 'red',
                    buttons: {
                        confirm: {
                            text: 'Yes, Delete',
                            btnClass: 'btn-danger',
                            action: function () {
                                window.location.href = deleteUrl;
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-default'
                        }
                    }
                });
            } else if (confirm('Are you sure you want to delete this record?')) {
                window.location.href = deleteUrl;
            }
        });
    });
</script>
@endsection
