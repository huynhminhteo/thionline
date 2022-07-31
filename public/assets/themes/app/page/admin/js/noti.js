var table_noti;
var table_noti_element = '.table-noti';

$(function () {
    'use strict';

    // load table user
    loadTableNoti();

    $(document).on("click", "#btnView", function() {
        var $form = $('#form_add_noti')
        $form.parsley().validate();

        if ($form.parsley().isValid()) {
            var title = $('#form_add_noti #title_noti').val();
            var content = $('#form_add_noti #content_noti').val();

            refreshModalSend();
            $("#modal_send #noti_date").html(moment().format('YYYY年MM月DD日'));
            $("#modal_send #noti_title").html(title);
            $("#modal_send #noti_content").html(content.replace(/\r?\n|\r/g, "</br>"));
            $("#modal_send .block-button").removeClass('d-none');
            $("#modal_send").modal('show');
        }
    });

    $(document).on("click", "#btnClear", function() {
        $("#modal_send").modal('hide');
    });

    $(document).on("click", "#table_noti tbody tr", function() {
        var id = $(this).data('id');

        if (id) {
            var date = $(this).find('.noti-date').html();
            var title = $(this).find('.noti-title').html();
            var content = $(this).find('.noti-content').html();
            
            refreshModalSend();
            $("#modal_send #noti_date").html(moment(date).format('YYYY年MM月DD日'));
            $("#modal_send #noti_title").html(title);
            $("#modal_send #noti_content").html(content.replace(/\r?\n|\r/g, "</br>"));
            $("#modal_send").modal('show');
        }
    });

    $(document).on('click', '#btnSend', function () {
        var data = $('#form_add_noti').serialize();
        if ($('#form_add_noti').parsley().isValid()) {
            run_waitMe('.wait-containter');
            $.ajax({
                url: base_api + "/notification/add/v1?token=" + _token,
                type: "POST",
                data: data,
                success: function (response) {
                    Swal.fire({
                        text: response.msg
                    }).then(function () {
                        $('#title_noti').val('');
                        $('#content_noti').val('');
                        $("#modal_send").modal('hide');
                        $('.slim-body .slim-mainpanel .container').removeClass('d-block');
                        loadTableNoti();
                    });
                    run_waitMe('.wait-containter', true);
                },
                error: function (error) {
                    run_waitMe('.wait-containter', true);
                    Swal.fire({
                        text: error.responseJSON.msg
                    });
                }
            });
        }
    });

    $('#title_noti').keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
    });
});

var loadTableNoti = function() {
    run_waitMe('.wait-containter');
    if ($.fn.DataTable.isDataTable(table_noti_element)) {
        $(table_noti_element).DataTable().destroy();
        $('.table-user tbody').empty();
    }

    var urlRequest = base_api + "/notification/v1?token=" + _token;

    table_noti = $(table_noti_element).DataTable({
        "scrollY": "60vh",
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
                "data": "date_create",
                render: function (data, type, row) {
                    return moment(data).format('YYYY/M/D');
                }
            },
            {
                "data": "title",
            },
            {
                "data": "content"
            }
        ],
        "columnDefs": [
            {
                targets: [0],
                class: 'text-center multi-line noti-date wd-10p',
            },
            {
                targets: [1],
                class: 'multi-line noti-title wd-30p',
            },
            {
                targets: [2],
                class: ' noti-content',
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

var refreshModalSend = function() {
    $("#modal_send #noti_date").html('');
    $("#modal_send #noti_title").html('');
    $("#modal_send #noti_content").html('');
    $("#modal_send .block-button").addClass('d-none');
}