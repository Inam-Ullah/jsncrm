$(document).ready(function () {

    function syncAreaTypeFields() {
        var areaType = $('select.area_areatype').val();
        var cityField = $('div.area_citydiv');
        var areaField = $('div.area_areadiv');

        cityField.addClass('hide').hide();
        areaField.addClass('hide').hide();
        $('select.area_city').prop('required', false);
        $('select.area_area').prop('required', false);

        if (areaType == 2) {
            cityField.removeClass('hide').show();
            $('select.area_city').prop('required', true);
        }

        if (areaType == 3) {
            cityField.removeClass('hide').show();
            areaField.removeClass('hide').show();
            $('select.area_city').prop('required', true);
            $('select.area_area').prop('required', true);
            filterAreaOptions();
        }
    }

    function filterAreaOptions() {
        var cityId = $('select.area_city').val();
        var areaSelect = $('select.area_area');

        areaSelect.find('option').each(function () {
            var option = $(this);
            var optionCityId = option.data('city-id');

            if (!option.val() || optionCityId == cityId) {
                option.prop('disabled', false).show();
            } else {
                option.prop('disabled', true).hide();

                if (option.is(':selected')) {
                    areaSelect.val('');
                }
            }
        });
    }

    $(document).on('change', 'select.area_areatype', syncAreaTypeFields);
    $(document).on('change', 'select.area_city', filterAreaOptions);
    syncAreaTypeFields();

    var areaTable = $('.dtAreas');

    if (areaTable.length && $.fn.DataTable) {
        areaTable.DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: areaTable.data('url'),
                type: 'POST'
            },
            dom: 'lfBrtip',
            searching: false,
            info: true,
            responsive: true,
            stateSave: true,
            fixedHeader: true,
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
                    titleAttr: 'Copy',
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
                },
                {
                    extend: 'colvis',
                    text: '<i class="fas fa-eye-slash"></i> View',
                    titleAttr: 'Visibility',
                    collectionLayout: 'fixed two-column'
                }
            ],
            drawCallback: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    }

    $(document).on('click', '.dtAreas a.area-delete', function (event) {
        event.preventDefault();
        var deleteUrl = $(this).attr('href');

        $.confirm({
            title: 'Delete',
            content: 'Are You Sure?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                Cancel: function () {},
                Ok: function () {
                    window.location.href = deleteUrl;
                }
            }
        });
    });


    //1st one for on same page if two are needs 
    //on select city show area
    $(document).on('change', 'select.city', function () {
        var city = $('select.city').val();
        if (city != '') {
            $('.areadiv').show();
        } else {
            $('.areadiv').hide();
            $('.subareadiv').hide();
        }

        var url = baseurl + 'admin_portal/user/user/getAreaByAjax/';
        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: { "city": city },
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data != 0) {
                    $('select.area').children('option').remove();
                    $('select.area').prepend(data);
                    $('select.area').attr('style', 'border: 1px solid #8BC34A; box-shadow: 0 0 4px -2px #8BC34A;');
                } else {
                    $('select.area').children('option').remove();
                    $('select.area').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
                }
            }
        });

    });

    //on select area show subarea
    $(document).on('change', 'select.area', function () {
        var area = $('select.area').val();
        if (area != '') {
            $('.subareadiv').show();
        } else {
            $('.subareadiv').hide();
        }

        var url = baseurl + 'admin_portal/user/user/getSubAreaByAjax/';
        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: { "area": area },
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data != 0) {
                    $('select.subarea').children('option').remove();
                    $('select.subarea').prepend(data);
                    $('select.subarea').attr('style', 'border: 1px solid #8BC34A; box-shadow: 0 0 4px -2px #8BC34A;');
                }
            }
        });
    });
    
    
    //for 2nd area fields in same page if there are multiple area fields
    //on select city show area
    $(document).on('change', '.filter_modal select.filterCity', function () {
        var city = $('.filter_modal select.filterCity').val();
        if (city != '') {
            $('.filter_modal .areaDiv').show();
        } else {
            $('.filter_modal .areaDiv').hide();
            $('.filter_modal .subareaDiv').hide();
        }

        var url = baseurl + 'admin_portal/user/user/getAreaByAjax/';
        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: { "city": city },
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data != 0) {
                    $('.filter_modal select.filterArea').children('option').remove();
                    $('.filter_modal select.filterArea').prepend(data);
                    $('.filter_modal select.filterArea').attr('style', 'border: 1px solid #8BC34A; box-shadow: 0 0 4px -2px #8BC34A;');
                } else {
                    $('.filter_modal select.filterArea').children('option').remove();
                    $('.filter_modal select.filterArea').attr('style', 'border: 1px solid #CE5454; box-shadow: 0 0 4px -2px #CE5454;');
                }
            }
        });

    });

    //on select area show subarea
    $(document).on('change', '.filter_modal select.filterArea', function () {
        var area = $('.filter_modal select.filterArea').val();
        if (area != '') {
            $('.filter_modal .subareaDiv').show();
        } else {
            $('.filter_modal .subareaDiv').hide();
        }

        var url = baseurl + 'admin_portal/user/user/getSubAreaByAjax/';
        jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: { "area": area },
            async: true,
            beforeSend: function () {
                $("div#loading").delay(100).fadeIn();
            },
            success: function (data) {
                $("div#loading").delay(100).fadeOut("slow");
                if (data != 0) {
                    $('.filter_modal select.filterSubarea').children('option').remove();
                    $('.filter_modal select.filterSubarea').prepend(data);
                    $('.filter_modal select.filterSubarea').attr('style', 'border: 1px solid #8BC34A; box-shadow: 0 0 4px -2px #8BC34A;');
                }
            }
        });
    });

});
