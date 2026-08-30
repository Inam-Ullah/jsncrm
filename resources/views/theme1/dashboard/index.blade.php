@extends('theme1.layouts.app')

@section('content')
    <div class="right_col" role="main">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fas fa-home"></i> Welcome, {{ $author->name }}</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row top_tiles">
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fas fa-users"></i></div>
                                    <div class="count">0</div>
                                    <h3>Total Users</h3>
                                    <p>Dummy value for template migration.</p>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fas fa-user-check"></i></div>
                                    <div class="count">0</div>
                                    <h3>Active Users</h3>
                                    <p>Business logic will be connected later.</p>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fas fa-file-invoice"></i></div>
                                    <div class="count">0</div>
                                    <h3>Invoices</h3>
                                    <p>Dummy value for visual testing.</p>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fas fa-ticket-alt"></i></div>
                                    <div class="count">0</div>
                                    <h3>Open Tickets</h3>
                                    <p>Controller queries are intentionally pending.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fas fa-chart-line"></i> Network Overview</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="alert alert-info">Chart and live network data will be connected after template approval.</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fas fa-bell"></i> Notices</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <p>No dummy notices available.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
