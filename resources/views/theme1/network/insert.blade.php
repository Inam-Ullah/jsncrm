<!-- Start add modal -->
<div class="modal fade add_nas_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="add-nas-label"><i class="fas fa-sitemap"></i> Add New NAS</h4>
            </div>
            
            <form class="form-horizontal form-label-left" role="form" method="post"
                action="{{ route('network.nas.insert') }}" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">NAS IP <span class="required">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input class="form-control" name="nasname" type="text" placeholder="NAS IP" required>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">NAS Name <span class="required">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input class="form-control" name="shortname" type="text" placeholder="NAS Name" required>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Radius Secret <span class="required">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input class="form-control" name="secret" type="password" placeholder="Secret For Radius Server" required>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">API On/Off <span class="required">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input class="form-control" type="checkbox" name="nasapi" value="1">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">NAS Username <span class="required">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input class="form-control" name="nasusername" type="text" placeholder="NAS Username">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">NAS Password <span class="required">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input class="form-control" name="naspassword" type="password" placeholder="NAS Password">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">API Port <span class="required">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input class="form-control" name="api_port" type="text" placeholder="API Port" value="8728" required>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Incoming Port <span class="required">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input class="form-control" name="incoming_port" type="text" placeholder="Incoming Port" value="3799" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-20">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-zalpro">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal -->
