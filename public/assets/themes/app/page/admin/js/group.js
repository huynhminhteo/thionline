var table_group;
var table_group_element = '.table-group';
var length_table = '15';

$(function () {
    'use strict';

    // load table group
    loadTableGroup();

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

    $(document).on("click", "#table_group tbody tr td.action", function () {
        var id = $(this).parent().data('id');
        var name = $(this).parent().data('name');
        var date = $(this).parent().data('date');

        if (id) {
            refreshModalUpdate();
            $('#modal_update #id_group').val(id);
            $('#modal_update #update_name').val(name);
            $('#modal_update #update_date').val(moment(date).format('DD-MM-YYYY'));
            $("#modal_update").modal('show');
        }
    });

    $(document).on("click", "#table_group tbody tr td:not(.action)", function () {
        var id = $(this).parent().data('id');
        window.location.href = base_admin + "/group/" + id;
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
                    url: base_api + "/group/delete/v1?token="+_token,
                    type: "POST",
                    data: {
                        id: $('#modal_update #id_group').val(),
                        mail: $('#modal_update #text_mail').text()
                    },
                    success: function(response) {
                        run_waitMe('.wait-containter', true);
                        Swal.fire({
                            text: response.msg
                        }).then(function() {
                            run_waitMe('.wait-containter');
                            window.location.replace(base_url + '/group');
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
                url: base_api + "/group/update/v1?token="+_token,
                type: "POST",
                data: $('#form_update').serialize(),
                success: function(response) {
                    run_waitMe('.wait-containter', true);
                    Swal.fire({
                        text: response.msg
                    }).then(function() {
                        run_waitMe('.wait-containter');
                        window.location.replace(base_url + '/group');
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
            url: base_api + "/group/operator/add/v1?token="+_token,
            type: "POST",
            data: $('#form_regist').serialize(),
            success: function(response) {
                run_waitMe('.wait-containter', true);
                Swal.fire({
                    text: response.msg
                }).then(function() {
                    run_waitMe('.wait-containter');
                    window.location.replace(base_url + '/group');
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

var loadTableGroup = function() {
    run_waitMe('.wait-containter');
    if ($.fn.DataTable.isDataTable(table_group_element)) {
        $(table_group_element).DataTable().destroy();
        $('.table-group tbody').empty();
    }

    var urlRequest = base_api + "/group/v1?token="+_token+"&test_id="+test_id;

    table_group = $(table_group_element).DataTable({
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
                "data": "name",
            },
            {
                "data": "action",
            }
        ],
        "columnDefs": [
            {
                targets: [0],
                class: 'text-center multi-line',
            },
            {
                targets: [1],
                class: 'multi-line',
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
            $(nRow).attr('data-name', aData.name);
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
            changePageLength('.table-contract-medical', table_group, length_table);
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
