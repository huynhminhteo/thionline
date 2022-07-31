var table_contract_status_medical;
var table_contract_status_element = '.table-contract-status-medical';
var companyId = $('#id').val();

$(function () {
    'use strict';

    getInfoCompany();

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        switch (e.target.id) {
            case "info-tab": {
                $('#btnUse').removeClass('d-none');
                $('.slim-pageheader').removeClass('mg-t-15');
                $('.slim-body .slim-mainpanel .container').removeClass('d-block');
                getInfoCompany();
                break;
            }
            case "status-tab": {
                $('#btnUse').addClass('d-none');
                $('.slim-pageheader').addClass('mg-t-15');
                $('.slim-body .slim-mainpanel .container').removeClass('d-block');
                loadTableContractStatus();
                break;
            }
        }
    })

    $(document).on("click", "#btnUse", function(e) {
        e.preventDefault();
        var type = $(this).data('type');
        Swal.fire({
            text: type == " un_use " ? '利用停止してもよろしいですか？' : '利用再開してもよろしいですか？',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa',
            cancelButtonText: 'いいえ',
            confirmButtonText: 'はい',
            customClass: 'swal-wide',
        }).then(function(result) {
            if (typeof result.dismiss == 'undefined') {
                run_waitMe('.wait-containter');
                $.ajax({
                    url: base_api + "/contract/company/use/v1?token="+_token,
                    type: "POST",
                    data: {companyId: companyId, type: type},
                    success: function(response) {
                        run_waitMe('.wait-containter', true);
                        Swal.fire({
                            text: response.msg
                        }).then(function() {
                            run_waitMe('.wait-containter');
                            window.location.reload();
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

    $(document).on('click', ".export-bill", function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var company = $(this).data('company');
        var office = $(this).data('office');
        var date = $(this).data('date');
        exportBill(id, company, office, date);
    });

    $(document).on('click', ".export-receipt", function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var company = $(this).data('company');
        var office = $(this).data('office');
        var date = $(this).data('date');
        exportReceipt(id, company, office, date);
    });
});

var getInfoCompany = function() {
    run_waitMe('.wait-containter');
    $.ajax({
        url: base_api + "/contract/detail/company/v1?token="+_token,
        type: "POST",
        data: {companyId: companyId},
        success: function(response) {
            var company = response.data;
            var contract_date = moment(company.contract_date);
            var cancel_contract_date = company.cancel_contract_date ? moment(company.cancel_contract_date) : false;
            $('#form_info #corp_id').val(company.corp_id);
            $('#form_info #company_name').val(company.name);
            $('#form_info #company_name_kana').val(company.name_kana);
            $('#form_info #company_name_kana').val(company.name_kana);
            $('#form_info #office_name').val(company.office_name);
            $('#form_info #office_name_kana').val(company.office_name_kana);
            $('#form_info #postal_code').val(company.post_code);
            $('#form_info #address').val(company.address);
            $('#form_info #building').val(company.building);
            $('#form_info #phone').val(company.phone);
            $('#form_info #fax').val(company.fax);
            $('#form_info #charge').val(company.account_manager_name);
            $('#form_info #email').val(company.mail);
            $('#start_contract').html(moment(contract_date).format('YYYY年MM月DD日'));
            if (cancel_contract_date) {
                $('#end_contract').html(moment(cancel_contract_date).format('YYYY年MM月DD日'));
                $('.label-end-contract').removeClass('d-none');
            } else {
                $('#end_contract').html('');
                $('.label-end-contract').addClass('d-none');
            }
            $('.slim-body .slim-mainpanel .container').addClass('d-block');
            run_waitMe('.wait-containter', true);
        },
        error: function(error) {
            run_waitMe('.wait-containter', true);
            Swal.fire({
                text: error.responseJSON.msg
            });
        }
    });
}

var loadTableContractStatus = function() {
    run_waitMe('.wait-containter');
    if ($.fn.DataTable.isDataTable(table_contract_status_element)) {
        $(table_contract_status_element).DataTable().destroy();
        $('.table-contract-status-medical tbody').empty();
    }

    table_contract_status_medical = $(table_contract_status_element).DataTable({
        "stateSave": true,
        "autoWidth": false,
        "processing": false,
        // "serverSide": true,
        "ajax": base_api + "/contract/detail/contract/v1?companyId=" + companyId + "&token="+_token,
        "searching": false,
        "bSort" : false,
        "pagingType": "numbers",
        "dom": '<rt>',
        "language": {
            "zeroRecords": "一致する検索結果がありません",
            "emptyTable": 'テーブル内のデータなし',
        },
        "responsive": true,
        "columns": [
            {
                "data": null,
                render: function (data, type, row) {
                    return moment().year(data.contract_year).month(data.contract_month-1).format('YYYY年MM月');
                }
            },
            {
                "data": "mPlan.name",
            },
            {
                "data": "mPlan.amount",
                render: function (data, type, row) {
                    return row.is_trial == 1 ? '0円' : parseInt(data).toLocaleString() + '円';
                }
            },
            {
                "data": "status",
                render: function (data, type, row) {
                    return row.is_trial == 1 ? 'トライアル' : (data == 1 || data == 2 ? '入金済み' : '未入金');
                }
            },
            {
                render: function (data, type, row) {
                    var date = moment().year(row.contract_year).month(row.contract_month-1).format('YYYYMM');
                    return '<a class="btn btn-light rounded-7 btn-cus-hm font-bold export-bill"\
                                data-id="'+ row.id +'" data-company="'+ row.mCompany.name +'" data-office="'+ row.mCompany.office_name +'" data-date="'+ date +'">\
                                    請求書発行\
                            </a>';
                }
            },
            {
                "data": "status",
                render: function (data, type, row) {
                    var date = moment().year(row.contract_year).month(row.contract_month-1).format('YYYYMM');
                    return data ? '<a class="btn btn-light rounded-7 btn-cus-hm font-bold export-receipt"\
                                        data-id="'+ row.id +'" data-company="'+ row.mCompany.name +'" data-office="'+ row.mCompany.office_name +'" data-date="'+ date +'">\
                                            領収書発行\
                                    </a>' : '';
                }
            }
        ],
        "columnDefs": [
            {
                targets: [0, 1, 2, 3, 4, 5],
                class: 'text-center',
            },
        ],
        "initComplete": function (settings, json) {
            $('.slim-body .slim-mainpanel .container').addClass('d-block');
            run_waitMe('.wait-containter', true);
        },
        "fnCreatedRow": function (nRow, aData, iDataIndex) {
            $(nRow).attr('data-id', aData.id);
        }
    }).on('processing.dt', function (e, settings, processing) {
        if (processing) {
            run_waitMe('.wait-containter');
        } else {
            $('.slim-body .slim-mainpanel .container').addClass('d-block');
            run_waitMe('.wait-containter', true);
        }
    });
}

var exportBill = function (id, company, office, date) {
    run_waitMe('.wait-containter');
    $.ajax({
        type: "POST",
        url: base_api + "/contract/detail/export-bill/v1",
        data: {
            token: _token,
            id: id
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function(blob, status, xhr) {
            var company_name = company != null ? company + "_" : "";
            var office_name = office != null ? office + "_" : "";
            var filename = company_name + office_name + date + "請求書";
    
            if (typeof window.navigator.msSaveBlob !== 'undefined') {
                window.navigator.msSaveBlob(blob, filename);
            } else {
                var URL = window.URL || window.webkitURL;
                var downloadUrl = URL.createObjectURL(blob);
    
                if (filename) {
                    var a = document.createElement("a");
                    if (typeof a.download === 'undefined') {
                        window.location.href = downloadUrl;
                    } else {
                        a.href = downloadUrl;
                        a.download = filename;
                        document.body.appendChild(a);
                        a.click();
                    }
                } else {
                    window.location.href = downloadUrl;
                }
    
                setTimeout(function () { 
                    run_waitMe('.wait-containter', true);
                    URL.revokeObjectURL(downloadUrl);
                }, 100);
            }
        }
    });
}

var exportReceipt = function (id, company, office, date) {
    run_waitMe('.wait-containter');
    $.ajax({
        type: "POST",
        url: base_api + "/contract/detail/export-receipt/v1",
        data: {
            token: _token,
            id: id
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function(blob, status, xhr) {
            var company_name = company != null ? company + "_" : "";
            var office_name = office != null ? office + "_" : "";
            var filename = company_name + office_name + date + "領収書";
    
            if (typeof window.navigator.msSaveBlob !== 'undefined') {
                window.navigator.msSaveBlob(blob, filename);
            } else {
                var URL = window.URL || window.webkitURL;
                var downloadUrl = URL.createObjectURL(blob);
    
                if (filename) {
                    var a = document.createElement("a");
                    if (typeof a.download === 'undefined') {
                        window.location.href = downloadUrl;
                    } else {
                        a.href = downloadUrl;
                        a.download = filename;
                        document.body.appendChild(a);
                        a.click();
                    }
                } else {
                    window.location.href = downloadUrl;
                }
    
                setTimeout(function () { 
                    run_waitMe('.wait-containter', true);
                    URL.revokeObjectURL(downloadUrl);
                }, 100);
            }
        }
    });
}