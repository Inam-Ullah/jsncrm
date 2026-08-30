

$(document).ready(function () {

    //once a form submit it can't be submit again at the same time
    //browser can't stop multiple form submit 
    $("form.activation_modal, form.payment_modal").submit(function () {
        $(":submit", this).attr("disabled", "disabled");
    });

    $("select.chosen").chosen();

    //Dashboard's and Other Notification Auto Hide FlashData Notification
    $(".alert.alert-dismissible.fade.in").delay(10000).hide("Slow");

    /* NAS and API Related JS*/

    $(".nasinterfaces").chosen();

    //all users page table filter
    $(document).on('click', '.filter', function () {
        $('.filter_modal').modal('toggle');
    });

    //Nas ID Select and Display Interfaces and ips
    $('select.nasid').on('change', function () {
        var nasid = $('select.nasid').val();
        var url = baseurl + 'admin_portal/network/nas/getNASInterfaces';
        if (nasid.length !== 0) {
            jQuery.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: { "nasid": nasid },
                async: true,
                beforeSend: function () {
                    $("div#loading").delay(100).fadeIn();
                },
                success: function (data) {
                    $("div#loading").delay(100).fadeOut("slow");
                    $('select.nasinterfaces').html('');
                    if (data.error.length != 0) { //if error found
                        //console.log(data.error);
                        showAlert('red', 'Alert', data.error);
                        location.reload();
                    } else if (data.interfaceHtml.length != 0) {
                        //console.log(data.interfaceHtml);
                        $('select.nasinterfaces').prepend(data.interfaceHtml);
                        $('select.nasinterfaces').trigger("chosen:updated");
                    }
                }
            });
        }
    });

    $('select.nasid').on('change', function () {
        // $('#ipAddressTable tbody').html("");
        table = $('#ipAddressTable').DataTable();
        table.clear().draw();
        var nasid = $('select.nasid').val();
        var url = baseurl + 'admin_portal/network/nas/getNASIPAddresses';
        if (nasid.length != 0) {
            console.log("NAS ID " + nasid);
            $('#ipAddressTable').DataTable().destroy();
            var dataTable = $('#ipAddressTable').DataTable({
                "processing": false,
                "serverSide": true,
                "ajax": {
                    url: url,
                    type: "POST",
                    data: { "nasid": nasid },
                    error: function (xhr, error, thrown) {
                        //console.log(error);
                    }
                },
                dom: 'lfBrtip',
                searching: false,
                info: true,
                order: [],
                responsive: true,
                pageLength: 50,
                lengthMenu: [10, 25, 50, 100, 500, 1000],
                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        titleAttr: 'Print',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy fa-fw"></i> Copy',
                        titleAttr: 'Print',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        titleAttr: 'PDF',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        titleAttr: 'Excel',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        titleAttr: 'CSV',
                        className: 'btn-primary'
                    }
                ]
            });
        }

    });


    /** PPPoE Online Users **/

    $('select.PPPoEOnlineNAS').on('change', function () {
        // $('#ipAddressTable tbody').html("");
        table = $('#pppoeOnlineTable').DataTable();
        table.clear().draw();
        var nasid = $('select.PPPoEOnlineNAS').val();
        var url = baseurl + 'admin_portal/user/user/pppoeapionline';
        if (nasid.length != 0) {
            console.log("NAS ID " + nasid);
            $('#pppoeOnlineTable').DataTable().destroy();
            var dataTable = $('#pppoeOnlineTable').DataTable({
                "processing": false,
                "serverSide": true,
                "ajax": {
                    url: url,
                    type: "POST",
                    data: { "nasid": nasid },
                    beforeSend: function () {
                        $("div#loading").delay(100).fadeIn();
                    },
                    error: function (xhr, error, thrown) {
                        $("div#loading").delay(100).fadeOut();
                        showAlert('red', 'Alert', 'Opps! Something Went Wrong, Check Your NAS.');
                        //console.log(error);
                    }
                },
                dom: 'lfBrtip',
                searching: false,
                info: true,
                order: [],
                pageLength: 50,
                lengthMenu: [10, 25, 50, 100, 500, 1000],
                responsive: true,
                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        titleAttr: 'Print',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy fa-fw"></i> Copy',
                        titleAttr: 'Print',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        titleAttr: 'PDF',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        titleAttr: 'Excel',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        titleAttr: 'CSV',
                        className: 'btn-primary'
                    }
                ]
            });

            $("div#loading").delay(100).fadeOut();
        }

    });


    /** Hotspot Online Users **/

    $('select.HotspotOnlineNAS').on('change', function () {
        // $('#ipAddressTable tbody').html("");
        table = $('#hotspotOnlineTable').DataTable();
        table.clear().draw();
        var nasid = $('select.HotspotOnlineNAS').val();
        var url = baseurl + 'admin_portal/user/user/hotspotapionline';
        if (nasid.length != 0) {
            console.log("NAS ID " + nasid);
            $('#hotspotOnlineTable').DataTable().destroy();
            var dataTable = $('#hotspotOnlineTable').DataTable({
                "processing": false,
                "serverSide": true,
                "ajax": {
                    url: url,
                    type: "POST",
                    data: { "nasid": nasid },
                    beforeSend: function () {
                        $("div#loading").delay(100).fadeIn();
                    },
                    error: function (xhr, error, thrown) {
                        $("div#loading").delay(100).fadeOut();
                        showAlert('red', 'Alert', 'Opps! Something Went Wrong, Check Your NAS.');
                        //console.log(error);
                    }
                },
                dom: 'lfBrtip',
                searching: false,
                info: true,
                order: [],
                pageLength: 50,
                lengthMenu: [10, 25, 50, 100, 500, 1000],
                responsive: true,
                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        titleAttr: 'Print',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy fa-fw"></i> Copy',
                        titleAttr: 'Print',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        titleAttr: 'PDF',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        titleAttr: 'Excel',
                        className: 'btn-primary'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        titleAttr: 'CSV',
                        className: 'btn-primary'
                    }
                ]
            });

            $("div#loading").delay(100).fadeOut();
        }

    });

    /*************************************************************/
    /*************************************************************/

    /*Attendance JS*/
    /**** Staff View Attendance ****/
    $('input.attendatefrom').on('change', function () {
        var attenfromdate = $(this).val();
        if (attenfromdate) {
            $('div.attendatetodiv').show();
        } else {
            $('div.attendatetodiv').hide();
        }
    });
    $('input.attendateto').on('change', function () {
        var attendateto = $(this).val();
        if (attendateto) {
            $('div.attensubmitdiv').show();
        } else {
            $('div.attensubmitdiv').hide();
        }
    });

    $(document).on('click', '#staffViewAttenSubmit', function (e) {
        e.preventDefault();
        var adminid = $('input.adminid').val();
        var fromdate = $('input.attendatefrom').val();
        var todate = $('input.attendateto').val();
        var url = baseurl + 'admin_portal/hrm/staff/staffviewattendance/';

        $('#staffViewAttenTable2').DataTable().destroy();

        var dataTable = $('#staffViewAttenTable2').DataTable({
            "processing": false,
            "serverSide": true,
            "ajax": {
                url: url,
                type: "POST",
                data: { "adminid": adminid, "fromdate": fromdate, "todate": todate },
                beforeSend: function () {
                    $("div#loading").delay(100).fadeIn();
                },
                error: function (xhr, error, thrown) {
                    $("div#loading").delay(100).fadeOut();
                    showAlert('red', 'Alert', 'No, Attendance Found.');
                    //console.log(error);
                }
            },
            dom: 'fBrtip',
            aaSorting: [[0, 'desc']],
            ordering: false,
            searching: false,
            info: true,
            order: [],
            pageLength: 50,
            lengthMenu: [10, 25, 50, 100, 500, 1000],
            responsive: true,
            buttons: [
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    titleAttr: 'Print',
                    className: 'btn-primary'
                },
                {
                    extend: 'copy',
                    text: '<i class="fas fa-copy fa-fw"></i> Copy',
                    titleAttr: 'Print',
                    className: 'btn-primary'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    titleAttr: 'PDF',
                    className: 'btn-primary'
                },
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    titleAttr: 'Excel',
                    className: 'btn-primary'
                },
                {
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    titleAttr: 'CSV',
                    className: 'btn-primary'
                }
            ]
        });

        $("div#loading").delay(100).fadeOut();



        /*var example_table = $('#staffViewAttenTable2').DataTable({
          'ajax': {
            "type"   : "POST",
            "url": url,
            "data" : {"adminid": adminid, "fromdate": fromdate, "todate": todate},
            "dataSrc": ""
          }
        });
        //To Reload The Ajax
        //See DataTables.net for more information about the reload method
        example_table.ajax.reload()*/

        // jQuery.ajax({
        //     type: "POST",
        //     url: url,
        //     dataType: 'json',
        //     data: {"adminid": adminid, "fromdate": fromdate, "todate": todate},
        //     async: true,
        //     beforeSend: function () {
        //         $("div#loading").delay(100).fadeIn();
        //     },
        //     success: function (data) {
        //         $("div#loading").delay(100).fadeOut("slow");
        //         $('table#staffViewAttenTable tbody').html(data);
        //     },
        // });


    });

    /*********************************/


    $('select.staffid').on('change', function () {
        var attenstafftype = $(this).val();
        if (attenstafftype == "all-staff") {
            $('div.datetypediv').show();
            $('div.globaldatediv').show();
            $('div.fromdatediv').hide();
            $('div.todatediv').hide();

            $('.fromdate').attr("required", false);
            $('.todate').attr("required", false);
            $('.attendatetype').attr("required", true);
            $('.globaldate').attr("required", true);
        } else {
            $('div.datetypediv').hide();
            $('div.globaldatediv').hide();
            $('div.fromdatediv').show();
            $('div.todatediv').show();

            $('.fromdate').attr("required", true);
            $('.todate').attr("required", true);
            $('.attendatetype').attr("required", false);
            $('.globaldate').attr("required", false);
        }
    });


    $('select.attendatetype').on('change', function () {
        var attendatetype = $(this).val();
        if (attendatetype == "month") {
            $('.globaldate').datepicker('destroy');
            $('.globaldate').datepicker({
                format: 'yyyy-mm',
                startView: 1
            });
        } else if (attendatetype == "year") {
            $('.globaldate').datepicker('destroy');
            $('.globaldate').datepicker({
                format: 'yyyy',
                startView: 2
            });
        } else {
            $('.globaldate').datepicker('destroy');
            $('.globaldate').datepicker({
                format: 'yyyy-mm-dd',
                startView: 0
            });
        }
    });

    // $(document).on('click', 'button.browseNowSubmit', function(event){
    //     event.preventDefault();
    //     $("div#loading").delay(100).fadeIn();
    //
    //     var url = baseurl + 'hrm/staff/getAttendance/';
    //
    //     var adminid = $(this).closest('form').find('select.staffid').val();
    //     var fromdate = $(this).closest('form').find('input.fromdate').val();
    //     var todate = $(this).closest('form').find('input.todate').val();
    //
    //     console.log(adminid);
    //     console.log(fromdate);
    //     console.log(todate);
    //
    //     if(adminid.length != 0 && fromdate.length != 0 && todate.length != 0){
    //
    //         $('#attendanceCalendar').fullCalendar({
    //             header: {
    //                left: 'prev,next today',
    //                center: 'title',
    //                right: 'month,agendaWeek,agendaDay,listWeek'
    //             },
    //             buttonText: {
    //                   today:    'Today',
    //                   month:    'Month',
    //                   week:     'Week',
    //                   day:      'Day',
    //                   list:     'List'
    //               },
    //                height: 450,
    //                events: {
    //                   url: url,
    //                   type: 'POST',
    //                   data: {"adminid": adminid, "fromdate": fromdate, "todate": todate},
    //                   error: function() {
    //                     showAlert('red', 'Alert', 'Opps! Something Went Wrong.' );
    //                   },
    //                   success: function () {
    //                       $("div#loading").delay(100).fadeOut();
    //                   },
    //                   color: 'yellow',   // a non-ajax option
    //                   textColor: 'black' // a non-ajax option
    //               }
    //         });
    //
    //
    //         $('#attendanceCalendar').fullCalendar('option', 'validRange', {
    //             start: fromdate,
    //             end: todate
    //         });
    //
    //         //$("div#loading").delay(100).fadeOut();
    //
    //
    //     }else{
    //         showAlert('red', 'Alert', 'Please, Select Staff, From Date & To Date' );
    //     }
    // });



    /** ******  Staff Permission  *********************** **/
    $(document).on('click', 'a.admin-permission-btn', function (e) {
        e.preventDefault();

        $("div#loading").delay(100).fadeIn();
        var adminid = $(this).attr('data-adminid');
        $('.permission_modal #adminid').val(adminid);
        var url = baseurl + 'admin_portal/hrm/staff/checkpermission/';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: { "adminid": adminid },
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut();
                $.each(data, function (index, val) {
                    if (val == 1) {
                        $('input[name="' + index + '"]').prop('checked', true).change();
                    } else {
                        $('input[name="' + index + '"]').prop('checked', false).change();
                    }
                });
            }
        });

    });


    /** ******  User Payment  *********************** **/
    $(document).on('click', 'a.user-payment-btn', function () {
        var userid = $(this).attr('data-userid');
        $('.payment_modal input[name="userID"]').val(userid);
    });




    /** ******  Change SMS Text  *********************** **/
    $(document).on('click', 'a.smstext-update-btn', function () {
        var smstextid = $(this).attr('data-id');
        var smstype = $(this).closest('tr').children('.type').text();
        var smstext = $(this).closest('tr').children('.smstext').text();

        $('input#smstextid').val(smstextid);
        $('input#smstype').val(smstype);
        $('input#smstext').val(smstext);

    });



    /*********************************************************/
    /******************* Start of Area Page *************/
    /*********************************************************/

    // $(".citydiv").chosen();
    // $(".areadiv").chosen();

    $(document).on('change', 'select.area_areatype', function () {

        // $('div.city').show();

        var areatype = $('select.area_areatype').val();

        if (areatype == 2) { //area
            $('div.area_citydiv').show();
            $('div.area_areadiv').hide();
            $('.city').attr("required", true);
            $('.area').attr("required", false);
        } else if (areatype == 3) { // subarea
            $('div.area_areadiv').show();
            $('div.area_citydiv').hide();
            $('.city').attr("required", false);
            $('.area').attr("required", true);
        } else {
            $('div.area_areadiv').hide();
            $('div.area_citydiv').hide();
            $('.city').attr("required", false);
            $('.area').attr("required", false);
        }

    });


    /*********************************************************/
    /******************* End of Area Page *************/
    /*********************************************************/


    /*********************************************************/
    /******************* Start of Add Payment Page *************/
    /*********************************************************/

    $(".searchpaymentuser").chosen();

    $(document).on('change', 'select.paymenttype', function () {

        $('div.searchselectdiv').show();

        var paymenttype = $('select.paymenttype').val();

        if (paymenttype == 1) {
            $('div.searchselectdiv span.field-label').html('Select User');
        } else if (paymenttype == 2) {
            $('div.searchselectdiv span.field-label').html('Select Franchise');
        } else {
            $('div.searchselectdiv').hide();
        }

    });

    $(document).on('change', 'select.searchpaymentuser', function () {

        var searchpaymentuser = $('select.searchpaymentuser').val();
        if (searchpaymentuser != '') {
            $('div.paymentmethoddiv').show();
        } else {
            $('div.paymentmethoddiv').hide();
        }

    });

    $(document).on('change', 'select.paymentmethod', function () {

        var paymentmethod = $('select.paymentmethod').val();
        if (paymentmethod == 1) { //cash
            $('div.amountdiv').show();
            $('div.checknodiv').hide();
            $('div.trxiddiv').hide();
            $('div.othersdiv').hide();
        } else if (paymentmethod == 2) { //cheque
            $('div.amountdiv').hide();
            $('div.trxiddiv').hide();
            $('div.othersdiv').hide();
            $('div.checknodiv').show();
        } else if (paymentmethod == 3) { //bkash
            $('div.trxiddiv').show();
            $('div.checknodiv').hide();
            $('div.othersdiv').hide();
            $('div.amountdiv').show();
        } else if (paymentmethod == 4) { //paypal
            $('div.trxiddiv').hide();
            $('div.checknodiv').hide();
            $('div.amountdiv').show();
        } else if (paymentmethod == 5) { //stripe
            $('div.trxiddiv').hide();
            $('div.checknodiv').hide();
            $('div.amountdiv').show();
        } else if (paymentmethod == 6) { //SSLCommerz
            $('div.trxiddiv').hide();
            $('div.checknodiv').hide();
            $('div.amountdiv').show();
        } else if (paymentmethod == 7) { //others
            $('div.trxiddiv').hide();
            $('div.checknodiv').hide();
            $('div.amountdiv').show();
            $('div.othersdiv').show();
        } else if (paymentmethod == 8) { //PayFast
            $('div.trxiddiv').hide();
            $('div.checknodiv').hide();
            $('div.amountdiv').show();
            $('div.othersdiv').hide();
        } else if (paymentmethod == 9) { //Paystack
            $('div.trxiddiv').hide();
            $('div.checknodiv').hide();
            $('div.amountdiv').show();
            $('div.othersdiv').hide();
        } else {
            $('div.amountdiv').hide();
            $('div.checknodiv').hide();
            $('div.trxiddiv').hide();
            $('div.submitdiv').hide();
        }

    });


    $(document).on('change', 'select.withdrawmethod', function () {

        var withdrawmethod = $('select.withdrawmethod').val();
        if (withdrawmethod == 1) { //cash
            $('div.amountdiv').show();
            $('div.checknodiv').hide();
            $('div.trxiddiv').hide();
            $('div.othersdiv').hide();
        } else if (withdrawmethod == 2) { //cheque
            $('div.amountdiv').hide();
            $('div.trxiddiv').hide();
            $('div.othersdiv').hide();
            $('div.checknodiv').show();
        } else if (withdrawmethod == 3) { //bkash
            $('div.trxiddiv').show();
            $('div.checknodiv').hide();
            $('div.othersdiv').hide();
            $('div.amountdiv').show();
        } else if (withdrawmethod == 4) { //paypal
            $('div.trxiddiv').hide();
            $('div.checknodiv').hide();
            $('div.amountdiv').show();
        } else if (withdrawmethod == 5) { //stripe
            $('div.trxiddiv').hide();
            $('div.checknodiv').hide();
            $('div.amountdiv').hide();
        } else if (withdrawmethod == 6) { //SSLCommerz
            $('div.trxiddiv').hide();
            $('div.checknodiv').hide();
            $('div.amountdiv').show();
        } else if (withdrawmethod == 7) { //others
            $('div.trxiddiv').hide();
            $('div.checknodiv').hide();
            $('div.amountdiv').show();
            $('div.othersdiv').show();
        } else {
            $('div.amountdiv').hide();
            $('div.checknodiv').hide();
            $('div.trxiddiv').hide();
            $('div.submitdiv').hide();
        }

    });


    $(document).on('change keyup paste', 'input.chequeno', function () {

        var chequeno = $('input.chequeno').val();
        if (chequeno != '') {
            $('div.amountdiv').show();
        } else {
            $('div.amountdiv').hide();
        }

    });

    // $(document).on('change keyup paste', 'input.trxid', function () {
    //
    //     var trxid = $('input.trxid').val();
    //     console.log(trxid);
    //     if (trxid != '') {
    //         $('div.submitdiv').show();
    //     } else {
    //         $('div.submitdiv').hide();
    //     }
    //
    // });

    $(document).on('change keyup paste', 'input.amount', function () {

        var amount = $('input.amount').val();
        if (amount != '') {
            $('div.submitdiv').show();
        } else {
            $('div.submitdiv').hide();
        }

    });

    $('select.paymenttype').on('change', function () {

        var paymenttype = $('select.paymenttype').val();
        var url = baseurl + 'admin_portal/accounting/payments/ajaxfetch/';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: { "paymenttype": paymenttype },
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('select.searchpaymentuser').html('');
                $('select.searchpaymentuser').prepend(data.names);
                $('select.searchpaymentuser').trigger("chosen:updated");
            }
        });
    });


    /*********************************************************/
    /******************* End of Add Payment Page *************/
    /*********************************************************/




    /*********************************************************/
    /******************* Start of Ledger Report Page *************/
    /*********************************************************/

    $(".userslistauto").chosen();

    $(document).on('change', 'select.reporttype', function () {

        $('div.searchselectdiv').show();

        var reporttype = $('select.reporttype').val();

        if (reporttype == 1) {
            $('div.searchselectdiv span.field-label').html('Select User');
        } else if (reporttype == 2) {
            $('div.searchselectdiv span.field-label').html('Select Franchise');
        } else if (reporttype == 3) {
            $('div.searchselectdiv span.field-label').html('Select Dealer');
        } else if (reporttype == 4) {
            $('div.searchselectdiv span.field-label').html('Select Sub-Dealer');
        } else if (reporttype == 5) {
            $('div.searchselectdiv span.field-label').html('Self Reports');
        } else {
            $('div.searchselectdiv').hide();
            $('div.datefromdiv').hide();
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }

    });

    $(document).on('change', 'select.userslistauto', function () {

        var userslistauto = $('select.userslistauto').val();
        if (userslistauto != '') {
            $('div.datefromdiv').show();
            $('div.datetodiv').hide();
        } else {
            $('div.datefromdiv').hide();
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }

    });

    $(document).on('change keyup paste', 'input.datefrom', function () {

        var datefrom = $('input.datefrom').val();
        if (datefrom != '') {
            $('div.datetodiv').show();
        } else {
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }

    });

    $(document).on('change keyup paste', 'input.dateto', function () {

        var dateto = $('input.dateto').val();
        if (dateto != '') {
            $('div.submitdiv').show();
        } else {
            $('div.submitdiv').hide();
        }

    });

    $('select.reporttype').on('change', function () {

        var reporttype = $('select.reporttype').val();
        var url = baseurl + 'admin_portal/accounting/ledger/ajaxfetchusers/';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: { "reporttype": reporttype },
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('select.userslistauto').html('');
                $('select.userslistauto').prepend(data.names);
                $('select.userslistauto').trigger("chosen:updated");
            }
        });
    });

    $("#ledgerReportSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#ledgerReportFrom');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'admin_portal/accounting/ledger/ajaxfetchreport';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('table#ledgerReportTable tbody').html(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*********************************************************/
    /******************* End of Ledger Report Page *************/
    /*********************************************************/



    /*********************************************************/
    /******************* Start of Balance Report Page *************/
    /*********************************************************/

    //$(".userslistauto").chosen();

    // $(document).on('change', 'select.balancetype', function () {
    //
    //     var reporttype = $('select.balancetype').val();
    //     if (reporttype != '') {
    //         $('div.datefromdiv').show();
    //         $('div.datetodiv').hide();
    //     } else {
    //         $('div.datefromdiv').hide();
    //         $('div.datetodiv').hide();
    //         $('div.submitdiv').hide();
    //     }
    //
    // });
    //
    //
    // $(document).on('change keyup paste', 'input.datefrom', function () {
    //
    //     var datefrom = $('input.datefrom').val();
    //     if (datefrom != '') {
    //         $('div.datetodiv').show();
    //     } else {
    //         $('div.datetodiv').hide();
    //         $('div.submitdiv').hide();
    //     }
    //
    // });
    //
    // $(document).on('change keyup paste', 'input.dateto', function () {
    //
    //     var dateto = $('input.dateto').val();
    //     if (dateto != '') {
    //         $('div.submitdiv').show();
    //     } else {
    //         $('div.submitdiv').hide();
    //     }
    //
    // });


    $("#balanceReportSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#balanceReportFrom');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'admin_portal/accounting/balancereport/ajaxfetchreport';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('table#balanceReportTable tbody').html(data.balanceData);
                $('table#balanceReportSummeryTable tbody tr td.totalBalance').html(data.totalBalance);
                $('table#balanceReportSummeryTable tbody tr td.totalAdvance').html(data.totalAdvance);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*********************************************************/
    /******************* End of Balance Report Page *************/
    /*********************************************************/

    /*********************************************************/
    /******************* Start of Franchise Ledger Report For Dealer & Subdealer *************/
    /*********************************************************/

    $(".userslistauto").chosen();

    $(document).on('change', 'select.frreporttype', function () {

        $('div.searchselectdiv').show();

        var reporttype = $('select.frreporttype').val();

        if (reporttype == 1) {
            $('div.searchselectdiv span.field-label').html('Select Dealer');
        } else if (reporttype == 2) {
            $('div.searchselectdiv span.field-label').html('Select Subdealer');
        } else if (reporttype == 3) {
            $('div.searchselectdiv span.field-label').html('Select User');
        } else {
            $('div.searchselectdiv').hide();
            $('div.datefromdiv').hide();
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }

    });

    $(document).on('change', 'select.userslistauto', function () {

        var userslistauto = $('select.userslistauto').val();
        if (userslistauto != '') {
            $('div.datefromdiv').show();
            $('div.datetodiv').hide();
        } else {
            $('div.datefromdiv').hide();
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }

    });

    $(document).on('change keyup paste', 'input.datefrom', function () {

        var datefrom = $('input.datefrom').val();
        if (datefrom != '') {
            $('div.datetodiv').show();
        } else {
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }

    });

    $(document).on('change keyup paste', 'input.dateto', function () {

        var dateto = $('input.dateto').val();
        if (dateto != '') {
            $('div.submitdiv').show();
        } else {
            $('div.submitdiv').hide();
        }

    });

    $('select.frreporttype').on('change', function () {

        var reporttype = $('select.frreporttype').val();
        var url = baseurl + 'admin_portal/reseller/ledger/ajaxfetchusers/';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: { "reporttype": reporttype },
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('select.userslistauto').html('');
                $('select.userslistauto').prepend(data.names);
                $('select.userslistauto').trigger("chosen:updated");
            }
        });
    });

    $("#frledgerReportSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#frledgerReportFrom');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'admin_portal/reseller/ledger/ajaxfetchreport';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('table#frledgerReportTable tbody').html(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*********************************************************/
    /******************* End of Franchise Ledger Report For Dealer & Subdealer *************/
    /*********************************************************/



    /*********************************************************/
    /******************* Start of Dealer Ledger Report For Subdealer *************/
    /*********************************************************/

    $(".userslistauto").chosen();

    $(document).on('change', 'select.drreporttype', function () {

        $('.searchselectdiv').show();

        var reporttype = $('select.drreporttype').val();

        if (reporttype == 1) {
            $('div.searchselectdiv span.field-label').html('Select Users');
        } else if (reporttype == 2) {
            $('div.searchselectdiv span.field-label').html('Select Sub-Dealer');
        } else {
            $('div.searchselectdiv').hide();
            $('div.datefromdiv').hide();
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }

    });

    $(document).on('change', 'select.userslistauto', function () {

        var userslistauto = $('select.userslistauto').val();
        if (userslistauto != '') {
            $('div.datefromdiv').show();
            $('div.datetodiv').hide();
        } else {
            $('div.datefromdiv').hide();
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }

    });

    $(document).on('change keyup paste', 'input.datefrom', function () {

        var datefrom = $('input.datefrom').val();
        if (datefrom != '') {
            $('div.datetodiv').show();
        } else {
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }

    });

    $(document).on('change keyup paste', 'input.dateto', function () {

        var dateto = $('input.dateto').val();
        if (dateto != '') {
            $('div.submitdiv').show();
        } else {
            $('div.submitdiv').hide();
        }

    });

    $('select.drreporttype').on('change', function () {

        var reporttype = $('select.drreporttype').val();
        var url = baseurl + 'admin_portal/dealer/ledger/ajaxfetchusers/';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: { "reporttype": reporttype },
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('select.userslistauto').html('');
                $('select.userslistauto').prepend(data.names);
                $('select.userslistauto').trigger("chosen:updated");
            }
        });
    });

    $("#drledgerReportSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#drledgerReportFrom');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'admin_portal/dealer/ledger/ajaxfetchreport';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('table#drledgerReportTable tbody').html(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*********************************************************/
    /******************* End of Franchise Ledger Report For Dealer & Subdealer *************/
    /*********************************************************/


    /*********************************************************/
    /******************* Start of User Profile Ledger Report Page *************/
    /*********************************************************/

    $(document).on('change keyup paste', 'input.uplgdatefrom', function () {

        var uplgdatefrom = $('.uplgdatefrom').val();
        if (uplgdatefrom != '') {
            $('div.uplgdatetodiv').show();
        } else {
            $('div.uplgdatetodiv').hide();
            $('div.uplgsubmitdiv').hide();
        }

    });

    $(document).on('change keyup paste', 'input.uplgdateto', function () {

        var dateto = $('input.uplgdateto').val();
        if (dateto !== '') {
            $('div.uplgsubmitdiv').show();
        } else {
            $('div.uplgsubmitdiv').hide();
        }

    });

    $("#userPLgReportSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#userPLgReportFrom');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'admin_portal/user/user/ledgerReportAjax';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('table#userPLgReportTable tbody').html(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*********************************************************/
    /******************* End of User Ledger Report Page *************/
    /*********************************************************/


    /*********************************************************/
    /************** Start of User Profile Activity Log ********/
    /*********************************************************/

    $(document).on('change keyup paste', '.userALog-report input.datefrom', function () {

        var datefrom = $('.userALog-report input.datefrom').val();
        if (datefrom !== '') {
            $('.userALog-report .datetodiv').show();
        } else {
            $('.userALog-report .datetodiv').hide();
            $('.userALog-report .submitdiv').hide();
        }

    });

    $(document).on('change keyup paste', '.userALog-report input.dateto', function () {

        var dateto = $('.userALog-report input.dateto').val();
        if (dateto !== '') {
            $('.userALog-report .submitdiv').show();
        } else {
            $('.userALog-report .submitdiv').hide();
        }

    });

    $("#userALogSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#userALogFrom');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'admin_portal/user/user/activityReportAjax';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('table#userActivitylogTBL tbody').html(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*********************************************************/
    /******************* End of User Ledger Report Page *************/
    /*********************************************************/

    /*********************************************************/
    /************** Start of Admin Profile Activity Log ********/
    /*********************************************************/

    // $(document).on('change keyup paste', '.adminALog-report input.datefrom', function () {

    //     var datefrom = $('.adminALog-report input.datefrom').val();
    //     if (datefrom !== '') {
    //         $('.adminALog-report .datetodiv').show();
    //     } else {
    //         $('.adminALog-report .datetodiv').hide();
    //         $('.adminALog-report .submitdiv').hide();
    //     }

    // });

    // $(document).on('change keyup paste', '.adminALog-report input.dateto', function () {

    //     var dateto = $('.adminALog-report input.dateto').val();
    //     if (dateto !== '') {
    //         $('.adminALog-report .submitdiv').show();
    //     } else {
    //         $('.adminALog-report .submitdiv').hide();
    //     }

    // });

    // $("#adminALogSubmit").click(function (event) {
    //     event.preventDefault();

    //     var form = $('form#adminALogFrom');
    //     var formData = new FormData($(form)[0]);
    //     var url = baseurl + 'admin_portal/admin/admin/activityReportAjax';

    //     jQuery.ajax({
    //         type: "POST",
    //         url: url,
    //         dataType: 'json',
    //         data: formData,
    //         async: true,
    //         beforeSend: function () {
    //             $("div#loading").delay(100).fadeIn();
    //         },
    //         success: function (data) {
    //             console.log(data);
    //             $("div#loading").delay(100).fadeOut("slow");
    //             $('table#adminActivitylogTBL tbody').html(data);
    //         },
    //         cache: false,
    //         contentType: false,
    //         processData: false
    //     });
    // });



    // $("#adminPLgReportSubmit").click(function (event) {
    //     event.preventDefault();

    //     var form = $('form#adminPLgReportFrom');
    //     var formData = new FormData($(form)[0]);
    //     var url = baseurl + 'admin_portal/admin/admin/ledgerReportAjax';

    //     jQuery.ajax({
    //         type: "POST",
    //         url: url,
    //         dataType: 'json',
    //         data: formData,
    //         async: true,
    //         beforeSend: function () {
    //             $("div#loading").delay(100).fadeIn();
    //         },
    //         success: function (data) {
    //             $("div#loading").delay(100).fadeOut("slow");
    //             $('table#adminPLgReportTable tbody').html(data);
    //         },
    //         cache: false,
    //         contentType: false,
    //         processData: false
    //     });
    // });


    /*********************************************************/
    /******************* End of Admin View Activity Page *************/
    /*********************************************************/

    /*********************************************************/
    /************** Start of Staff Profile Activity Log ********/
    /*********************************************************/

    $(document).on('change keyup paste', '.staffALog-report input.datefrom', function () {

        var datefrom = $('.staffALog-report input.datefrom').val();
        if (datefrom !== '') {
            $('.staffALog-report .datetodiv').show();
        } else {
            $('.staffALog-report .datetodiv').hide();
            $('.staffALog-report .submitdiv').hide();
        }

    });

    $(document).on('change keyup paste', '.staffALog-report input.dateto', function () {

        var dateto = $('.staffALog-report input.dateto').val();
        if (dateto !== '') {
            $('.staffALog-report .submitdiv').show();
        } else {
            $('.staffALog-report .submitdiv').hide();
        }

    });

    $("#staffALogSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#staffALogFrom');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'admin_portal/hrm/staff/activityReportAjax';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('table#staffActivitylogTBL tbody').html(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*********************************************************/
    /******************* End of Staff View Activity Page *************/
    /*********************************************************/



    /*********************************************************/
    /************** Start of Franchise Profile Activity Log ********/
    /*********************************************************/

    $(document).on('change keyup paste', '.franchiseALog-report input.datefrom', function () {

        var datefrom = $('.franchiseALog-report input.datefrom').val();
        if (datefrom !== '') {
            $('.franchiseALog-report .datetodiv').show();
        } else {
            $('.franchiseALog-report .datetodiv').hide();
            $('.franchiseALog-report .submitdiv').hide();
        }

    });

    $(document).on('change keyup paste', '.franchiseALog-report input.dateto', function () {

        var dateto = $('.franchiseALog-report input.dateto').val();
        if (dateto !== '') {
            $('.franchiseALog-report .submitdiv').show();
        } else {
            $('.franchiseALog-report .submitdiv').hide();
        }

    });

    $("#franchiseALogSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#franchiseALogFrom');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'admin_portal/reseller/franchise/activityReportAjax';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('table#franchiseActivitylogTBL tbody').html(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*********************************************************/
    /******************* End of Franchise Activity View Page *************/
    /*********************************************************/

    /*********************************************************/
    /******************* Start of Franchise Ledger Report Page *************/
    /*********************************************************/

    $(document).on('change keyup paste', 'input.fplgdatefrom', function () {

        var uplgdatefrom = $('.fplgdatefrom').val();
        if (uplgdatefrom != '') {
            $('div.fplgdatetodiv').show();
        } else {
            $('div.fplgdatetodiv').hide();
            $('div.fplgsubmitdiv').hide();
        }

    });

    $(document).on('change keyup paste', 'input.fplgdateto', function () {

        var dateto = $('input.fplgdateto').val();
        if (dateto !== '') {
            $('div.fplgsubmitdiv').show();
        } else {
            $('div.fplgsubmitdiv').hide();
        }

    });

    $("#franchisePLgReportSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#franchisePLgReportFrom');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'admin_portal/reseller/franchise/ledgerReportAjax';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('table#franchisePLgReportTable tbody').html(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*********************************************************/
    /******************* End of Franchise Ledger Report Page *************/
    /*********************************************************/


    /*********************************************************/
    /************** Start of Dealer Profile Activity Log ********/
    /*********************************************************/

    $(document).on('change keyup paste', '.dealerALog-report input.datefrom', function () {

        var datefrom = $('.dealerALog-report input.datefrom').val();
        if (datefrom !== '') {
            $('.dealerALog-report .datetodiv').show();
        } else {
            $('.dealerALog-report .datetodiv').hide();
            $('.dealerALog-report .submitdiv').hide();
        }

    });

    $(document).on('change keyup paste', '.dealerALog-report input.dateto', function () {

        var dateto = $('.dealerALog-report input.dateto').val();
        if (dateto !== '') {
            $('.dealerALog-report .submitdiv').show();
        } else {
            $('.dealerALog-report .submitdiv').hide();
        }

    });

    $("#dealerALogSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#dealerALogFrom');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'admin_portal/dealer/dealer/activityReportAjax';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('table#dealerActivitylogTBL tbody').html(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*********************************************************/
    /******************* End of Dealer Activity View Page *************/
    /*********************************************************/

    /*********************************************************/
    /******************* Start of Dealer Ledger Report Page *************/
    /*********************************************************/

    $(document).on('change keyup paste', 'input.dplgdatefrom', function () {

        var uplgdatefrom = $('.dplgdatefrom').val();
        if (uplgdatefrom != '') {
            $('div.dplgdatetodiv').show();
        } else {
            $('div.dplgdatetodiv').hide();
            $('div.dplgsubmitdiv').hide();
        }

    });

    $(document).on('change keyup paste', 'input.dplgdateto', function () {

        var dateto = $('input.dplgdateto').val();
        if (dateto !== '') {
            $('div.dplgsubmitdiv').show();
        } else {
            $('div.dplgsubmitdiv').hide();
        }

    });

    $("#dealerPLgReportSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#dealerPLgReportFrom');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'admin_portal/dealer/dealer/ledgerReportAjax';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('table#dealerPLgReportTable tbody').html(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*********************************************************/
    /******************* End of Dealer Ledger Report Page *************/
    /*********************************************************/


    /*********************************************************/
    /************** Start of Subdealer Profile Activity Log ********/
    /*********************************************************/

    $(document).on('change keyup paste', '.subdealerALog-report input.datefrom', function () {

        var datefrom = $('.subdealerALog-report input.datefrom').val();
        if (datefrom !== '') {
            $('.subdealerALog-report .datetodiv').show();
        } else {
            $('.subdealerALog-report .datetodiv').hide();
            $('.subdealerALog-report .submitdiv').hide();
        }

    });

    $(document).on('change keyup paste', '.subdealerALog-report input.dateto', function () {

        var dateto = $('.subdealerALog-report input.dateto').val();
        if (dateto !== '') {
            $('.subdealerALog-report .submitdiv').show();
        } else {
            $('.subdealerALog-report .submitdiv').hide();
        }

    });

    $("#subdealerALogSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#subdealerALogFrom');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'admin_portal/subdealer/subdealer/activityReportAjax';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('table#subdealerActivitylogTBL tbody').html(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*********************************************************/
    /******************* End of Dealer Activity View Page *************/
    /*********************************************************/

    /*********************************************************/
    /******************* Start of Dealer Ledger Report Page *************/
    /*********************************************************/

    $(document).on('change keyup paste', 'input.sdplgdatefrom', function () {

        var uplgdatefrom = $('.sdplgdatefrom').val();
        if (uplgdatefrom != '') {
            $('div.sdplgdatetodiv').show();
        } else {
            $('div.sdplgdatetodiv').hide();
            $('div.sdplgsubmitdiv').hide();
        }

    });

    $(document).on('change keyup paste', 'input.sdplgdateto', function () {

        var dateto = $('input.sdplgdateto').val();
        if (dateto !== '') {
            $('div.sdplgsubmitdiv').show();
        } else {
            $('div.sdplgsubmitdiv').hide();
        }

    });

    $("#subdealerPLgReportSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#subdealerPLgReportFrom');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'admin_portal/subdealer/subdealer/ledgerReportAjax';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('table#subdealerPLgReportTable tbody').html(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*********************************************************/
    /******************* End of subdealer Ledger Report Page *************/
    /*********************************************************/



    /*********************************************************/
    /******************* Start of Payment Report Page *************/
    /*********************************************************/


    $(document).on('change keyup paste', 'input.datefrom', function () {

        var datefrom = $('input.datefrom').val();
        if (datefrom != '') {
            $('div.datetodiv').show();
        } else {
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }

    });

    $(document).on('change keyup paste', 'input.dateto', function () {

        var dateto = $('input.dateto').val();
        if (dateto != '') {
            $('div.submitdiv').show();
        } else {
            $('div.submitdiv').hide();
        }

    });

    // $("#paymentReportSubmit").click(function (event) {
    //     event.preventDefault();

    //     var form = $('form#paymentReportFrom');
    //     var formData = new FormData($(form)[0]);
    //     var url = baseurl + 'admin_portal/accounting/payments/ajaxfetchreport';

    //     jQuery.ajax({
    //         type: "POST",
    //         url: url,
    //         dataType: 'json',
    //         data: formData,
    //         async: true,
    //         beforeSend: function () {
    //             $("div#loading").delay(100).fadeIn();
    //         },
    //         success: function (data) {
    //             $("div#loading").delay(100).fadeOut("slow");
    //             $('table#paymentReportTable tbody').html(data);
    //         },
    //         cache: false,
    //         contentType: false,
    //         processData: false
    //     });
    // });


    /*********************************************************/
    /******************* End of Payment Report Page *************/
    /*********************************************************/



    /*********************************************************/
    /******************* Start of Franchise Payment Report Page *************/
    /*********************************************************/


    $(document).on('change keyup paste', 'input.datefrom', function () {

        var datefrom = $('input.datefrom').val();
        if (datefrom != '') {
            $('div.datetodiv').show();
        } else {
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }

    });

    $(document).on('change keyup paste', 'input.dateto', function () {

        var dateto = $('input.dateto').val();
        if (dateto != '') {
            $('div.submitdiv').show();
        } else {
            $('div.submitdiv').hide();
        }

    });

    $("#frpaymentReportSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#frpaymentReportFrom');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'admin_portal/accounting/frpayments/ajaxfetchreport';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('table#frpaymentReportTable tbody').html(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*********************************************************/
    /******************* End of Franchise Payment Report Page *************/
    /*********************************************************/



    /*********************************************************/
    /******************* Start of Dealer Payment Report Page *************/
    /*********************************************************/


    $(document).on('change keyup paste', 'input.datefrom', function () {

        var datefrom = $('input.datefrom').val();
        if (datefrom != '') {
            $('div.datetodiv').show();
        } else {
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }

    });

    $(document).on('change keyup paste', 'input.dateto', function () {

        var dateto = $('input.dateto').val();
        if (dateto != '') {
            $('div.submitdiv').show();
        } else {
            $('div.submitdiv').hide();
        }

    });

    $("#drpaymentReportSubmit").click(function (event) {
        event.preventDefault();

        var form = $('form#drpaymentReportFrom');
        var formData = new FormData($(form)[0]);
        var url = baseurl + 'admin_portal/dealer/drpayments/ajaxfetchreport';

        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                $('table#drpaymentReportTable tbody').html(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*********************************************************/
    /******************* End of Dealer Payment Report Page *************/
    /*********************************************************/


    /*********************************************************/
    /******************* Start of BW Policy Page *************/
    /*********************************************************/


    $(document).on('change keyup paste', 'input.groupname', function () {

        var groupname = $('input.groupname').val();
        if (groupname != '') {
            $('div.bmup').show();
        } else {
            $('div.bmup').hide();
            $('div.bmdown').hide();
            $('div.bmdown').hide();
            $('div.boption').hide();
            $('div.blup').hide();
            $('div.bldown').hide();
            $('div.btup').hide();
            $('div.btdown').hide();
            $('div.btimeup').hide();
            $('div.btimedown').hide();
            $('div.bsubmit').hide();
        }

    });


    $(document).on('change keyup paste', 'select.maxup', function () {

        var maxup = $('select.maxup').val();
        var burstlimitup = $('select.burstlimitup').val();
        var burstthdup = $('select.burstthdup').val();

        var maxLimitUp = parseInt(maxup.slice(0, -1));
        var burstLimitUp = parseInt(burstlimitup.slice(0, -1));
        var burstThresholdUp = parseInt(burstthdup.slice(0, -1));

        if (maxLimitUp > 200) {
            var maxLimitUpSize = 'KB';
        } else {
            var maxLimitUpSize = 'MB';
        }

        if (burstLimitUp > 200) {
            var burstLimitUpSize = 'KB';
        } else {
            var burstLimitUpSize = 'MB';
        }

        if (burstThresholdUp > 200) {
            var burstThresholdUpSize = 'KB';
        } else {
            var burstThresholdUpSize = 'MB';
        }

        if (burstlimitup != '') {
            /**************************** Checking Maxup & Burst Up **********************/

            if (maxLimitUpSize == "KB" && burstLimitUpSize == "KB") {  //first check if both are kb

                if (burstLimitUp < maxLimitUp) { // if maxup larger than burst then error

                    showAlert('red', 'Alert', 'Burst Up is Lower Than Max Up');
                    borderRed(['select.burstlimitup', 'select.maxup'], '#CE5454');
                    $('div.bsubmit').hide();

                } else {
                    borderRed(['select.burstlimitup', 'select.maxup'], '#DDE2E8');
                    $('div.bsubmit').show();
                }

            } else if (maxLimitUpSize == "MB" && burstLimitUpSize == "MB") { //first check if both are mb

                if (burstLimitUp < maxLimitUp) { // if maxup larger than burst then error

                    showAlert('red', 'Alert', 'Burst Up is Lower Than Max Up');
                    borderRed(['select.burstlimitup', 'select.maxup'], '#CE5454');
                    $('div.bsubmit').hide();

                } else {

                    borderRed(['select.burstlimitup', 'select.maxup'], '#DDE2E8');
                    $('div.bsubmit').show();
                }

            } else if (maxLimitUpSize == "KB" && burstLimitUpSize != "KB") { //if not kb then alert
                if (maxLimitUp > 200 && burstLimitUp < 200) { // if maxup larger than burst then error

                    borderRed(['select.burstlimitup', 'select.maxup'], '#DDE2E8');
                    $('div.bsubmit').show();

                } else {

                    showAlert('red', 'Alert', 'Burst Up is Lower Than Max Up');
                    borderRed(['select.burstlimitup', 'select.maxup'], '#CE5454');
                    $('div.bsubmit').hide();

                }
            }
        }

        if (maxup != '') {
            $('div.bmdown').show();
        } else {
            $('div.bmdown').hide();
            $('div.boption').hide();
            $('div.blup').hide();
            $('div.bldown').hide();
            $('div.btup').hide();
            $('div.btdown').hide();
            $('div.btimeup').hide();
            $('div.btimedown').hide();
            $('div.bsubmit').hide();
        }

    });

    $(document).on('change keyup paste', 'select.maxdown', function () {

        var maxdown = $('select.maxdown').val();
        var burstlimitdown = $('select.burstlimitdown').val();
        var burstthddown = $('select.burstthddown').val();

        var maxLimitdown = parseInt(maxdown.slice(0, -1));
        var burstLimitdown = parseInt(burstlimitdown.slice(0, -1));
        var burstThresholddown = parseInt(burstthddown.slice(0, -1));

        if (maxLimitdown > 200) {
            var maxLimitdownSize = 'KB';
        } else {
            var maxLimitdownSize = 'MB';
        }

        if (burstLimitdown > 200) {
            var burstLimitdownSize = 'KB';
        } else {
            var burstLimitdownSize = 'MB';
        }

        if (burstThresholddown > 200) {
            var burstThresholddownSize = 'KB';
        } else {
            var burstThresholddownSize = 'MB';
        }

        if (burstLimitdown != '') {
            /**************************** Checking Maxdown & Burst down **********************/

            if (maxLimitdownSize == "KB" && burstLimitdownSize == "KB") {  //first check if both are kb

                if (burstLimitdown < maxLimitdown) { // if maxdown larger than burst then error

                    showAlert('red', 'Alert', 'Burst Down is Lower Than Max Down');
                    borderRed(['select.burstlimitdown', 'select.maxdown'], '#CE5454');
                    $('div.bsubmit').hide();

                } else {

                    borderRed(['select.burstlimitdown', 'select.maxdown'], '#DDE2E8');
                    $('div.bsubmit').show();

                }

            } else if (maxLimitdownSize == "MB" && burstLimitdownSize == "MB") { //first check if both are mb

                if (burstLimitdown < maxLimitdown) { // if maxdown larger than burst then error
                    showAlert('red', 'Alert', 'Burst Down is Lower Than Max Down');
                    borderRed(['select.burstlimitdown', 'select.maxdown'], '#CE5454');
                    $('div.bsubmit').hide();
                } else {

                    borderRed(['select.burstlimitdown', 'select.maxdown'], '#DDE2E8');
                    $('div.bsubmit').show();

                }

            } else if (maxLimitdownSize == "KB" && burstLimitdownSize != "KB") { //if not kb then alert
                if (maxLimitdown > 200 && burstLimitdown < 200) { // if maxup larger than burst then error

                    borderRed(['select.burstlimitdown', 'select.maxdown'], '#DDE2E8');
                    $('div.bsubmit').show();

                } else {

                    showAlert('red', 'Alert', 'Burst Down is Lower Than Max Down');
                    borderRed(['select.burstlimitdown', 'select.maxdown'], '#CE5454');
                    $('div.bsubmit').hide();

                }
            }
        }


        if (maxdown != '') {
            $('div.boption').show();
            $('div.bsubmit').show();
        } else {
            $('div.boption').hide();
            $('div.blup').hide();
            $('div.bldown').hide();
            $('div.btup').hide();
            $('div.btdown').hide();
            $('div.btimeup').hide();
            $('div.btimedown').hide();
            $('div.bsubmit').hide();
        }

    });

    $(document).on('change keyup paste', 'select.burstoption', function () {

        var burstoption = $('select.burstoption').val();
        if (burstoption == 1) {
            $('div.blup').show();

            $('.burstlimitup').attr("required", true);
            $('.burstlimitdown').attr("required", true);
            $('.burstthdup').attr("required", true);
            $('.burstthddown').attr("required", true);
            $('.bursttimeup').attr("required", true);
            $('.bursttimedown').attr("required", true);

        } else {
            $('div.blup').hide();
            $('div.bldown').hide();
            $('div.btup').hide();
            $('div.btdown').hide();
            $('div.btimeup').hide();
            $('div.btimedown').hide();

            $('.burstlimitup').attr("required", false);
            $('.burstlimitdown').attr("required", false);
            $('.burstthdup').attr("required", false);
            $('.burstthddown').attr("required", false);
            $('.bursttimeup').attr("required", false);
            $('.bursttimedown').attr("required", false);

        }

    });

    $(document).on('change keyup paste', 'select.burstlimitup', function () {

        var maxup = $('select.maxup').val();
        var burstlimitup = $('select.burstlimitup').val();
        var burstthdup = $('select.burstthdup').val();

        var maxLimitUp = parseInt(maxup.slice(0, -1));
        var burstLimitUp = parseInt(burstlimitup.slice(0, -1));
        var burstThresholdUp = parseInt(burstthdup.slice(0, -1));

        if (maxLimitUp > 200) {
            var maxLimitUpSize = 'KB';
        } else {
            var maxLimitUpSize = 'MB';
        }

        if (burstLimitUp > 200) {
            var burstLimitUpSize = 'KB';
        } else {
            var burstLimitUpSize = 'MB';
        }

        if (burstThresholdUp > 200) {
            var burstThresholdUpSize = 'KB';
        } else {
            var burstThresholdUpSize = 'MB';
        }


        /**************************** Checking Maxup & Burst Up **********************/

        if (maxLimitUpSize == "KB" && burstLimitUpSize == "KB") {  //first check if both are kb

            if (burstLimitUp < maxLimitUp) { // if maxup larger than burst then error

                showAlert('red', 'Alert', 'Burst Up is Lower Than Max Up');
                borderRed(['select.burstlimitup', 'select.maxup'], '#CE5454');
                $('div.bsubmit').hide();

            } else {

                borderRed(['select.burstlimitup', 'select.maxup'], '#DDE2E8');
                $('div.bsubmit').show();
            }

        } else if (maxLimitUpSize == "MB" && burstLimitUpSize == "MB") { //first check if both are mb

            if (burstLimitUp < maxLimitUp) { // if maxup larger than burst then error

                showAlert('red', 'Alert', 'Burst Up is Lower Than Max Up');
                borderRed(['select.burstlimitup', 'select.maxup'], '#CE5454');
                $('div.bsubmit').hide();

            } else {

                borderRed(['select.burstlimitup', 'select.maxup'], '#DDE2E8');
                $('div.bsubmit').show();
            }

        } else if (maxLimitUpSize == "KB" && burstLimitUpSize != "KB") { //if not kb then alert

            if (maxLimitUp > 200 && burstLimitUp < 200) { // if maxup larger than burst then error

                borderRed(['select.burstlimitup', 'select.maxup'], '#DDE2E8');
                $('div.bsubmit').show();

            } else {

                showAlert('red', 'Alert', 'Burst Up is Lower Than Max Up');
                borderRed(['select.burstlimitup', 'select.maxup'], '#CE5454');
                $('div.bsubmit').hide();

            }

        }


        /************************ Burst Limit Up & Threshold Up*******************************************/

        if (burstthdup != '') {

            if (burstLimitUpSize == "KB" && burstThresholdUpSize == "KB") {  //first check if both are kb

                if (burstThresholdUp > burstLimitUp) {

                    showAlert('red', 'Alert', 'Burst Threshold Up is Larger Than Burst Limit Up');
                    borderRed(['select.burstlimitup', 'select.burstthdup'], '#CE5454');
                    $('div.bsubmit').hide();

                } else {

                    borderRed(['select.burstlimitup', 'select.burstthdup'], '#DDE2E8');
                    $('div.bsubmit').show();
                }

            } else if (burstLimitUpSize == "MB" && burstThresholdUpSize == "MB") { //first check if both are mb

                if (burstThresholdUp > burstLimitUp) {

                    showAlert('red', 'Alert', 'Burst Threshold Up is Larger Than Burst Limit Up');
                    borderRed(['select.burstlimitup', 'select.burstthdup'], '#CE5454');
                    $('div.bsubmit').hide();

                } else {

                    borderRed(['select.burstlimitup', 'select.burstthdup'], '#DDE2E8');
                    $('div.bsubmit').show();

                }

            } else if (burstLimitUpSize == "KB" && burstThresholdUpSize != "KB") { //if not kb then alert

                showAlert('red', 'Alert', 'Burst Threshold Up is Larger Than Burst Limit Up');
                borderRed(['select.burstlimitup', 'select.burstthdup'], '#CE5454');
                $('div.bsubmit').hide();

            }
        }


        if (burstLimitUp < maxLimitUp) { // if maxup larger than burst then error

            borderRed(['select.burstlimitup', 'select.maxup'], '#CE5454');
            $('div.bsubmit').hide();

        } else {

            borderRed(['select.burstlimitup', 'select.maxup'], '#DDE2E8');
            $('div.bsubmit').show();

        }

        /**********************************************************************/


        if (burstlimitup != '') {
            $('div.bldown').show();
        } else {
            $('div.bldown').hide();
            $('div.btup').hide();
            $('div.btdown').hide();
            $('div.btimeup').hide();
            $('div.btimedown').hide();
            $('div.bsubmit').hide();
        }

    });

    /**************************************************/
    /**************************************************/

    $(document).on('change keyup paste', 'select.burstlimitdown', function () {

        var maxdown = $('select.maxdown').val();
        var burstlimitdown = $('select.burstlimitdown').val();
        var burstthddown = $('select.burstthddown').val();

        var maxLimitdown = parseInt(maxdown.slice(0, -1));
        var burstLimitdown = parseInt(burstlimitdown.slice(0, -1));
        var burstThresholddown = parseInt(burstthddown.slice(0, -1));

        if (maxLimitdown > 200) {
            var maxLimitdownSize = 'KB';
        } else {
            var maxLimitdownSize = 'MB';
        }

        if (burstLimitdown > 200) {
            var burstLimitdownSize = 'KB';
        } else {
            var burstLimitdownSize = 'MB';
        }

        if (burstThresholddown > 200) {
            var burstThresholddownSize = 'KB';
        } else {
            var burstThresholddownSize = 'MB';
        }


        /**************************** Checking Maxdown & Burst down **********************/

        if (maxLimitdownSize == "KB" && burstLimitdownSize == "KB") {  //first check if both are kb

            if (burstLimitdown < maxLimitdown) { // if maxdown larger than burst then error

                showAlert('red', 'Alert', 'Burst down is Lower Than Max down');
                borderRed(['select.burstlimitdown', 'select.maxdown'], '#CE5454');
                $('div.bsubmit').hide();

            } else {

                borderRed(['select.burstlimitdown', 'select.maxdown'], '#DDE2E8');
                $('div.bsubmit').show();
            }

        } else if (maxLimitdownSize == "MB" && burstLimitdownSize == "MB") { //first check if both are mb

            if (burstLimitdown < maxLimitdown) { // if maxdown larger than burst then error
                showAlert('red', 'Alert', 'Burst down is Lower Than Max down');
                borderRed(['select.burstlimitdown', 'select.maxdown'], '#CE5454');
                $('div.bsubmit').hide();
            } else {

                borderRed(['select.burstlimitdown', 'select.maxdown'], '#DDE2E8');
                $('div.bsubmit').show();
            }

        } else if (maxLimitdownSize == "KB" && burstLimitdownSize != "KB") { //if not kb then alert
            if (maxLimitdown > 200 && burstLimitdown < 200) { // if maxup larger than burst then error

                borderRed(['select.burstlimitdown', 'select.maxdown'], '#DDE2E8');
                $('div.bsubmit').show();

            } else {
                showAlert('red', 'Alert', 'Burst down is Lower Than Max down');
                borderRed(['select.burstlimitdown', 'select.maxdown'], '#CE5454');
                $('div.bsubmit').hide();
            }
        }


        /************************ Burst Limit down & Threshold down*******************************************/

        if (burstthddown != '') {

            if (burstLimitdownSize == "KB" && burstThresholddownSize == "KB") {  //first check if both are kb

                if (burstThresholddown > burstLimitdown) {

                    showAlert('red', 'Alert', 'Burst Threshold down is Larger Than Burst Limit down');
                    borderRed(['select.burstlimitdown', 'select.burstthddown'], '#CE5454');
                    $('div.bsubmit').hide();

                } else {
                    borderRed(['select.burstlimitdown', 'select.burstthddown'], '#DDE2E8');
                    $('div.bsubmit').show();
                }

            } else if (burstLimitdownSize == "MB" && burstThresholddownSize == "MB") { //first check if both are mb

                if (burstThresholddown > burstLimitdown) {
                    showAlert('red', 'Alert', 'Burst Threshold down is Larger Than Burst Limit down');
                    borderRed(['select.burstlimitdown', 'select.burstthddown'], '#CE5454');
                    $('div.bsubmit').hide();
                } else {
                    borderRed(['select.burstlimitdown', 'select.burstthddown'], '#DDE2E8');
                    $('div.bsubmit').show();
                }

            } else if (burstLimitdownSize == "KB" && burstThresholddownSize != "KB") { //if not kb then alert
                showAlert('red', 'Alert', 'Burst Threshold down is Larger Than Burst Limit down');
                borderRed(['select.burstlimitdown', 'select.burstthddown'], '#CE5454');
                $('div.bsubmit').hide();
            }
        }


        if (burstLimitdown < maxLimitdown) { // if maxdown larger than burst then error

            showAlert('red', 'Alert', 'Burst Threshold down is Larger Than Burst Limit down');
            borderRed(['select.burstlimitdown', 'select.maxdown'], '#CE5454');
            $('div.bsubmit').hide();

        } else {

            borderRed(['select.burstlimitdown', 'select.maxdown'], '#DDE2E8');
            $('div.bsubmit').show();

        }

        /**********************************************************************/


        if (burstlimitdown != '') {
            $('div.btup').show();
        } else {
            $('div.btup').hide();
            $('div.btdown').hide();
            $('div.btimeup').hide();
            $('div.btimedown').hide();
            $('div.bsubmit').hide();
        }

    });

    /**********************************************************************/
    /**********************************************************************/

    $(document).on('change keyup paste', 'select.burstthdup', function () {

        var burstlimitup = $('select.burstlimitup').val();
        var burstthdup = $('select.burstthdup').val();

        var burstLimitUp = parseInt(burstlimitup.slice(0, -1));
        var burstThresholdUp = parseInt(burstthdup.slice(0, -1));

        if (burstLimitUp > 200) {
            var burstLimitUpSize = 'KB';
        } else {
            var burstLimitUpSize = 'MB';
        }

        if (burstThresholdUp > 200) {
            var burstThresholdUpSize = 'KB';
        } else {
            var burstThresholdUpSize = 'MB';
        }

        if (burstLimitUpSize == "KB" && burstThresholdUpSize == "KB") {  //first check if both are kb

            if (burstThresholdUp > burstLimitUp) {

                showAlert('red', 'Alert', 'Burst Threshold Up is Larger Than Burst Limit Up');
                borderRed(['select.burstlimitup', 'select.burstthdup'], '#CE5454');
                $('div.bsubmit').hide();

            } else {

                borderRed(['select.burstlimitup', 'select.burstthdup'], '#DDE2E8');
                $('div.bsubmit').show();

            }

        } else if (burstLimitUpSize == "MB" && burstThresholdUpSize == "MB") { //first check if both are mb

            if (burstThresholdUp > burstLimitUp) {

                showAlert('red', 'Alert', 'Burst Threshold Up is Larger Than Burst Limit Up');
                borderRed(['select.burstlimitup', 'select.burstthdup'], '#CE5454');
                $('div.bsubmit').hide();

            } else {

                borderRed(['select.burstlimitup', 'select.burstthdup'], '#DDE2E8');
                $('div.bsubmit').show();

            }

        } else if (burstLimitUpSize == "KB" && burstThresholdUpSize != "KB") { //if not kb then alert

            showAlert('red', 'Alert', 'Burst Threshold Up is Larger Than Burst Limit Up');
            borderRed(['select.burstlimitup', 'select.burstthdup'], '#CE5454');
            $('div.bsubmit').hide();

        }

        if (burstthdup != '') {
            $('div.btdown').show();
        } else {
            $('div.btdown').hide();
            $('div.btimeup').hide();
            $('div.btimedown').hide();
            $('div.bsubmit').hide();
        }

    });


    /****************************************************************************/
    /****************************************************************************/


    $(document).on('change keyup paste', 'select.burstthddown', function () {


        var burstlimitdown = $('select.burstlimitdown').val();
        var burstthddown = $('select.burstthddown').val();

        var burstLimitdown = parseInt(burstlimitdown.slice(0, -1));
        var burstThresholddown = parseInt(burstthddown.slice(0, -1));

        if (burstLimitdown > 200) {
            var burstLimitdownSize = 'KB';
        } else {
            var burstLimitdownSize = 'MB';
        }

        if (burstThresholddown > 200) {
            var burstThresholddownSize = 'KB';
        } else {
            var burstThresholddownSize = 'MB';
        }

        if (burstLimitdownSize == "KB" && burstThresholddownSize == "KB") {  //first check if both are kb

            if (burstThresholddown > burstLimitdown) {

                showAlert('red', 'Alert', 'Burst Threshold Down is Larger Than Burst Limit Down');
                borderRed(['select.burstlimitdown', 'select.burstthddown'], '#CE5454');
                $('div.bsubmit').hide();

            } else {

                borderRed(['select.burstlimitdown', 'select.burstthddown'], '#DDE2E8');
                $('div.bsubmit').show();

            }

        } else if (burstLimitdownSize == "MB" && burstThresholddownSize == "MB") { //first check if both are mb

            if (burstThresholddown > burstLimitdown) {

                showAlert('red', 'Alert', 'Burst Threshold Down is Larger Than Burst Limit Down');
                borderRed(['select.burstlimitdown', 'select.burstthddown'], '#CE5454');
                $('div.bsubmit').hide();

            } else {

                borderRed(['select.burstlimitdown', 'select.burstthddown'], '#DDE2E8');
                $('div.bsubmit').show();

            }

        } else if (burstLimitdownSize == "KB" && burstThresholddownSize != "KB") { //if not kb then alert

            showAlert('red', 'Alert', 'Burst Threshold Down is Larger Than Burst Limit Down');
            borderRed(['select.burstlimitdown', 'select.burstthddown'], '#CE5454');
            $('div.bsubmit').hide();
        }

        if (burstthddown != '') {
            $('div.btimeup').show();
        } else {
            $('div.btimeup').hide();
            $('div.btimedown').hide();
            $('div.bsubmit').hide();
        }

    });


    /*********************************************************/
    /*********************************************************/


    $(document).on('change keyup paste', 'select.bursttimeup', function () {

        var bursttimeup = $('select.bursttimeup').val();
        if (bursttimeup != '') {
            $('div.btimedown').show();
        } else {
            $('div.btimedown').hide();
            $('div.bsubmit').hide();
        }

    });

    $(document).on('change keyup paste', 'select.bursttimedown', function () {

        var bursttimedown = $('select.bursttimedown').val();
        if (bursttimedown != '') {
            $('div.bsubmit').show();
        } else {
            $('div.bsubmit').hide();
        }

    });


    /*********************************************************/
    /******************* End of BW Policy Page *************/
    /*********************************************************/


    /*********************************************************/
    /******************* Start of Add Package Page *************/
    /*********************************************************/


    $(document).on('change keyup', 'select.usertype', function () {

        var usertype = $('select.usertype').val();
        if (usertype != 0) {

            $('div.pricediv').show();
            $('div.durationdiv').show();
            $('div.dataqtdiv').show();
            $('div.freevolumediv').hide();
            $('div.datavolumediv').hide();
            $('div.secondarypackdiv').hide();
            $('div.packstrdatediv').show();
            $('div.packenddatediv').show();

            $('.pricefield').attr("required", true);
            $('.volume').attr("required", true);
            $('.duration').attr("required", true);
            $('.dataqt').attr("required", true);
            $('.secondarypack').attr("required", true);
            $('.freevolume').attr("required", true);
            $('.packstartdate').attr("required", true);
            $('.packenddate').attr("required", true);
            $('.freevolumestrtime').attr("required", true);
            $('.freevolumeendtime').attr("required", true);

        } else {
            $('div.pricediv').hide();
            $('div.datavolumediv').hide();
            $('div.durationdiv').hide();
            $('div.dataqtdiv').hide();
            $('div.secondarypackdiv').hide();
            $('div.freevolumediv').hide();
            $('div.packstrdatediv').hide();
            $('div.packenddatediv').hide();

            $('.pricefield').attr("required", false);
            $('.volume').attr("required", false);
            $('.duration').attr("required", false);
            $('.dataqt').attr("required", false);
            $('.secondarypack').attr("required", false);
            $('.freevolume').attr("required", false);
            $('.packstartdate').attr("required", false);
            $('.packenddate').attr("required", false);
            $('.freevolumestrtime').attr("required", false);
            $('.freevolumeendtime').attr("required", false);
        }

    });

    $(document).on('change keyup', 'select.dataqt', function () {
        var dataqt = $('select.dataqt').val();
        if (dataqt == 1) {

            $('div.dataqtvoldiv').show();
            $('div.fupqtdiv').show();

            $('.dataqtvol').attr("required", true);
            $('.fupqt').attr("required", true);
            $('.fupqtbw').attr("required", true);

        } else if (dataqt == 0) {

            $('.dataqtvol').attr("required", false);
            $('.fupqt').attr("required", false);
            $('.fupqtbw').attr("required", false);

            $('div.dataqtvoldiv').hide();
            $('div.fupqtdiv').hide();

        }
    });

    $(document).on('change keyup', 'select.fupqt', function () {
        var fupqt = $('select.fupqt').val();
        if (fupqt == 1) {

            $('div.fupqtvoldiv').show();
            $('div.fupqtbwlimitdiv').show();
            $('.fupqtvol').attr("required", true);
            $('.fupqtbwlimit').attr("required", true);

        } else if (fupqt == 0) {

            $('.fupqtvol').attr("required", false);
            $('.fupqtbwlimit').attr("required", false);

            $('div.fupqtvoldiv').hide();
            $('div.fupqtbwlimitdiv').hide();

        }
    });

    $(document).on('change keyup', 'select.sessionqt', function () {
        var sessionqt = $('select.sessionqt').val();
        if (sessionqt == 1) {
            $('div.sessiontimediv').show();
            $('.sessiontime').attr("required", true);
        } else if (sessionqt == 0) {
            $('.sessiontime').attr("required", false);
            $('div.sessiontimediv').hide();
        }
    });

    $(document).on('click', 'span.dbplusbtn', function () {
        $(this).html(function (i, html) {
            return html === '<i class="mt-10 fas fa-minus-circle"></i>' ? '<i class="mt-10 fas fa-plus-circle"></i>' : '<i class="mt-10 fas fa-minus-circle"></i>';
        });
        $(this).closest('.item.form-group').next().toggle();
        var inputReq = $(this).closest('.item.form-group').next().find('input');
        $.each(inputReq, function (index, inputval) {
            if (inputval.hasAttribute('required')) {
                $(inputval).attr('required', false);
            } else {
                $(inputval).attr('required', true);
            }
        });

        var selectReq = $(this).closest('.item.form-group').next().find('select');
        $.each(selectReq, function (index, selectval) {
            if (selectval.hasAttribute('required')) {
                $(selectval).attr('required', false);
            } else {
                $(selectval).attr('required', true);
            }
        });

    });

    $(document).on('change keyup', 'select.dynamicbw', function () {
        var dynamicbw = $('select.dynamicbw').val();
        if (dynamicbw == 1) {
            $('div.1dynamicbwdiv').show();
            $('select.dynamicbwday1').attr("required", true);
            $('input.dbstarttime1').attr("required", true);
            $('input.dbendtime1').attr("required", true);
            $('input.dblimit1').attr("required", true);
        } else {
            var dbdivs = $(this).closest('.add_packages_modal').find('.item.form-group.dbdivs');
            $.each(dbdivs, function (index, dbdiv) {
                $(dbdiv).hide();
                $(dbdiv).find('select').attr('required', false);
                $(dbdiv).find('input').attr('required', false);
            });
        }

    });

    /*********************************************************/
    /******************* End of Add Package  Page *************/
    /*********************************************************/


    /*********************************************************/
    /******************* Start of User Adding Page *************/
    /*********************************************************/


    // $(document).on('change paste', 'input.mobile', function () {
    //
    //     var mobile = $('input.mobile').val();
    //     if (mobile !='' ) {
    //         var mobileLength = mobile.length;
    //         if(mobileLength < 13 || mobileLength > 13 ){
    //             $('input.mobile').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
    //             $(":submit").attr("disabled", true);
    //             showAlert('red', 'Alert!', 'Mobile number is not valid, Please enter with country code. Ex: 88xxxxxxxxxxx' );
    //             if(mobile.substr(0, 2) != 88){
    //                 $('input.mobile').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
    //                 $(":submit").attr("disabled", true);
    //                 showAlert('red', 'Alert!', 'Country code is not valid. Ex: 88xxxxxxxxxxx' );
    //             }
    //         }else{
    //             $('input.mobile').attr('style', 'border: 1px solid #DDE2E8; box-shadow: 0 0 4px -2px #DDE2E8;');
    //             $(":submit").attr("disabled", false);
    //         }
    //     }else{
    //         $('input.mobile').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
    //         $(":submit").attr("disabled", false);
    //     }
    //
    // });




    //    $(document).on('change', 'select.subarea', function () {
    ////        var city = $('select.subarea').val();
    ////        if(city!=''){
    ////            $('.citydiv').show();
    ////        }else{
    ////            $('.citydiv').hide();
    ////        }
    //    });


    /*********************************************************/
    /******************* End of User Adding Page *************/
    /*********************************************************/

    /*********************************************************/
    /******************* Start of Login/Tracking Details Page *************/
    /*********************************************************/

    $(".login-page-username").chosen();
    $(document).on('change', 'select.datatype', function () {
        var datatype = $('select.datatype').val();
        if (datatype == 'username') {
            $('div.usernameDiv').show();
            $('div.ipDiv').hide();
            $('div.macDiv').hide();
            $('div.customtextDiv').hide();
        } else if (datatype == 'framedipaddress') {
            $('div.ipDiv').show();
            $('div.usernameDiv').hide();
            $('div.macDiv').hide();
            $('div.customtextDiv').hide();
        } else if (datatype == 'callingstationid') {
            $('div.macDiv').show();
            $('div.ipDiv').hide();
            $('div.usernameDiv').hide();
            $('div.customtextDiv').hide();
        } else if (datatype == 'customtext') {
            $('div.customtextDiv').show();
            $('div.macDiv').hide();
            $('div.ipDiv').hide();
            $('div.usernameDiv').hide();
        }
    });

    $(document).on('change', 'select.login-page-username', function () {
        var username = $('select.login-page-username').val();
        if (username != '') {
            $('div.datefromdiv').show();
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();

        } else {
            $('div.datefromdiv').hide();
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }
    });


    $(document).on('change keyup paste', 'input.ip', function () {
        var ip = $('input.ip').val();
        if (ip != '') {
            $('div.datefromdiv').show();
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();

        } else {
            $('div.datefromdiv').hide();
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }
    });


    $(document).on('change keyup paste', 'input.mac', function () {
        var mac = $('input.mac').val();
        if (mac != '') {
            $('div.datefromdiv').show();
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();

        } else {
            $('div.datefromdiv').hide();
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }
    });


    $(document).on('change', 'input.datefrom', function () {
        var datefrom = $('input.datefrom').val();
        if (datefrom != '') {
            $('div.datetodiv').show();
            $('div.submitdiv').hide();

        } else {
            $('div.datetodiv').hide();
            $('div.submitdiv').hide();
        }
    });

    $(document).on('change', 'input.dateto', function () {
        var dateto = $('input.dateto').val();
        if (dateto != '') {
            $('div.submitdiv').show();
        } else {
            $('div.submitdiv').hide();
        }
    });

    /*********************************************************/
    /******************* End of Add Payment Page *************/
    /*********************************************************/

    /*********************************************************/
    /******************* View User Profile Page **************/
    /*********************************************************/
    $(".viewUserProfileUsername").chosen();
    /*********************************************************/
    /******************* End View User Profile *************/
    /*********************************************************/


    // /** ******  left menu  *********************** **/
    // $('a#menu_toggle').on('click', function () {
    //     $('.leftSideMenu').hide();
    //     $('.rightSideWrapper').attr('style', 'width:100%');
    //     $('a#menu_toggle').attr('title', 'Double Click To Open');
    // });

    // $(document).on('dblclick', 'a#menu_toggle', function () {
    //     $('.leftSideMenu').show();
    //     $('.rightSideWrapper').attr('style', 'width:86%');
    //     $('a#menu_toggle').attr('title', 'Single Click To Open');
    // });


    $('.delete-disable').confirm({
        title: 'Delete',
        content: "Are You Sure?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });


    $('.delete').confirm({
        title: 'Delete',
        content: "Are You Sure?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });

    $('a.enable-user-connection').confirm({
        title: 'Enable User Connection',
        content: "Enable User Connection. Are You Sure?",
        type: 'green',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });

    $('a.disable-user-connection').confirm({
        title: 'Disable User Connection',
        content: "Disable User Connection. Are You Sure?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });

    $('.clean-table-delete').confirm({
        title: 'Erase Data! Are You Sure?',
        content: "All Data Will Be Erase From Table. Please, Take A Backup Before Proceed. It Can't Be Undone. You Are You Sure?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });


    $('a.delete-user').confirm({
        title: 'Delete User',
        content: "All Related Data Of This User Will Be Erase From Database (All Tables). Are You Sure?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });

    //delete invoice warning
    $(document).on('click', 'a.invoice-delete', function (e) {
        e.preventDefault();
        var invoiceDeleteLink = $(this).attr("href");
        // confirm('Amount Will Revert To Respective Resellers & User. Are You Sure?');
        // alert('Delete Invoice');
        $.confirm({
            title: 'Alert! Delete Invoice',
            content: "Amount/Profit Will Revert/Reverse To Respective Resellers & User. Are You Sure?",
            type: 'red',
            typeAnimated: true,
            buttons: {
                Cancel: function () { },
                Ok: function () {
                    location.href = invoiceDeleteLink;
                }
            }
        });
    });



    // token delete confirm
    $('a.delete-tokens').confirm({
        title: 'Delete Expired Tokens',
        content: "Are You Sure of Mass Expired Tokens Deletion?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });

    // auto generate token confirm code
    $('a.generate-token').confirm({
        title: 'Generate Token',
        content: "Mass Token Generation Will Impact On Your Account Balance. Every Token Will Subtract Amount Based On Their Respective Package Price. Are You Sure of Mass Token Generation?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () { }
        }
    });

    // auto renew popup confirm code
    $('a.auto-renew-confirm').confirm({
        title: 'Mass Renew Confirmation!',
        content: "Mass Renew Only Impact On Current Active Users & Activation Type Users (Check Settings). Please, Make Sure Your NAS is Active For API Users, Activation Can't Be Undone. So, Are You Sure Of Mass Activation?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });


    // server restart confirmation
    $('a.serverrestart').confirm({
        title: 'Server Restart Confirmation!',
        content: "Radius Server Will Restart. It Will Disconnect All Active Users. Are You Sure Of Restoration?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });

    // cron restart confirmation
    $('a.cronrestart').confirm({
        title: 'Cron Restart Confirmation!',
        content: "Cron Job Will Restart. Are You Sure Of Restoration?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });

    // tracking restart confirmation
    $('a.trackingserverrestart').confirm({
        title: 'Tracking Server Restart Confirmation!',
        content: "Tracking Server Will Restart. Are You Sure Of Restoration?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });


    // server timezone update confirmation
    $('a.changetimezone').confirm({
        title: 'Server Time Zone Update!',
        content: "Server Time Zone Will Be Updated According To Setting's Time Zone. You Need To Wait A Few Minutes To See The Result. Are You Sure ?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });


    $('.software-update-alert').confirm({
        title: 'Install Latest Update!',
        content: "Please, Take A Backup Before Proceed, It Can't Be Undone. Software & DB Will Be Updated Automatically. Please Make Sure You Have High Speed Internet Connection. Do Not Close The Page During Updating. It Could Be Takes 5 Minutes To 30 Minuntes, Depends On Your Internet Connection. You Are You Sure?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });

    $('.database-update-alert').confirm({
        title: 'Manually Update Database!',
        content: "Please, Take A Backup Before Proceed, It Can't Be Undone. Database Will Be Updated Automatically. It Could Be Takes 1 Minutes To 10 Minuntes. You Are You Sure?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });

    $('.database-backup-alert').confirm({
        title: 'Database Backup!',
        content: "Whole Database Will Be Backup & Download. It Could Be Takes 10 Mins To 1 Hour, Depends On Database Size. So, Please Be Patience For Backup. You Are You Sure?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });

    $('.database-tracking-backup-alert').confirm({
        title: 'Database Backup!',
        content: "Whole Database Will Be Backup & Download. It Could Be Takes 10 Mins To 1 Hour, Depends On Database Size. So, Please Be Patience For Backup. You Are You Sure?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            Cancel: function () { },
            Ok: function () {
                location.href = this.$target.attr('href');
            }
        }
    });



    $(document).on('click', '#print', function () {
        window.print();
    });


    $(document).ready(function () {
        $('body').tooltip({ selector: '[data-toggle="tooltip"]' });
        //$('.bs-tooltip').tooltip();
        //$('[data-toggle=tooltip]').tooltip();
    });

    /***************************************************
     * Checking Password & Confirm Password Match
     *************************************************/
    $(document).on('shown.bs.modal', function () {
        $('.modal').on('change paste', 'input.conpassword', function () {
            var password = $('.password').val();
            var conpassword = $('.conpassword').val();
            if (password !== conpassword) {
                $(":submit").attr("disabled", true);
                $('.password').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
                $('.conpassword').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
                showAlert('red', 'Alert', 'Password does not match with cofirm password');
            } else if (password == conpassword) {
                $(":submit").attr("disabled", false);
                $('.password').attr('style', 'border: 1px solid #DDE2E8; box-shadow: none;');
                $('.conpassword').attr('style', 'border: 1px solid #DDE2E8; box-shadow: none;');
            }
        });
    });

    $(document).on('shown.bs.modal', function () {
        $('.modal').on('change paste', 'input.password', function () {
            var password = $('.password').val();
            var conpassword = $('.conpassword').val();
            if (conpassword != "" && password !== conpassword) {
                $(":submit").attr("disabled", true);
                $('.password').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
                $('.conpassword').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
                showAlert('red', 'Alert', 'Password does not match with cofirm password');
            } else if (password == conpassword) {
                $(":submit").attr("disabled", false);
                $('.password').attr('style', 'border: 1px solid #DDE2E8; box-shadow: none;');
                $('.conpassword').attr('style', 'border: 1px solid #DDE2E8; box-shadow: none;');
            }
        });
    });

    /************************************************/
    /************************************************/
    /************************************************/


    /**********************************************************
     * Checking Portal Password & Confirm Portal Password Match
     **********************************************************/
    // $(document).on('change paste', 'input.conportalpass', function () {
    //     var portalpassword = $('.portalpass').val();
    //     var conportalpassword = $('.conportalpass').val();
    //     if (portalpassword !== conportalpassword) {
    //         $(":submit").attr("disabled", true);
    //         $('.portalpass').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
    //         $('.conportalpass').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
    //         showAlert('red', 'Alert', 'Portal password does not match with cofirm portal password' );
    //     } else if (portalpassword == conportalpassword) {
    //         $(":submit").attr("disabled", false);
    //         $('.portalpass').attr('style', 'border: 1px solid #DDE2E8; box-shadow: none;');
    //         $('.conportalpass').attr('style', 'border: 1px solid #DDE2E8; box-shadow: none;');
    //     }
    // });


    // $(document).on('change paste', 'input.portalpass', function () {
    //     var portalpassword = $('.portalpass').val();
    //     var conportalpassword = $('.conportalpass').val();
    //     if (conportalpassword != "" && portalpassword !== conportalpassword) {
    //         $(":submit").attr("disabled", true);
    //         $('.portalpass').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
    //         $('.conportalpass').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
    //         showAlert('red', 'Alert', 'Portal password does not match with cofirm portal password' );
    //     } else if (portalpassword == conportalpassword) {
    //         $(":submit").attr("disabled", false);
    //         $('.portalpass').attr('style', 'border: 1px solid #DDE2E8; box-shadow: none;');
    //         $('.conportalpass').attr('style', 'border: 1px solid #DDE2E8; box-shadow: none;');
    //     }
    // });


    $(document).on('change keyup paste', 'input.date1', function () {
        var date1 = $('.date1').val();
        if (date1 != "") {
            $('.date1').attr('style', 'border: 1px solid #DDE2E8; box-shadow: none;');
        } else {
            $('.date1').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
        }
    });

    $(document).on('change keyup paste', 'input.date2', function () {
        var date2 = $('.date2').val();
        if (date2 != "") {
            $('.date2').attr('style', 'border: 1px solid #DDE2E8; box-shadow: none;');
        } else {
            $('.date2').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
        }
    });


    $(document).on('change keyup paste', 'input.date3', function () {
        var date3 = $('.date3').val();
        if (date3 != "") {
            $('.date3').attr('style', 'border: 1px solid #DDE2E8; box-shadow: none;');
        } else {
            $('.date3').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
        }
    });

    $(document).on('change keyup paste', 'input.date4', function () {
        var date4 = $('.date4').val();
        if (date4 != "") {
            $('.date4').attr('style', 'border: 1px solid #DDE2E8; box-shadow: none;');
        } else {
            $('.date4').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
        }
    });

    /********** Show Pass On Click On Pass Button ************/
    $(document).on('click', '.showpass', function () {
        $('.showPasswordDiv').toggle();
    });

    /***********************************************************************/
    /***********************************************************************/
    /***********************************************************************/

    $('.date').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('.dayPicker').datepicker({
        format: 'd',
        startView: 0
    });

    $('.dateYear').datepicker({
        format: 'yyyy',
        startView: 1
    });

    $('.dateMonth').datepicker({
        format: 'yyyy-mm',
        startView: 1
    });

    $('.timepicker').timepicker({
        timeFormat: 'HH:mm:ss',
        interval: 60,
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    function showAlert(color, title, content) {
        $.alert({
            title: title,
            type: color,
            animation: 'top',
            content: content
        });
    }


    function showConfirm(color, title, content) {

        $.confirm({
            title: title,
            content: content,
            buttons: {
                confirm: function () {
                    $.alert('Confirmed!');
                },
                cancel: function () {
                    $.alert('Canceled!');
                },
                somethingElse: {
                    text: 'Something else',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function () {
                        $.alert('Something else?');
                    }
                }
            }
        });
    }


    function borderRed(elements, color) {
        $.each(elements, function (index, value) {
            $(value).attr('style', 'border: 1px solid ' + color + '; box-shadow: 0 0 4px -2px ' + color + ';');
        });
    }


    //settings page jquery     

    function smsgateway() {
        var smsgateway = $('#settings select.smsgateway').val();
        if (smsgateway == 1) { //twilio
            $('#settings div.twilio_smsgateway').show();
            $('#settings div.twilio_smsgateway input').attr("required", true);

            $('#settings div.local_smsgateway').hide();
            $('#settings div.local_smsgateway input').attr("required", false);

            $('#settings div.nexmo_smsgateway').hide();
            $('#settings div.nexmo_smsgateway input').attr("required", false);
        } else if (smsgateway == 2) { //nexmo
            $('#settings div.twilio_smsgateway').hide();
            $('#settings div.twilio_smsgateway input').attr("required", false);

            $('#settings div.local_smsgateway').hide();
            $('#settings div.local_smsgateway input').attr("required", false);

            $('#settings div.nexmo_smsgateway').show();
            $('#settings div.nexmo_smsgateway input').attr("required", true);
        } else {
            $('#settings div.twilio_smsgateway').hide();
            $('#settings div.twilio_smsgateway input').attr("required", false);

            $('#settings div.local_smsgateway').show();
            $('#settings div.local_smsgateway input').attr("required", true);

            $('#settings div.nexmo_smsgateway').hide();
            $('#settings div.nexmo_smsgateway input').attr("required", false);
        }
    }

    smsgateway(); //call for auto hide or show
    $('#settings select.smsgateway').on('change', function () {
        smsgateway();
    });



    //change role js
    $(document).on('change', '.role-change-modal select[name="role_type"]', function () {
        var role_type = $('.role-change-modal select[name="role_type"]').val();
        console.log(role_type);
        if (role_type == 11) { //franchise
            //hide all
            $('.role-change-modal .franchise_list').hide();
            $('.role-change-modal .dealer_list').hide();
        } else if (role_type == 12) { //dealer
            //show franchise list
            $('.role-change-modal .franchise_list').show();
            $('.role-change-modal .dealer_list').hide();
        } else if (role_type == 13) { //subdealer
            //show dealer list
            $('.role-change-modal .franchise_list').hide();
            $('.role-change-modal .dealer_list').show();
        } else {
            $('.role-change-modal .franchise_list').hide();
            $('.role-change-modal .dealer_list').hide();
        }
    });


    //client panel dashboard self activation
    $(document).on('change', '.self_activation_modal select[name="billing_type"]', function () {
        var billing_type = $('.self_activation_modal select[name="billing_type"]').val();
        if (billing_type == 1) { //show new_payment_elements 
            $('.self_activation_modal .new_payment_elements').show();
        } else {
            $('.self_activation_modal .new_payment_elements').hide();
        }
    });

    $(document).on('change', '.self_activation_modal select[name="package"]', function () {
        var package_price = $('.self_activation_modal select[name="package"] option:selected').attr('package-price');
        // console.log(package_price);
        if (package_price !== 'undefined' && package_price !== null) {
            var amount = $('.self_activation_modal input[name="amount"]').val(package_price);
        } else {
            var amount = $('.self_activation_modal input[name="amount"]').val('');
        }
    });



    //3.6.4

    // reseller scripts from here
    //payment modal  
    $(document).on("click", "a.reseller-payment-btn", function () {
        var adminID = $(this).attr("data-adminID");
        $("form .payment_modal input[name='adminID']").val(adminID);
        console.log('Admin ID :' + adminID);
    });

});
