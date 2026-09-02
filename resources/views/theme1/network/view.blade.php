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
                        <h2><i class="fas fa-wifi"></i> NAS Information</h2>

                        <h2 class="right">
                            <a href="https://panel.jsonsnetworks.com/network/nas/edit/1">
                                <button class="btn btn-zalpro text-white"><i class="fas fa-server"></i>
                                    {{ __('edit') }} {{ __('nas') }}
                                </button>
                            </a>
                        </h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-striped responsive-utilities jambo_table bulk_action"
                            style="table-layout: auto !important;">
                            <tbody>
                                <tr>
                                    <td><strong> <i class="fas fa-bookmark"></i> NAS ID</strong></td>
                                    <td>
                                        1 </td>
                                </tr>
                                <tr>
                                    <td><strong> <i class="fas fa-bookmark"></i> NAS Name</strong></td>
                                    <td>
                                        R-720 </td>
                                </tr>
                                <tr>
                                    <td><strong> <i class="fas fa-bookmark"></i> NAS IP</strong></td>
                                    <td>
                                        192.168.20.3 </td>
                                </tr>

                                <tr>
                                    <td><strong> <i class="fas fa-clock"></i> Router Time</strong></td>
                                    <td>
                                        2026-09-02 15:08:49 (Asia/Karachi) </td>
                                </tr>
                                <tr>
                                    <td><strong> <i class="fas fa-ethernet"></i> Total ARP</strong></td>
                                    <td>196</td>
                                </tr>
                                <tr>
                                    <td><strong> <i class="fas fa-network-wired"></i> Total IP
                                            Address</strong></td>
                                    <td>895</td>
                                </tr>
                                <tr>
                                    <td><strong> <i class="fas fa-network-wired"></i> Total
                                            Interface</strong></td>
                                    <td>962</td>
                                </tr>
                                <tr>
                                    <td><strong> <i class="fas fa-clock"></i> PPPoE Interim Update</strong>
                                    </td>
                                    <td>00:03:00</td>
                                </tr>
                                <tr>
                                    <td><strong> <i class="fas fa-project-diagram"></i> Radius Incoming
                                            Accept & Port</strong></td>
                                    <td>Accept: true - Port: 3799</td>
                                </tr>
                                <tr>
                                    <td><strong> <i class="fas fa-clock"></i>
                                            <?=translate('uptime')?>
                                        </strong></td>
                                    <td>
                                        <?=$system->getProperty('uptime')?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong> <i class="fas fa-sort-numeric-down"></i>
                                            <?=translate('version')?>
                                        </strong></td>
                                    <td>
                                        <?=$system->getProperty('version')?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong> <i class="fas fa-memory"></i>
                                            <?=translate('memory')?>
                                        </strong></td>
                                    <td>
                                        <?=round($system->getProperty('free-memory') / 1014 / 1024)?>/
                                        <?=round($system->getProperty('total-memory') / 1024 / 1024)?>
                                        <?=translate('mb')?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong> <i class="fas fa-microchip"></i>
                                            <?=translate('netwk_nas_cpu_load')?>
                                        </strong></td>
                                    <td>
                                        <?=$system->getProperty('cpu-load')?>%
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Nav tabs -->
                                <ul class="zalpro_tabs nav nav-tabs" role="tablist">
                                    <li class="active">
                                        <a href="#interfaces" role="tab" data-toggle="tab">
                                            <i class="fas fa-ethernet"></i> Interfaces </a>
                                    </li>
                                    <li>
                                        <a href="#ipArp" role="tab" data-toggle="tab">
                                            <i class="fas fa-network-wired"></i> IP ARP </a>
                                    </li>
                                    <li>
                                        <a href="#ipAddress" role="tab" data-toggle="tab">
                                            <i class="fas fa-network-wired"></i> IP Address </a>
                                    </li>
                                </ul>
                                <div class="tab-content mb-10">
                                    <div class="tab-pane active" id="interfaces">
                                        <table class="table table-striped responsive-utilities"
                                            style="margin: 2% 0 0 2%;">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>MAC</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>ether1</td>
                                                    <td>ether</td>
                                                    <td>00:0C:29:21:0E:5D</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>ether2</td>
                                                    <td>ether</td>
                                                    <td>00:0C:29:21:0E:67</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>ether3</td>
                                                    <td>ether</td>
                                                    <td>00:0C:29:21:0E:71</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="ipArp">
                                        <table class="table table-striped responsive-utilities"
                                            style="margin: 2% 0 0 2%;">
                                            <thead>
                                                <tr>
                                                    <th>Address</th>
                                                    <th>MAC</th>
                                                    <th>Interface</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>100.172.72.1</td>
                                                    <td>00:0C:29:8F:10:07</td>
                                                    <td>00-vlan10</td>
                                                </tr>
                                                <tr>
                                                    <td>192.168.116.13</td>
                                                    <td>BC:32:5F:F9:AB:15</td>
                                                    <td>vlan116</td>
                                                </tr>
                                                <tr>
                                                    <td>192.168.20.14</td>
                                                    <td>00:0C:29:61:7C:D6</td>
                                                    <td>MGT</td>
                                                </tr>
                                                <tr>
                                                    <td>192.168.12.20</td>
                                                    <td>E4:24:6C:3D:DC:26</td>
                                                    <td>vlan111</td>
                                                </tr>
                                                <tr>
                                                    <td>192.168.116.3</td>
                                                    <td>24:52:6A:E6:33:15</td>
                                                    <td>vlan116</td>
                                                </tr>
                                                <tr>
                                                    <td>192.168.12.145</td>
                                                    <td></td>
                                                    <td>vlan111</td>
                                                </tr>
                                                <tr>
                                                    <td>192.168.116.4</td>
                                                    <td>24:52:6A:02:0A:02</td>
                                                    <td>vlan116</td>
                                                </tr>
                                                <tr>
                                                    <td>192.168.14.60</td>
                                                    <td>74:A0:63:2B:67:A9</td>
                                                    <td>vlan114</td>
                                                </tr>
                                                <tr>
                                                    <td>192.168.12.10</td>
                                                    <td>00:0C:29:6F:DD:93</td>
                                                    <td>vlan111</td>
                                                </tr>
                                                <tr>
                                                    <td>192.168.20.4</td>
                                                    <td>00:0C:29:CA:C6:0E</td>
                                                    <td>MGT</td>
                                                </tr>
                                                <tr>
                                                    <td>192.168.20.20</td>
                                                    <td>00:0C:29:1B:CF:83</td>
                                                    <td>MGT</td>
                                                </tr>
                                                <tr>
                                                    <td>192.168.20.1</td>
                                                    <td>00:0C:29:8F:10:07</td>
                                                    <td>MGT</td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="ipAddress">
                                        <table class="table table-striped responsive-utilities"
                                            style="margin: 2% 0 0 2%;">
                                            <thead>
                                                <tr>
                                                    <th>Address</th>
                                                    <th>Network</th>
                                                    <th>Interface</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>192.168.20.3/26</td>
                                                    <td>192.168.20.0</td>
                                                    <td>MGT</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- end of col-12 -->
    </div>
</div>
<!-- /page content -->

@endsection
