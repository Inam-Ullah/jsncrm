$(document).ready(function () {


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