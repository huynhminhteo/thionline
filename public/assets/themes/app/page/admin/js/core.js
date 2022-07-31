var table_core;
var table_core_element = '.table-core';
var length_table = '15';

$(function () {
    'use strict';

    // load table core
    loadTableCore();

    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $(document).on("click", "#btnRegist", function() {
        refreshModalRegist();
        $("#modal_regist").modal('show');
    });

    $(document).on("click", "#table_core tbody tr td.action", function () {
        var id = $(this).parent().data('id');
        var name = $(this).parent().data('name');
        var date = $(this).parent().data('date');

        if (id) {
            refreshModalUpdate();
            $('#modal_update #id_core').val(id);
            $('#modal_update #update_name').val(name);
            $('#modal_update #update_date').val(moment(date).format('DD-MM-YYYY'));
            $("#modal_update").modal('show');
        }
    });

    $(document).on("click", "#table_core tbody tr td:not(.action)", function () {
        var id = $(this).parent().data('id');
        window.location.href = base_admin + "/core/" + id;
    });

    $(document).on("click", "#modal_update #btnDelete", function(e) {
        e.preventDefault();
        Swal.fire({
            text: 'ユーザーを削除しますがよろしいでしょうか', //confrim delete
            showCancelButton: true,
            cancelButtonText: 'いいえ',
            confirmButtonText: 'はい'
        }).then(function(result) {
            if (typeof result.dismiss == 'undefined') {
                run_waitMe('.wait-containter');
                $.ajax({
                    url: base_api + "/core/delete/v1?token="+_token,
                    type: "POST",
                    data: {
                        id: $('#modal_update #id_core').val(),
                        mail: $('#modal_update #text_mail').text()
                    },
                    success: function(response) {
                        run_waitMe('.wait-containter', true);
                        Swal.fire({
                            text: response.msg
                        }).then(function() {
                            run_waitMe('.wait-containter');
                            window.location.replace(base_url + '/core');
                        });
                    },
                    error: function(error) {
                        run_waitMe('.wait-containter', true);
                        Swal.fire({
                            text: error.responseJSON.msg
                        });
                    }
                });
            }
        });
    });

    $(document).on("click", "#modal_update #btnChange", function(e) {
        e.preventDefault();
        var form = $('#form_update');
        form.parsley().validate();
        if (form.parsley().isValid()) {
            run_waitMe('.wait-containter');
            $.ajax({
                url: base_api + "/core/update/v1?token="+_token,
                type: "POST",
                data: $('#form_update').serialize(),
                success: function(response) {
                    run_waitMe('.wait-containter', true);
                    Swal.fire({
                        text: response.msg
                    }).then(function() {
                        run_waitMe('.wait-containter');
                        window.location.replace(base_url + '/core');
                    });
                },
                error: function(error) {
                    run_waitMe('.wait-containter', true);
                    Swal.fire({
                        text: error.responseJSON.msg
                    });
                }
            });
        }
    });

    $(document).on("submit", "#form_regist", function(e) {
        e.preventDefault();
        run_waitMe('.wait-containter');
        $.ajax({
            url: base_api + "/core/operator/add/v1?token="+_token,
            type: "POST",
            data: $('#form_regist').serialize(),
            success: function(response) {
                run_waitMe('.wait-containter', true);
                Swal.fire({
                    text: response.msg
                }).then(function() {
                    run_waitMe('.wait-containter');
                    window.location.replace(base_url + '/core');
                });
            },
            error: function(error) {
                run_waitMe('.wait-containter', true);
                Swal.fire({
                    text: error.responseJSON.msg
                });
            }
        });
    });
});

var loadTableCore = function() {
    run_waitMe('.wait-containter');
    if ($.fn.DataTable.isDataTable(table_core_element)) {
        $(table_core_element).DataTable().destroy();
        $('.table-core tbody').empty();
    }

    var urlRequest = base_api + "/core/v1?token="+_token;

    table_core = $(table_core_element).DataTable({
        "pageLength": length_table,
        "autoWidth": false,
        "serverSide": true,
        "ajax": urlRequest,
        "searching": false,
        "bSort" : false,
        "bInfo": false,
        "pagingType": "numbers",
        "language": {
            "paginate": {
                "first": '最初',
                "previous": '前',
                "next": '次',
                "last": '最終',
            },
            "lengthMenu": "_MENU_",
            "emptyTable": 'テーブル内のデータなし',
            "zeroRecords": "Không có đề thi nào",
        },
        "lengthMenu": [[15, 50, 100], [15 + '件表示', 50 + '件表示', 100 + '件表示']],
        "sLengthSelect": "select2",
        "responsive": true,
        "ordering": false,
        "columns": [
            {
                "data": "id",
            },
            {
                "data": "name",
            },
            {
                "data": "date",
            },
            {
                "data": "action",
            }
        ],
        "columnDefs": [
            {
                targets: [0, 2],
                class: 'text-center multi-line',
            },
            {
                targets: [1],
                class: 'multi-line',
            },
            {
                targets: [3],
                class: 'text-center multi-line action',
            },
        ],
        "initComplete": function (settings, json) {
            $('.dataTables_length select').val(length_table).trigger('change.select2');
            $('.slim-body .slim-mainpanel .container').addClass('d-block');
            run_waitMe('.wait-containter', true);
        },
        "fnCreatedRow": function (nRow, aData, iDataIndex) {
            $(nRow).attr('data-id', aData.id);
            $(nRow).attr('data-name', aData.name);
            $(nRow).attr('data-date', aData.role);
        }
    }).on('processing.dt', function (e, settings, processing) {
        if (processing) {
            run_waitMe('.wait-containter');
        } else {
            $('.slim-body .slim-mainpanel .container').addClass('d-block');
            run_waitMe('.wait-containter', true);
        }
    }).on( 'draw.dt', function () {
        var PageInfo = $(this).DataTable().page.info();
        table_core.column(0, { page: 'current' }).nodes().each( function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    if ($('.dataTables_length select').length > 0) {
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            dropdownCssClass : 'z-index-900'
        }).on("select2:select", function (e) {
            length_table = $(this).val();
            changePageLength('.table-contract-medical', table_core, length_table);
        });
    }
}

var refreshModalRegist = function() {
    $("#form_regist #regist_name").val('');
    $("#form_regist #regist_mail").val('');
    $("#form_regist #regist_role").val(null).trigger('change');

    $("#form_regist").parsley().reset();
}

var refreshModalUpdate = function() {
    $("#form_update #update_name").val('');
    $("#form_update #update_date").val('');

    $("#form_update").parsley().reset();
}
