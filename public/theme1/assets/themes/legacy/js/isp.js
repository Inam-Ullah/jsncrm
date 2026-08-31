$(document).ready(function () {
    if ($('.dtAllIsp').length) {
        $('.dtAllIsp').DataTable({
            dom: 'lBfrtip',
            searching: true,
            info: true,
            stateSave: true,
            fixedHeader: true,
            pageLength: 25,
            lengthMenu: [10, 25, 50, 100, 500, 1000],
            responsive: true,
            buttons: [
                {
                    extend: 'colvis',
                    text: '<i class="fas fa-eye"></i> Column Visibility',
                    className: 'btn-primary'
                }
            ],
            drawCallback: function () {
                if ($.fn.tooltip) {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            }
        });
    }

    $('.add_isp_modal').on('shown.bs.modal', function () {
        if ($.fn.chosen) {
            $(this).find('select.chosen-select, select.chosen').chosen({ width: '100%' }).trigger('chosen:updated');
        }
    });

    $(document).on('click', '.isp-delete', function (e) {
        e.preventDefault();
        var deleteUrl = $(this).attr('href');

        if (typeof $.confirm === 'function') {
            $.confirm({
                title: 'Delete Confirmation',
                content: 'Are you sure you want to delete this ISP record?',
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
        } else if (confirm('Are you sure you want to delete this ISP record?')) {
            window.location.href = deleteUrl;
        }
    });
});
