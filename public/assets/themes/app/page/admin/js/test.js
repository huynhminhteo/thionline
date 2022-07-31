var table_test;
var table_test_element = '.table-test';
var length_table = '15';

$(function () {
    'use strict';

    // load table test
    loadTableTest();

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

    $(document).on("click", "#table_test tbody tr td.action", function () {
        var id = $(this).parent().data('id');
        var name = $(this).parent().data('name');
        var date = $(this).parent().data('date');

        if (id) {
            refreshModalUpdate();
            $('#modal_update #id_test').val(id);
            $('#modal_update #update_name').val(name);
            $('#modal_update #update_date').val(moment(date).format('DD-MM-YYYY'));
            $("#modal_update").modal('show');
        }
    });

    $(document).on("click", "#table_test tbody tr td:not(.action)", function () {
        var id = $(this).parent().data('id');
        window.location.href = base_admin + "/test/" + id;
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
                    url: base_api + "/test/delete/v1?token="+_token,
                    type: "POST",
                    data: {
                        id: $('#modal_update #id_test').val(),
                        mail: $('#modal_update #text_mail').text()
                    },
                    success: function(response) {
                        run_waitMe('.wait-containter', true);
                        Swal.fire({
                            text: response.msg
                        }).then(function() {
                            run_waitMe('.wait-containter');
                            window.location.replace(base_url + '/test');
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
                url: base_api + "/test/update/v1?token="+_token,
                type: "POST",
                data: $('#form_update').serialize(),
                success: function(response) {
                    run_waitMe('.wait-containter', true);
                    Swal.fire({
                        text: response.msg
                    }).then(function() {
                        run_waitMe('.wait-containter');
                        window.location.replace(base_url + '/test');
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
            url: base_api + "/test/operator/add/v1?token="+_token,
            type: "POST",
            data: $('#form_regist').serialize(),
            success: function(response) {
                run_waitMe('.wait-containter', true);
                Swal.fire({
                    text: response.msg
                }).then(function() {
                    run_waitMe('.wait-containter');
                    window.location.replace(base_url + '/test');
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

var loadTableTest = function() {
    run_waitMe('.wait-containter');
    if ($.fn.DataTable.isDataTable(table_test_element)) {
        $(table_test_element).DataTable().destroy();
        $('.table-test tbody').empty();
    }

    var urlRequest = base_api + "/test/v1?token="+_token+"&core_id="+core_id;

    table_test = $(table_test_element).DataTable({
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
                "data": "stt",
            },
            {
                "data": "code",
            },
            {
                "data": "action",
            }
        ],
        "columnDefs": [
            {
                targets: [0, 1],
                class: 'text-center multi-line',
            },
            {
                targets: [2],
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
            $(nRow).attr('data-stt', aData.stt);
            $(nRow).attr('data-code', aData.code);
        }
    }).on('processing.dt', function (e, settings, processing) {
        if (processing) {
            run_waitMe('.wait-containter');
        } else {
            $('.slim-body .slim-mainpanel .container').addClass('d-block');
            run_waitMe('.wait-containter', true);
        }
    });

    if ($('.dataTables_length select').length > 0) {
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            dropdownCssClass : 'z-index-900'
        }).on("select2:select", function (e) {
            length_table = $(this).val();
            changePageLength('.table-contract-medical', table_test, length_table);
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
