var table_user;
var table_user_element = '.table-user';

$(function () {
    'use strict';

    // load table user
    loadTableUser();

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

    $(document).on("click", "#table_user tbody tr", function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var role = $(this).data('role');
        var mail = $(this).data('mail');

        if (id) {
            refreshModalUpdate();
            $('#modal_update #id_user').val(id);
            $('#modal_update #update_name').val(name);
            $('#modal_update #update_role').val(role).trigger('change');
            $('#modal_update #text_mail').html(mail);

            if (id == 1 || operator_login_id == id) {
                $("#modal_update #btnDelete").addClass('d-none');
                $('#text_role').html(role == 1 ? '管理者' : '一般');
            } else {
                $('#modal_update #update_role').val(role).trigger('change');
            }

            $("#modal_update").modal('show');
        }
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
                    url: base_api + "/user/delete/v1?token="+_token,
                    type: "POST",
                    data: {
                        id: $('#modal_update #id_user').val(),
                        mail: $('#modal_update #text_mail').text()
                    },
                    success: function(response) {
                        run_waitMe('.wait-containter', true);
                        Swal.fire({
                            text: response.msg
                        }).then(function() {
                            run_waitMe('.wait-containter');
                            window.location.replace(base_url + '/user');
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
                url: base_api + "/user/update/v1?token="+_token,
                type: "POST",
                data: $('#form_update').serialize(),
                success: function(response) {
                    run_waitMe('.wait-containter', true);
                    Swal.fire({
                        text: response.msg
                    }).then(function() {
                        run_waitMe('.wait-containter');
                        window.location.replace(base_url + '/user');
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
            url: base_api + "/user/operator/add/v1?token="+_token,
            type: "POST",
            data: $('#form_regist').serialize(),
            success: function(response) {
                run_waitMe('.wait-containter', true);
                Swal.fire({
                    text: response.msg
                }).then(function() {
                    run_waitMe('.wait-containter');
                    window.location.replace(base_url + '/user');
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

var loadTableUser = function() {
    run_waitMe('.wait-containter');
    if ($.fn.DataTable.isDataTable(table_user_element)) {
        $(table_user_element).DataTable().destroy();
        $('.table-user tbody').empty();
    }

    var urlRequest = base_api + "/user/v1?token="+_token;

    table_user = $(table_user_element).DataTable({
        "scrollY": "70vh",
        "scrollCollapse": true,
        "stateSave": true,
        "autoWidth": false,
        "processing": true,
        // "serverSide": true,
        "ajax": urlRequest,
        "searching": false,
        "bSort" : false,
        "bLengthChange": false,
        "bInfo": false,
        "bFilter": false,
        "bPaginate": false,
        "language": {
            emptyTable: 'テーブル内のデータなし',
            "zeroRecords": "一致する検索結果がありません",
        },
        "columns": [
            {
                "data": "name",
            },
            {
                "data": "role",
                render: function (data, type, row) {
                    return data == 1 ? '管理者' : '一般';
                }
            },
            {
                "data": "mail",
            }
        ],
        "columnDefs": [
            {
                targets: [0, 1, 2],
                class: 'text-center multi-line',
            },
        ],
        "initComplete": function (settings, json) {
            $('.slim-body .slim-mainpanel .container').addClass('d-block');
            run_waitMe('.wait-containter', true);
        },
        "fnCreatedRow": function (nRow, aData, iDataIndex) {
            $(nRow).attr('data-id', aData.id);
            $(nRow).attr('data-name', aData.name);
            $(nRow).attr('data-role', aData.role);
            $(nRow).attr('data-mail', aData.mail);
        }
    }).on('processing.dt', function (e, settings, processing) {
        if (processing) {
            run_waitMe('.wait-containter');
        } else {
            $('.slim-body .slim-mainpanel .container').addClass('d-block');
            run_waitMe('.wait-containter', true);
        }
    });

    $('.dataTables_scrollHead').hide();
}

var refreshModalRegist = function() {
    $("#form_regist #regist_name").val('');
    $("#form_regist #regist_mail").val('');
    $("#form_regist #regist_role").val(null).trigger('change');

    $("#form_regist").parsley().reset();
}

var refreshModalUpdate = function() {
    $("#form_update #update_name").val('');
    $("#form_update #text_mail").html('');
    $("#form_update #btnDelete").removeClass('d-none');
    $('#text_role').empty();
    $('#text_role').append('<div id="slWrapperRoleUpdate" class="parsley-select">\
        <select class="form-control select2 role" style="width: 100%" id="update_role" name="role"\
                data-placeholder="選択してください" data-parsley-trigger-after-failure="focusout"\
                data-parsley-class-handler="#slWrapperRoleUpdate"\
                data-parsley-errors-container="#slErrorContainerRoleUpdate" required\
                data-parsley-required-message="必須項目です">\
            <option label="Select Role"></option>\
            <option value="1">管理者</option>\
            <option value="2">一般</option>\
        </select>\
        <div id="slErrorContainerRoleUpdate"></div>\
    </div>');

    $('.role').select2({
        minimumResultsForSearch: Infinity
    });

    $("#form_update #update_role").val(null).trigger('change');

    $("#form_update").parsley().reset();
}
