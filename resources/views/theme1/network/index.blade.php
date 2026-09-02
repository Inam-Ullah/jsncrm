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
                        <h2><i class="fas fa-server"></i> {{ __('nas') }} </h2>
                        <h2 class="right">
                            <a class="add-nas-modal" data-toggle="modal" data-target=".add_nas_modal">
                                <button class="btn btn-zalpro text-white"><i class="fas fa-server"></i>
                                    {{ __('add') }} {{ __('new') }} {{ __('nas') }}
                                </button>
                            </a>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="dtNas table table-striped responsive-utilities jambo_table bulk_action"
                            style="table-layout: auto !important;">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="display: table-cell;">ID</th>
                                    <th class="column-title" style="display: table-cell;">NAS IP</th>
                                    <th class="column-title" style="display: table-cell;">NAS Name</th>
                                    <th class="column-title" style="display: table-cell;">Radius Secret</th>
                                    <th class="column-title" style="display: table-cell;">Username</th>
                                    <th class="column-title" style="display: table-cell;">Password</th>
                                    <th class="column-title" style="display: table-cell;">Users</th>
                                    <th class="column-title" style="display: table-cell;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nases as $item)
                                <tr class="eventpointer">
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->nasname }}</td>
                                    <td>{{ $item->shortname }}</td>
                                    <td>123xxxx</td>
                                    <td>{{ $item->apiusername }}</td>
                                    <td>apixxxx</td>
                                    <td>{{ $item->user->count() }}</td>
                                    <td class="action-link network_monitoring">

                                        <a href="{{ route('network.nas.view', $item->id) }}">
                                            <span data-toggle="tooltip" title="View NAS Details"
                                                class="label label-info ">
                                                <i class="fas fa-external-link-alt"></i>
                                            </span>
                                        </a>

                                        <a>
                                            <span data-toggle="tooltip" title="API On/Off" class="label label-success">
                                                <i class="fas fa-project-diagram"></i>
                                            </span>
                                        </a>

                                        <a class="status_indicator">
                                            <span data-toggle="tooltip" title="Online/Offline Status"
                                                class="label label-default ">
                                                <i class="fas fa-check-circle"></i>
                                            </span>
                                        </a>

                                        <a class="instant_check" data-nasid="1">
                                            <span data-toggle="tooltip" title="Instant NAS Check"
                                                class="label label-primary">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </a>

                                        <a href="https://panel.jsonsnetworks.com/network/nas/edit/1">
                                            <span data-toggle="tooltip" title="Edit" class="label label-warning">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </a>

                                        <a class="delete" href="https://panel.jsonsnetworks.com/network/nas/delete/1">
                                            <span data-toggle="tooltip" title="Delete" class="label label-danger ">
                                                <i class="fas fa-times-circle"></i>
                                            </span>
                                        </a>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @include('theme1.network.insert')

            </div>
            <!-- end of col-12 -->
        </div>
    </div>
</div>
<!-- /page content -->
@endsection

@section('scripts')
<!-- Checking Instant NAS Online/Offline Status -->
<script>
    $(document).ready(function() {
        // all admins table
        $('.dtNas').DataTable({
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
                    text: '<i class="fas fa-eye-slash"></i> View',
                    titleAttr: 'Visibility',
                    collectionLayout: 'fixed two-column'
                }
            ]
        });

        // remove buttons from dt permission wise

        $(document).on('click', '.network_monitoring a.instant_check', function() {

            var checkAnchor = $(this);
            var nasid = $(this).attr('data-nasid');
            var url = baseurl + 'network/nas/instantcheck/';

            if (nasid != '') {
                jQuery.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    data: {
                        "nasid": nasid
                    },
                    async: true,
                    beforeSend: function() {
                        $("div#loading").delay(100).fadeIn();
                    },
                    success: function(data) {
                        $("div#loading").delay(100).fadeOut("slow");
                        if (data.apiStatus === 1 && data.coaStatus === 1) {

                            showAlert('green', 'Alert!', 'NAS API Is OK & NAS Is Online/Active.');
                            showAlert('green', 'Alert!', 'NAS Added To Home Server Successfully & CoA Is OK.');

                        } else if (data.apiStatus === 1 && data.coaStatus !== 1) {

                            showAlert('green', 'Alert!', 'NAS API Is OK & NAS Is Online/Active.');
                            showAlert('red', 'Alert!', 'NAS CoA Is Missing, Edit NAS & Update Again.');

                        } else if (data.apiStatus !== 1 && data.coaStatus === 1) {

                            showAlert('green', 'Alert!', 'NAS Added To Home Server Successfully & CoA Is OK.');
                            showAlert('red', 'Alert!', 'NAS API Is Offline/Inactive, Make Sure Your NAS API Is Enabled & User Has Right Permission, Make Sure API Port Is Correct, And Properly Set At Both Panel & NAS. Ignore This Warning If You Are Not Using Mikrotik Router.');

                        } else {

                            showAlert('red', 'Alert!', 'Oops! Something Went Wrong. Its Seems NAS Is Offline. Please, Check Your NAS API & Status.');
                            showAlert('red', 'Alert!', 'Oops! Something Went Wrong. Its Seems NAS CoA Is Not Active & You Need To Edit & Update NAS Again.');

                        }
                    }
                });
            } else {
                showAlert('red', 'Alert!', 'Oops! Something Went Wrong. Its Seems NAS is Offline. Please, Check Your NAS API & Status.');
            }

            function showAlert(color, title, content) {
                $.alert({
                    title: title,
                    type: color,
                    animation: 'top',
                    content: content
                });
            }

        });

    });
</script>
@endsection
