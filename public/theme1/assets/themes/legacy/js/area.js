$(document).ready(function () {

    function initChosen(selector) {
        if ($.fn.chosen) {
            $(selector).chosen({ width: '100%', allow_single_deselect: true });
        }
    }

    initChosen('select.chosen-select, select.chosen');

    function loadCitiesByAjax($targetCitySelect) {
        var $citySelect = $targetCitySelect || $('select.area_city, select.isp_city, select.city, .filter_modal select.filterCity');
        if (!$citySelect.length) return;

        if ($citySelect.find('option[value!=""]').length > 0) return;

        var selectedVal = $citySelect.data('selected');

        var url = (typeof baseurl !== 'undefined' ? baseurl : '/') + 'area/getCitiesByAjax';
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            beforeSend: function () {
                $('div#loading').delay(100).fadeIn();
            },
            success: function (data) {
                $('div#loading').delay(100).fadeOut('slow');
                if (data && data != 0) {
                    $citySelect.empty().append(data);
                    if (selectedVal) {
                        $citySelect.val(selectedVal);
                    }
                }
                if ($.fn.chosen) {
                    $citySelect.trigger('chosen:updated');
                }
            },
            error: function () {
                $('div#loading').delay(100).fadeOut('slow');
                if ($.fn.chosen) {
                    $citySelect.trigger('chosen:updated');
                }
            }
        });
    }

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
            loadCitiesByAjax($('select.area_city'));
            if ($.fn.chosen) {
                $('select.area_city').trigger('chosen:updated');
            }
        }

        if (areaType == 3) {
            cityField.removeClass('hide').show();
            areaField.removeClass('hide').show();
            $('select.area_city').prop('required', true);
            $('select.area_area').prop('required', true);
            loadCitiesByAjax($('select.area_city'));
            if ($.fn.chosen) {
                $('select.area_city').trigger('chosen:updated');
                $('select.area_area').trigger('chosen:updated');
            }
        }
    }

    $(document).on('change', 'select.area_areatype', syncAreaTypeFields);
    syncAreaTypeFields();

    $('.add_areas_modal, .add_isp_modal').on('shown.bs.modal', function () {
        loadCitiesByAjax($(this).find('select.area_city, select.isp_city'));
        if ($.fn.chosen) {
            $(this).find('select.chosen-select, select.chosen, select.area_city, select.isp_city, select.area_area').chosen({ width: '100%' }).trigger('chosen:updated');
        }
    });

    if ($('select.isp_city').length) {
        loadCitiesByAjax($('select.isp_city'));
    }

    // On City select -> load Areas via AJAX
    $(document).on('change', 'select.area_city, select.city, .filter_modal select.filterCity', function () {
        var $citySelect = $(this);
        var cityId = $citySelect.val();
        var isModalForm = $citySelect.hasClass('area_city');
        var isFilterForm = $citySelect.hasClass('filterCity');

        var $targetAreaSelect = isModalForm ? $('select.area_area') : (isFilterForm ? $('.filter_modal select.filterArea') : $('select.area'));
        var $targetSubareaSelect = isFilterForm ? $('.filter_modal select.filterSubarea') : $('select.subarea');
        var $areaDiv = isModalForm ? $('div.area_areadiv') : (isFilterForm ? $('.filter_modal .areaDiv') : $('.areadiv'));
        var $subareaDiv = isFilterForm ? $('.filter_modal .subareaDiv') : $('.subareadiv');

        if (cityId) {
            if ($areaDiv.length && !$citySelect.hasClass('area_city')) {
                $areaDiv.show();
            }
        } else {
            if ($areaDiv.length && !$citySelect.hasClass('area_city')) {
                $areaDiv.hide();
            }
            if ($subareaDiv.length) {
                $subareaDiv.hide();
            }
        }

        $targetAreaSelect.empty().append('<option value="">Select Area</option>');
        if ($targetSubareaSelect.length) {
            $targetSubareaSelect.empty().append('<option value="">Select Subarea</option>');
            if ($.fn.chosen) {
                $targetSubareaSelect.trigger('chosen:updated');
            }
        }

        if (cityId) {
            var url = (typeof baseurl !== 'undefined' ? baseurl : '/') + 'area/getAreaByAjax';
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data: { city: cityId, city_id: cityId },
                beforeSend: function () {
                    $('div#loading').delay(100).fadeIn();
                },
                success: function (data) {
                    $('div#loading').delay(100).fadeOut('slow');
                    if (data && data != 0) {
                        $targetAreaSelect.empty();
                        $targetAreaSelect.append(data);
                        $targetAreaSelect.css({ 'border': '1px solid #8BC34A', 'box-shadow': '0 0 4px -2px #8BC34A' });
                    } else {
                        $targetAreaSelect.css({ 'border': '1px solid #CE5454', 'box-shadow': '0 0 4px -2px #CE5454' });
                    }
                    if ($.fn.chosen) {
                        $targetAreaSelect.trigger('chosen:updated');
                    }
                },
                error: function () {
                    $('div#loading').delay(100).fadeOut('slow');
                    if ($.fn.chosen) {
                        $targetAreaSelect.trigger('chosen:updated');
                    }
                }
            });
        } else {
            if ($.fn.chosen) {
                $targetAreaSelect.trigger('chosen:updated');
            }
        }
    });

    // On Area select -> load Sub-Areas via AJAX
    $(document).on('change', 'select.area_area, select.area, .filter_modal select.filterArea', function () {
        var $areaSelect = $(this);
        var areaId = $areaSelect.val();
        var isFilterForm = $areaSelect.hasClass('filterArea');

        var $targetSubareaSelect = isFilterForm ? $('.filter_modal select.filterSubarea') : $('select.subarea');
        var $subareaDiv = isFilterForm ? $('.filter_modal .subareaDiv') : $('.subareadiv');

        if (areaId) {
            if ($subareaDiv.length) {
                $subareaDiv.show();
            }
        } else {
            if ($subareaDiv.length) {
                $subareaDiv.hide();
            }
        }

        if ($targetSubareaSelect.length) {
            $targetSubareaSelect.empty().append('<option value="">Select Subarea</option>');

            if (areaId) {
                var url = (typeof baseurl !== 'undefined' ? baseurl : '/') + 'area/getSubAreaByAjax';
                $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'json',
                    data: { area: areaId, area_id: areaId },
                    beforeSend: function () {
                        $('div#loading').delay(100).fadeIn();
                    },
                    success: function (data) {
                        $('div#loading').delay(100).fadeOut('slow');
                        if (data && data != 0) {
                            $targetSubareaSelect.empty();
                            $targetSubareaSelect.append(data);
                            $targetSubareaSelect.css({ 'border': '1px solid #8BC34A', 'box-shadow': '0 0 4px -2px #8BC34A' });
                        } else {
                            $targetSubareaSelect.css({ 'border': '1px solid #CE5454', 'box-shadow': '0 0 4px -2px #CE5454' });
                        }
                        if ($.fn.chosen) {
                            $targetSubareaSelect.trigger('chosen:updated');
                        }
                    },
                    error: function () {
                        $('div#loading').delay(100).fadeOut('slow');
                        if ($.fn.chosen) {
                            $targetSubareaSelect.trigger('chosen:updated');
                        }
                    }
                });
            } else {
                if ($.fn.chosen) {
                    $targetSubareaSelect.trigger('chosen:updated');
                }
            }
        }
    });

    // DataTable for Area module
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

});
